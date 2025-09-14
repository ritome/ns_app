FROM richarvey/nginx-php-fpm:latest

# Install Node.js and npm using specific repository
RUN apk add --update --no-cache \
    git \
    && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.18/main/ \
    nodejs \
    npm

# Set working directory
WORKDIR /var/www/html

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy package files
COPY package.json package-lock.json ./
RUN npm ci --legacy-peer-deps

# Copy the rest of the application code
COPY . .

# Build assets
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
RUN php artisan storage:link

CMD ["/start.sh"]
