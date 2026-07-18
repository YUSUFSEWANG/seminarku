#!/bin/bash
set -e

# Generate APP_KEY jika belum ada
php artisan key:generate --force

# Cache config & routes untuk performa
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database
php artisan migrate --force

# Jalankan seeder hanya jika tabel users kosong
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1 || echo "0")
if [ "$USER_COUNT" = "0" ]; then
    echo "Seeding database..."
    php artisan db:seed --class=AdminSeeder --force
fi

# Mulai Apache
echo "Starting Apache..."
apache2-foreground
