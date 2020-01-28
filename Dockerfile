FROM driftphp/base

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