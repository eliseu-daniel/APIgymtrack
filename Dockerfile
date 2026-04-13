# Use the official PHP image with Apache
FROM php:8.4-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libzip-dev \
  zip \
  unzip \
  nodejs \
  npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache DocumentRoot to Laravel's public directory and enable overrides
RUN echo '<VirtualHost *:80>\n\
  DocumentRoot /var/www/html/public\n\
  <Directory /var/www/html/public>\n\
  AllowOverride All\n\
  Require all granted\n\
  </Directory>\n\
  ErrorLog ${APACHE_LOG_DIR}/error.log\n\
  CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
  </VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files and artisan
COPY composer.json composer.lock artisan ./

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-scripts

# Copy existing application directory contents (except vendor and node_modules)
COPY . .

# Run post-install scripts
RUN composer run-script post-autoload-dump

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Generate application key if not set
RUN php artisan key:generate --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html/storage \
  && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]