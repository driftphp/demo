FROM driftphp/base

WORKDIR /var/www

#
# Apisearch installation
#
COPY . .
RUN composer install -n --prefer-dist --no-dev --no-suggest && \
    composer dump-autoload -n --no-dev --optimize

COPY docker/* /

# support windows
RUN dos2unix /*.sh

EXPOSE 8000
CMD ["sh", "/server-entrypoint.sh"]