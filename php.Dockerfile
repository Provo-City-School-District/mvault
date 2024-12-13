FROM php:8.4-fpm

# Copy custom php config
COPY config/customphp.ini /usr/local/etc/php/conf.d/

# install dependencies
RUN apt-get update \
  && apt-get install -y --no-install-recommends libc-client-dev libkrb5-dev libpq-dev libzip-dev zip unzip git wget libpng-dev libjpeg-dev zlib1g-dev cron \
  && docker-php-ext-install mysqli pdo_pgsql pdo_mysql zip

RUN apt-get update && apt-get install -y \
  libldb-dev libldap2-dev

RUN docker-php-ext-configure ldap
RUN docker-php-ext-install ldap

# COPY ckroot.crt /usr/local/share/ca-certificates/ckroot.crt
RUN wget -P /usr/local/share/ca-certificates/ "https://ckr01.provo.edu/ckroot/ckroot.crt"
RUN chmod 644 /usr/local/share/ca-certificates/ckroot.crt && update-ca-certificates

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#COPY /src/tailwindcss /var/www/html/tailwindcss
#RUN chmod +x /var/www/html/tailwindcss

RUN apt-get update && apt-get install -y \
    software-properties-common \
    npm
RUN npm install npm@latest -g && \
    npm install n -g && \
    n latest

# Copy in Composer config
COPY /src/composer.json /var/www/html/
COPY /src/composer.lock /var/www/html/

COPY .env /var/www/html/

RUN composer install --no-interaction --no-ansi --no-scripts --no-progress --prefer-dist
RUN npm install -D tailwindcss
