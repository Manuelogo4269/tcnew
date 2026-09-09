# Stage 1: Build Frontend Assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY ecommerce-saas/package*.json ./
RUN npm ci || npm install
COPY ecommerce-saas/resources ./resources
COPY ecommerce-saas/public ./public
COPY ecommerce-saas/vite.config.js ./
RUN npm run build

# Stage 2: Production PHP Apache
FROM php:8.2-apache AS production

# Install System Dependencies & PHP Extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_sqlite \
        pdo_mysql \
        pdo_pgsql \
        gd \
        zip \
        intl \
        bcmath \
        opcache \
    && a2enmod rewrite headers \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY ecommerce-saas/ .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Copy and setup entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configure Apache DocumentRoot to Laravel public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Disable Apache default /icons/ alias so /icons/ requests reach Laravel public/icons
RUN a2disconf alias 2>/dev/null || true && \
    sed -ri 's!^(\s*Alias\s+/icons/)!# \1!g' /etc/apache2/mods-available/alias.conf /etc/apache2/mods-enabled/alias.conf 2>/dev/null || true

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80 8080

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
