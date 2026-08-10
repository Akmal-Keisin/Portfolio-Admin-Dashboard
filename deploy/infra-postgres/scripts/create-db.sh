#!/usr/bin/env sh
# Provision an isolated role + database for one project on the shared
# Postgres container. Safe to re-run (idempotent).
#
# Usage:
#   ./scripts/create-db.sh <db_name> <db_user> <db_password> [superuser]
#
# Example:
#   ./scripts/create-db.sh myapp myapp 'S3cret!' postgres

set -e

DB_NAME="$1"
DB_USER="$2"
DB_PASS="$3"
SUPERUSER="${4:-${POSTGRES_SUPERUSER:-postgres}}"

if [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS" ]; then
  echo "Usage: $0 <db_name> <db_user> <db_password> [superuser]" >&2
  exit 1
fi

docker exec -i shared_postgres psql -U "$SUPERUSER" -v ON_ERROR_STOP=1 <<-EOSQL
  DO \$\$
  BEGIN
     IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = '${DB_USER}') THEN
        CREATE ROLE "${DB_USER}" LOGIN PASSWORD '${DB_PASS}';
     ELSE
        ALTER ROLE "${DB_USER}" WITH PASSWORD '${DB_PASS}';
     END IF;
  END
  \$\$;

  SELECT 'CREATE DATABASE "${DB_NAME}" OWNER "${DB_USER}"'
  WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = '${DB_NAME}')\gexec

  GRANT ALL PRIVILEGES ON DATABASE "${DB_NAME}" TO "${DB_USER}";
EOSQL

echo "Done. ${DB_USER} / ${DB_NAME} provisioned on shared_postgres."
