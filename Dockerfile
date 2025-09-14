FROM richarvey/nginx-php-fpm:latest

# Install system dependencies
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    nodejs \
    npm

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql

# Configure PHP
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/memory-limit.ini

# Set working directory
WORKDIR /var/www/html

# Install composer dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copy application files
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize --no-dev

# Install and build frontend assets
COPY package.json package-lock.json ./
RUN npm ci --legacy-peer-deps
RUN npm run build

# Set permissions
RUN chown -R nginx:nginx /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod +x /var/www/html/scripts/*

# Environment configuration
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

# Create storage link
RUN php artisan storage:link || true

CMD ["/start.sh"]
