# ── Base image (PHP CLI, lebih simpel dari Apache untuk Railway) ─────
FROM php:8.1-cli

# ── System dependencies ──────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev \
    libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── Composer ─────────────────────────────────────────────────────────
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# ── Working directory ─────────────────────────────────────────────────
WORKDIR /var/www/html

# ── Copy source ───────────────────────────────────────────────────────
COPY . .

# ── PHP dependencies ─────────────────────────────────────────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    --ignore-platform-reqs

# ── Node / Vite build assets ─────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm ci \
    && npm run build \
    && rm -rf node_modules

# ── Permissions ───────────────────────────────────────────────────────
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# ── Entrypoint ────────────────────────────────────────────────────────
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

CMD ["/entrypoint.sh"]
