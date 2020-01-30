#!/bin/bash

cd /var/www
rm -Rf var
php bin/console bus:consume-commands