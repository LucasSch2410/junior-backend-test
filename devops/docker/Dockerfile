FROM webdevops/php-nginx:8.2-alpine

COPY ./devops/php/custom.ini /opt/docker/etc/php/php.ini
COPY ./devops/nginx/vhost.conf /opt/docker/etc/nginx/vhost.conf
COPY ./devops/supervisor/laravel-worker.conf /opt/docker/etc/supervisor.d/laravel-worker.conf

WORKDIR /app
COPY . .
RUN apk add --no-cache nodejs npm
RUN chown -R 1000:1000 storage bootstrap/cache database

COPY ./devops/bin/init_container.sh /usr/local/bin/init_container.sh
RUN chmod +x /usr/local/bin/init_container.sh

ENTRYPOINT ["/usr/local/bin/init_container.sh"]
