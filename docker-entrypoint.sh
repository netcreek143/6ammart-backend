#!/bin/bash
set -e

# Update Apache port to match Render's $PORT
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Run Migrations (Force is needed for production env)
echo "🚀 Running database migrations..."
php artisan migrate --force

# Create Storage Link (Ignore error if already exists)
echo "🔗 Linking storage..."
php artisan storage:link || true

# Start Apache
echo "✅ Starting Server..."
docker-php-entrypoint apache2-foreground
