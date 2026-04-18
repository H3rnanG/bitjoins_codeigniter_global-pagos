FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    zip \
    gd

RUN echo "listen = 0.0.0.0:9000" > /usr/local/etc/php-fpm.d/zz-docker.conf

RUN rm -f /usr/local/etc/php-fpm.conf /usr/local/etc/php-fpm.d/* && \
    echo "[www]" >> /usr/local/etc/php-fpm.conf && \
    echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.conf && \
    echo "user = nobody" >> /usr/local/etc/php-fpm.conf && \
    echo "group = nobody" >> /usr/local/etc/php-fpm.conf && \
    echo "pm = dynamic" >> /usr/local/etc/php-fpm.conf && \
    echo "pm.max_children = 5" >> /usr/local/etc/php-fpm.conf && \
    echo "pm.start_servers = 2" >> /usr/local/etc/php-fpm.conf && \
    echo "pm.min_spare_servers = 1" >> /usr/local/etc/php-fpm.conf && \
    echo "pm.max_spare_servers = 3" >> /usr/local/etc/php-fpm.conf

# Create php.ini with error reporting adjustments
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

CMD ["php-fpm", "-F"]