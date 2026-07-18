#!/bin/bash
set -e

echo "==> Generating .env from Railway environment..."
php -r "
\$lines = [
  'APP_NAME=SeminarKu',
  'APP_ENV=' . (getenv('APP_ENV') ?: 'production'),
  'APP_KEY=' . (getenv('APP_KEY') ?: ''),
  'APP_DEBUG=false',
  'APP_URL=https://' . (getenv('RAILWAY_PUBLIC_DOMAIN') ?: 'localhost'),
  'DB_CONNECTION=mysql',
  'DB_HOST=' . (getenv('MYSQLHOST') ?: '127.0.0.1'),
  'DB_PORT=' . (getenv('MYSQLPORT') ?: '3306'),
  'DB_DATABASE=' . (getenv('MYSQLDATABASE') ?: 'railway'),
  'DB_USERNAME=' . (getenv('MYSQLUSER') ?: 'root'),
  'DB_PASSWORD=' . (getenv('MYSQL_ROOT_PASSWORD') ?: ''),
  'SESSION_DRIVER=file',
  'CACHE_DRIVER=file',
  'LOG_CHANNEL=stderr',
  'LOG_LEVEL=error',
];
file_put_contents('.env', implode(PHP_EOL, \$lines));
echo 'Generated .env' . PHP_EOL;
"

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding..."
php artisan db:seed --class=AdminSeeder --force 2>/dev/null || echo "Seeder skipped"

echo "==> Starting server on port ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
