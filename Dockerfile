#Para conexiones a postgres
FROM registryserver.mds.cl/mds/nginx-php8.1-pg:1.1 as config
#Para conexiones a mysql:
#FROM registryserver.mds.cl/mds/nginx-php8.1-mysql:1.0 as config

ENV MY_PROJECT_ROOT /var/www/html/site
WORKDIR $MY_PROJECT_ROOT

RUN echo        "memory_limit = 1024M\\n" > /usr/local/etc/php/conf.d/site.ini \
 && mkdir /var/log/site \
 && chown www-data:www-data /var/log/site  \
 && chown www-data:www-data /usr/local/etc/php/conf.d/site.ini \
 && envsubst "\$MY_PROJECT_ROOT" < /etc/nginx/templates/site.nginx.conf.template > /etc/nginx/nginx.conf


FROM config as dev

COPY --from=composer:2.5.8 /usr/bin/composer /usr/local/bin/composer


FROM dev as compile

COPY . .

RUN "/deletegitmetadata.sh" \
 && rm -rf ci \
 && composer install --no-dev 


FROM config as deploy

COPY --from=compile --chown=www-data:www-data $MY_PROJECT_ROOT .
