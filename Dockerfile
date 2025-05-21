# Dockerfile
FROM php:8.2-fpm

# 1) Install system deps + PHP extensions
RUN apt-get update && apt-get install -y \
      git \
      curl \
      zip \
      unzip \
      libpng-dev \
      libxml2-dev \
      libonig-dev \
      libzip-dev \
      zlib1g-dev \
      libjpeg-dev \
      libfreetype6-dev \
      python3 \
      python3-pip \
      poppler-utils \
      ca-certificates \
      gnupg \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# 2) Install Node.js (18.x) in its own step so we see errors immediately
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs \
 && node --version \
 && npm --version

# 3) Install Python PDF libraries
RUN pip3 install --no-cache-dir PyPDF2 pdf2image pillow

WORKDIR /var/www

# 4) Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5) Copy dependency manifests and build
COPY composer.json composer.lock package.json package-lock.json ./
RUN composer install --no-dev --no-interaction --optimize-autoloader \
 && npm ci \
 && npm run build

# 6) Copy the rest of your application
COPY . .

# 7) Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/build

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
