FROM alpine:3.10

WORKDIR /var/www

#
# Dependencies
#
RUN apk --no-cache add \
    libzip-dev zip wget gnupg curl \
    php7 php7-cgi php7-curl php7-opcache php7-zip \
    php7-bcmath php7-pcntl php7-redis php7-json \
    php7-phar php7-mbstring php7-openssl php7-xml \
    php7-tokenizer php7-dom php7-xmlwriter php7-posix \
    php7-sockets

#
# Composer
#
RUN  curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

#
# Apisearch installation
#
RUN mkdir /var/www/demo
COPY . /var/www/demo
RUN cd /var/www/demo && \
    composer install -n --prefer-dist --no-dev --no-suggest && \
    composer dump-autoload -n --no-dev --optimize

COPY docker/* /

EXPOSE 8000
CMD ["sh", "/server-entrypoint.sh"]