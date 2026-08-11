#!/usr/bin/env sh
# Provision an isolated user + database for one project on the shared
# MariaDB container. Safe to re-run (idempotent).
#
# Usage:
#   ./scripts/create-db.sh <db_name> <db_user> <db_password> [root_password]
#
# Example:
#   ./scripts/create-db.sh myapp myapp 'S3cret!'
set -e

DB_NAME="$1"
DB_USER="$2"
DB_PASS="$3"
ROOT_PASS="${4:-${MARIADB_ROOT_PASSWORD:-}}"

if [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS" ]; then
  echo "Usage: $0 <db_name> <db_user> <db_password> [root_password]" >&2
  exit 1
fi

if [ -z "$ROOT_PASS" ]; then
  echo "Error: root password not set. Pass it as \$4 or export MARIADB_ROOT_PASSWORD." >&2
  exit 1
fi

docker exec -i shared_mariadb mariadb -uroot -p"${ROOT_PASS}" <<-EOSQL
  CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;

  CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
  ALTER USER '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';

  GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
  FLUSH PRIVILEGES;
EOSQL

echo "Done. ${DB_USER} / ${DB_NAME} provisioned on shared_mariadb."
