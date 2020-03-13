#!/bin/sh

rm -Rf var
php bin/console event-bus:infra:create --exchange events --force
php bin/console websocket:run 0.0.0.0:8000 --route=events --exchange=events --env=prod
