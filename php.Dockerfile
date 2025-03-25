FROM php:8.4-fpm

# Copy custom php config
COPY config/customphp.ini /usr/local/etc/php/conf.d/

# install dependencies
RUN apt-get update \
  && apt-get install -y --no-install-recommends libc-client-dev libkrb5-dev libpq-dev libzip-dev zip unzip git wget libpng-dev libjpeg-dev zlib1g-dev cron supervisor \
  && docker-php-ext-install mysqli pdo_pgsql pdo_mysql zip

RUN apt-get update && apt-get install -y \
  libldb-dev libldap2-dev

RUN docker-php-ext-configure ldap
RUN docker-php-ext-install ldap

# COPY ckroot.crt /usr/local/share/ca-certificates/ckroot.crt
RUN wget -P /usr/local/share/ca-certificates/ "https://ckr01.provo.edu/ckroot/ckroot.crt"
RUN chmod 644 /usr/local/share/ca-certificates/ckroot.crt && update-ca-certificates

# Create a crontab file
COPY config/crontab /etc/cron.d/my-cron-job

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/my-cron-job

# Apply cron job
RUN crontab /etc/cron.d/my-cron-job

# Create the log file to be able to run tail
RUN touch /var/log/cron.log && chmod 0644 /var/log/cron.log

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#COPY /src/tailwindcss /var/www/html/tailwindcss
#RUN chmod +x /var/www/html/tailwindcss

RUN apt-get update && apt-get install -y \
  software-properties-common \
  npm
RUN npm install npm@9.2 -g && \
  npm install n -g && \
  n latest

# Copy in Composer config
COPY /src/composer.json /var/www/html/
COPY /src/composer.lock /var/www/html/

COPY .env /root/.env

RUN composer install --no-interaction --no-ansi --no-scripts --no-progress --prefer-dist
RUN npm install -D tailwindcss

# Copy supervisor configuration
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# correct permissions
RUN chown -R www-data:www-data /var/www/html

# Start supervisor
CMD ["/usr/bin/supervisord"]
