#!/bin/sh
set -e

# Docker secret -> environment variable
# -----------------------------------------------------------
# Laravel reads DB_PASSWORD from the environment; compose mounts the secret
# as a file and sets DB_PASSWORD_FILE (prod only).
# -----------------------------------------------------------
if [ -n "${DB_PASSWORD_FILE:-}" ] && [ -f "$DB_PASSWORD_FILE" ]; then
  export DB_PASSWORD="$(cat "$DB_PASSWORD_FILE")"
fi

exec "$@"
