FROM php:8.2-apache

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

RUN apt-get update && apt-get install -y git

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

COPY . .

RUN chown -R www-data:www-data /app

RUN rm /etc/apache2/sites-enabled/000-default.conf

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

RUN a2ensite 000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]