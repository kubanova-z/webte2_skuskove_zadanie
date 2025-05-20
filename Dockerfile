# 1) Base PHP + extensions + Node.js
FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y \
      git curl zip unzip libpng-dev libonig-dev libxml2-dev \
      python3 python3-pip poppler-utils ca-certificates gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-install \
      pdo_mysql mbstring exif pcntl bcmath gd zip \
 && pip3 install --break-system-packages PyPDF2 pdf2image pillow \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

# 2) Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3) Optimize layer caching: copy only manifests and install deps
COPY composer.json composer.lock package.json package-lock.json ./
RUN composer install --no-dev --no-interaction --optimize-autoloader \
 && npm ci \
 && npm run build

# 4) Copy the rest of your application code
COPY . .

# 5) Fix permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache public/build

# 6) Expose the port your app will run on
EXPOSE 8000

# 7) By default, run the Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
