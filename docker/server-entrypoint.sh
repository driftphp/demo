#!/bin/sh

php bin/console event-bus:infra:create --exchange events --force
php vendor/bin/server run 0.0.0.0:8000 --exchange events --env=prod
php bin/console event-bus:infra:drop --exchange events --force