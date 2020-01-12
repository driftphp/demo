#!/bin/bash

cd /var/www/demo
rm -Rf var
php bin/console bus:consume-commands