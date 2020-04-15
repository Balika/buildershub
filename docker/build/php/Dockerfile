# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
FROM php:7.2-apache as common
# Copy our application
COPY . /var/www/html/
# Allow Composer to be run as root
#ENV COMPOSER_ALLOW_SUPERUSER 1

# Install composer dependencies
#RUN echo pwd: 'pwd' && echo ls: 'ls'  
# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
# In this image we will download the dependencies, but without the development dependencies.
# The dependencies are installed in the vendor folder that will be copied later into the prod image.
FROM composer as builder-prod

WORKDIR /app

COPY composer.json composer.lock /app/
RUN composer install  \
    --ignore-platform-reqs \
    --no-ansi \
    --no-dev \
    --no-autoloader \
    --no-interaction \
    --no-scripts

# We need to copy our whole application so that we can generate the autoload file inside the vendor folder.
COPY . /app
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# This is the image that will be deployed on production.
FROM common as prod

# No display errors to users in production.
#ENV DISPLAY_ERRORS="Off"


# Copy the downloaded dependencies from the builder-prod stage.
COPY --from=builder-prod /app/vendor /var/www/html/vendor

ADD vhosts.conf /etc/apache2/sites-available/000-default.conf

# Add main start script for when image launches
#ADD run.sh /run.sh
#RUN chmod 0755 /run.sh
#WORKDIR /app
EXPOSE 80
#CMD ["/run.sh"]



                                      



