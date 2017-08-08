FROM phpdockerio/php71-fpm:latest

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.1-mcrypt php7.1-mysql php7.1-intl php7.1-mbstring php7.1-sqlite3\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
COPY docker/php-fpm/php-ini-overrides.ini /etc/php/7.1/fpm/conf.d/99-overrides.ini
WORKDIR "/var/www/myapp"
# Setup the Composer installer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"
COPY composer.json composer.lock ./
RUN php composer.phar install --no-dev
COPY Config/  ./Config/
COPY Controller/ ./Controller/
COPY logs/ ./logs/
COPY Model/ ./Model/
COPY Plugin/ ./Plugin/
COPY View/ ./View/
COPY webroot/ ./webroot/
RUN mkdir tmp && chmod -R 777 tmp
