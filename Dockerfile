FROM richarvey/nginx-php-fpm:latest

# Install Node.js and npm
RUN apk add --update nodejs npm

# Copy project files
COPY . .

# Install composer dependencies
RUN composer install --no-dev

# Install npm dependencies and build assets
RUN npm install && npm run build

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Optimize Laravel
RUN php artisan optimize

CMD ["/start.sh"]
