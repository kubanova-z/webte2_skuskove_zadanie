FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    python3 python3-pip poppler-utils \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && pip3 install --break-system-packages PyPDF2 \
    && pip3 install --break-system-packages pdf2image \
    && pip3 install --break-system-packages pillow


WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
