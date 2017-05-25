FROM waldemarnt/cakephp

ADD composer.json

RUN composer install -d /var/www/cake-app

ADD source /var/www/cake-app