# Admin Dashboard

## Docker CLI Guide

Open an interactive shell :

```sh
docker compose -f deploy/docker-compose.yaml run --rm php-cli php sh
```

One time running artisan command :

```sh
docker compose -f deploy/docker-compose.yaml run --rm php-cli php artisan <command>
```

examples :

```sh
docker compose -f deploy/docker-compose.yaml run --rm php-cli php artisan migrate:status
docker compose -f deploy/docker-compose.yaml run --rm php-cli php artisan tinker
docker compose -f deploy/docker-compose.yaml run --rm php-cli php artisan config:cache
```
