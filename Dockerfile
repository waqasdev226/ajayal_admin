FROM php:8.2-apache

# System deps
RUN apt-get update && apt-get install -y \
  git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo pdo_mysql zip \
  && a2enmod rewrite

# Apache to point to public
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

# Install backend deps
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Build frontend
RUN npm ci && npm run build || true

# Laravel optimize
RUN php artisan storage:link || true \
 && php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

EXPOSE 80
CMD php artisan migrate --force || true && apache2-foreground
