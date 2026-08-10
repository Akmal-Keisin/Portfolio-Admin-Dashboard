# #!/usr/bin/env sh
# set -e

# cd /app

# # Ensure writable dirs exist even if a volume was mounted empty
# mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache

# if [ -z "$APP_KEY" ]; then
#   echo "WARNING: APP_KEY is not set. Generate one and store it as a persistent secret:"
#   echo "  php artisan key:generate --show"
# fi

# # Postgres now runs in a separate compose stack (shared across projects), so
# # there's no `depends_on: { condition: service_healthy }` to rely on here.
# # Poll until it's reachable before running migrations.
# echo "Waiting for database at ${DB_HOST}:${DB_PORT}..."
# attempt=0
# until php -r "new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
#   attempt=$((attempt + 1))
#   if [ "$attempt" -ge 30 ]; then
#     echo "ERROR: could not reach database after 30 attempts, giving up." >&2
#     exit 1
#   fi
#   sleep 2
# done
# echo "Database is up."

# # Cache config/routes/views AT STARTUP (not at build time) so real runtime
# # env vars from docker-compose are what get baked into the cache.
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
# php artisan event:cache

# # Run pending migrations on boot. Remove if you'd rather run these as a
# # separate one-off job in your deploy pipeline.
# php artisan migrate --force

# exec "$@"

#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ ! "$(ls -A /var/www/storage)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/storage-init/. /var/www/storage
  chown -R www-data:www-data /var/www/storage
fi

# Remove storage-init directory
rm -rf /var/www/storage-init

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"
