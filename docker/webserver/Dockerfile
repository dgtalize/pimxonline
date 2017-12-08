# Use PHP 7.1
FROM php:7.1-apache

# Env variable for the project root dir
ENV PROJECT_ROOT /var/www/html

# Requirements
RUN apt-get update \
  && apt-get install -y libicu-dev \
  && docker-php-ext-install intl mbstring \
  && docker-php-ext-install pdo pdo_mysql \
  && a2enmod rewrite

# Install composer
#RUN apt-get update && \
#    apt-get install -y --no-install-recommends git zip
#RUN curl --silent --show-error https://getcomposer.org/installer | php

# forcing Docker to not use the cache when change app dependencies
#RUN mkdir -p /tmp/app
#COPY composer.json /tmp/app/composer.json
#COPY composer.lock /tmp/app/composer.lock
#
#RUN cd /tmp/app/ && composer install
#RUN cd /var/www && composer install

# Custom configurations
COPY apache2.conf /etc/apache2/apache2.conf

# Copy files from app
#COPY ../../ /var/www/html/

# Permissions on app directories
#RUN chown -R www-data:www-data /var/www/html/var/cache /var/www/html/var/logs
#RUN chown -R 777 /var/www/html/var/cache /var/www/html/var/logs

WORKDIR $PROJECT_ROOT

EXPOSE 80
EXPOSE 443

# This command takes care of copying the node_modules folder if required
#COPY docker/webserver/start.sh /opt/bin/start.sh
#CMD ["/opt/bin/start.sh"]
