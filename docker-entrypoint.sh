#!/bin/bash
set -e

echo "==> Starting SeminarKu deployment..."

# Buat .env dari .env.example jika belum ada
# (Railway sudah inject nilai asli via environment variables)
if [ ! -f .env ]; then
    echo "==> Creating .env from .env.example..."
    cp .env.example .env
fi

# Clear cache lama
php artisan config:clear 2>/dev/null || true
php artisan cache:clear   2>/dev/null || true

# Jalankan migrasi database
echo "==> Running database migrations..."
php artisan migrate --force

# Jalankan seeder (skip jika sudah ada data)
echo "==> Seeding database..."
php artisan db:seed --class=AdminSeeder --force 2>/dev/null \
    || echo "==> Seeder skipped (data already exists)"

# Mulai Apache
echo "==> Starting Apache..."
exec apache2-foreground
