#!/bin/sh

rm -Rf var
php bin/console command-bus:infra:create --force --env=prod
php bin/console command-bus:consume-commands --env=prod

