#!/bin/sh

rm -Rf var
php bin/console event-bus:infra:create --exchange events --force --env=prod
php vendor/bin/server watch 0.0.0.0:8000 --exchange events --env=prod
