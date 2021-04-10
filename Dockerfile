FROM driftphp/base-php8

WORKDIR /var/www

#
# Drift demo installation
#
COPY . .
RUN composer install -n --prefer-dist --no-dev --ignore-platform-reqs && \
    composer dump-autoload -n --no-dev --optimize

COPY docker/* /

# support windows
RUN dos2unix /*.sh

EXPOSE 8000
CMD ["sh", "/server-entrypoint.sh"]