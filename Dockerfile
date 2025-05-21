# 1. Build args & base image
ARG COMPOSER_MEMORY_LIMIT=-1
FROM php:8.2-fpm
ARG COMPOSER_MEMORY_LIMIT
ENV COMPOSER_MEMORY_LIMIT=${COMPOSER_MEMORY_LIMIT}

# 2. System deps & PHP extensions
RUN apt-get update && apt-get install -y \
      git curl zip unzip libpng-dev libxml2-dev libonig-dev \
      libzip-dev zlib1g-dev libjpeg-dev libfreetype6-dev \
      python3 python3-venv python3-pip poppler-utils \
      ca-certificates gnupg \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# 3. Node 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get update \
 && apt-get install -y nodejs \
 && node --version && npm --version

# 4. Python PDF libs in venv
RUN python3 -m venv /opt/venv \
 && /opt/venv/bin/python -m pip install --upgrade pip \
 && /opt/venv/bin/python -m pip install --no-cache-dir PyPDF2 pdf2image pillow \
 && ln -sf /opt/venv/bin/python /usr/local/bin/python3 \
 && ln -sf /opt/venv/bin/pip    /usr/local/bin/pip \
 && ln -sf /opt/venv/bin/pip    /usr/local/bin/pip3

# 5. Set workdir & Composer binary
WORKDIR /var/www
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Copy entire app (including artisan & Providers)
COPY . .

# 7. Install PHP deps (runs scripts successfully now artisan exists)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 8. Install JS deps & build
RUN npm ci && npm run build

# 9. Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/build

# 10. Expose & run
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
