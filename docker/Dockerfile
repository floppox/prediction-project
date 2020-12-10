FROM php:8-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive
ARG PUID=1000
ENV PROVISION_CONTEXT "development"
ENV PUID ${PUID}
ENV COMPOSER_HOME ".composer"

RUN apt-get update -qq && apt-get install -qq -y \
    htop --no-install-recommends \
    git \
    zip unzip libzip-dev \
 && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql

# Configure volume/workdir
WORKDIR /var/www/
COPY . ./
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN chmod -R 777 storage

RUN rm -rf /root/.composer \
 && echo 'alias ll="ls -alF --color=auto"' >> ~/.bashrc

USER "1000:1000"

EXPOSE 9000
CMD ["php-fpm"]
