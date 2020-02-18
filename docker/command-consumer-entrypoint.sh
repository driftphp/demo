#!/bin/sh

cd /var/www
rm -Rf var
php bin/console command-bus:infra:create --force
php bin/console command-bus:consume-commands

