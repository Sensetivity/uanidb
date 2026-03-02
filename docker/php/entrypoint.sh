#!/bin/sh
set -e

# Fix permissions on mounted volumes
if [ "$(id -u)" = "0" ]; then
    # Ensure vendor directory exists and has correct ownership
    mkdir -p /var/www/vendor
    chown -R www:www /var/www/vendor

    # Ensure node_modules directory exists and has correct ownership
    mkdir -p /var/www/node_modules
    chown -R www:www /var/www/node_modules

    # Ensure storage and cache directories are writable
    chown -R www:www /var/www/storage 2>/dev/null || true
    chown -R www:www /var/www/bootstrap/cache 2>/dev/null || true
fi

# Execute the command (php-fpm needs to run as root, it drops privileges internally)
exec "$@"
