#!/bin/bash

cd /var/www/demo
rm -Rf var
php vendor/bin/server run 0.0.0.0:8000