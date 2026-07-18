# ── Base image ──────────────────────────────────────────────────────
FROM php:8.1-apache

# ── Install system dependencies ─────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev \
    libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── Enable Apache mod_rewrite (untuk Laravel routing) ───────────────
RUN a2enmod rewrite

# ── Konfigurasi Apache DocumentRoot ke /public ──────────────────────
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# ── Allow .htaccess override ─────────────────────────────────────────
RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

# ── Install Composer ─────────────────────────────────────────────────
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# ── Set working directory ────────────────────────────────────────────
WORKDIR /var/www/html

# ── Copy source code ─────────────────────────────────────────────────
COPY . .

# ── Install PHP dependencies (production only) ───────────────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    --ignore-platform-reqs

# ── Build assets ─────────────────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm ci \
    && npm run build \
    && rm -rf node_modules

# ── Permissions ──────────────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ── Startup script ───────────────────────────────────────────────────
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Railway sets PORT dynamically
ENV PORT=80
EXPOSE ${PORT}

CMD ["/usr/local/bin/docker-entrypoint.sh"]
