# Admin Dashboard

## Deployment environments

Three stacks under `deploy/` mirror the `/opt/infra` environments: each joins
the networks of its infra counterpart and connects to that environment's
MariaDB.

| | local | dev | prod |
|---|---|---|---|
| Infra DB | `/opt/infra/mariadb/dev` | `/opt/infra/mariadb/dev` | `/opt/infra/mariadb/prod` |
| Database | `private_portfolio` | `private_portfolio` | `prod` |
| Infra proxy | `/opt/infra/traefik/local` | `/opt/infra/traefik/dev` | `/opt/infra/traefik/prod` |
| App URL | http://portfolio-admin.localhost | http://portfolio-admin.dev.akmalkeisin.com | http://portfolio-admin.akmalkeisin.com |
| Config | hardcoded (throwaway) | `deploy/dev/.env` | `deploy/prod/.env` + `deploy/prod/secrets/db_password.txt` |

`local` and `dev` share the running `/opt/infra/mariadb/dev`, because
`mariadb/local` and `mariadb/dev` cannot both bind host port 3306.

### local

```sh
docker network create db-net        # once per host
docker network create traefik-proxy # once per host
(cd /opt/infra/mariadb/dev && docker compose up -d)
(cd /opt/infra/traefik/local && docker compose up -d)
docker compose -f deploy/local/docker-compose.yaml up -d --build
```

### dev

```sh
docker network create db-net        # once per host
cp deploy/dev/.env.example deploy/dev/.env   # then set APP_KEY
(cd /opt/infra/mariadb/dev && docker compose up -d)
(cd /opt/infra/traefik/dev && docker compose up -d)
docker compose -f deploy/dev/docker-compose.yaml up -d --build
```

### prod

```sh
cp deploy/prod/.env.example deploy/prod/.env  # then set APP_KEY
mkdir -p deploy/prod/secrets
echo 'same password as /opt/infra/mariadb/prod/secrets/db_password.txt' \
  > deploy/prod/secrets/db_password.txt
chmod 600 deploy/prod/secrets/db_password.txt
(cd /opt/infra/mariadb/prod && docker compose up -d)
(cd /opt/infra/traefik/prod && docker compose up -d)
docker compose -f deploy/prod/docker-compose.yaml up -d --build
```

Generate an `APP_KEY` with `php artisan key:generate --show`. Start the infra
stack before the app stack: migrations run on php-fpm start.

If `mariadb_dev` predates the `MARIADB_USER` env in `/opt/infra/mariadb/dev`
(MariaDB only creates it on first volume init), create it once:

```sql
CREATE USER IF NOT EXISTS 'dev_user'@'%' IDENTIFIED BY 'dev_user_password';
GRANT ALL PRIVILEGES ON private_portfolio.* TO 'dev_user'@'%';
FLUSH PRIVILEGES;
```

## Docker CLI Guide

Open an interactive shell:

```sh
docker compose -f deploy/{environment}/docker-compose.yaml run --rm php-cli
```

One time running artisan command:

```sh
docker compose -f deploy/{environment}/docker-compose.yaml run --rm php-cli php artisan <command>
```

examples:

```sh
docker compose -f deploy/{environment}/docker-compose.yaml run --rm php-cli php artisan migrate:status
docker compose -f deploy/{environment}/docker-compose.yaml run --rm php-cli php artisan tinker
docker compose -f deploy/{environment}/docker-compose.yaml run --rm php-cli php artisan config:cache
```
