FROM ubuntu:21.04

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

# SETUP PUPPETEER FOR BROWSERSHOT
RUN apt-get install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget libgbm-dev libxshmfence-dev \
    && npm install --global --unsafe-perm puppeteer \
    && chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium

# CLEANING LAYER
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

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

RUN chown -R www-data: /var/www/html

EXPOSE 8000

# Project and dependencies
USER www-data
COPY --chown=www-data:www-data . .
RUN composer install
#RUN npm install ; npm run production
RUN php artisan lasso:pull

CMD ["/usr/bin/supervisord"]
