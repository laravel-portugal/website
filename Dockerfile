FROM ubuntu:20.04

WORKDIR /var/www/html
USER www-data

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git nano cron net-tools lsof \
            sudo supervisor nginx sqlite3 libcap2-bin \
    && mkdir -p ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update

RUN apt-get install -y php8.0-fpm php8.0-cli php8.0-dev \
       php8.0-pgsql php8.0-sqlite3 php8.0-gd \
       php8.0-curl php8.0-memcached \
       php8.0-imap php8.0-mysql php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
       php8.0-intl php8.0-readline \
       php8.0-msgpack php8.0-igbinary php8.0-ldap \
       php8.0-redis

RUN curl -sL https://deb.nodesource.com/setup_14.x | sudo bash -
RUN sudo apt -y install nodejs

RUN apt-get -y autoremove \
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN sudo update-rc.d -f nginx disable

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/php.ini /etc/php/8.0/cli/conf.d/99-laravel.ini
COPY ./docker/nginx_default.conf /etc/nginx/sites-available/default
COPY ./docker/php-fpm.conf /etc/php/8.0/fpm/php-fpm.conf
COPY ./docker/add_to_cron /temp/add_to_cron
RUN crontab /temp/add_to_cron && rm /temp/add_to_cron

ADD . /var/www/html
RUN chown -R www-data: /tmp /var/www/html/bootstrap /var/www/html/storage
RUN composer install --no-dev
RUN npm install
RUN npm run production

EXPOSE 80

CMD ["/usr/bin/supervisord"]
