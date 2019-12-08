#!/bin/bash

cd /var/www/demo
rm -Rf var
php vendor/bin/server watch 0.0.0.0:8000