FROM ubuntu:21.04

ARG WWWGROUP=50
ARG WWWUSER=50

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# BASE LAYER
RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 \
       nano cron libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu hirsute main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.0-fpm php8.0-cli php8.0-dev \
       php8.0-sqlite3 php8.0-gd \
       php8.0-curl php8.0-mysql php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath \
       php8.0-intl php8.0-readline php8.0-pcov \
       php8.0-msgpack php8.0-igbinary \
       php8.0-redis \
       mysql-client nano  \
       nginx \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# CLEANING LAYER
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Project and PHP dependencies
COPY . .
RUN composer install

# CRON
COPY ./docker/add_to_cron /tmp/add_to_cron
RUN crontab /tmp/add_to_cron ; rm /tmp/add_to_cron

# NGINX
COPY ./docker/nginx_default.conf /etc/nginx/sites-available/default

# PHP
COPY ./docker/php-fpm.conf /etc/php/8.0/fpm/php-fpm.conf
COPY ./docker/php.ini /etc/php/8.0/cli/conf.d/99-php.ini

# SERVICES
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000

CMD ["/usr/bin/supervisord"]
