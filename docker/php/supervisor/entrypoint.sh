#!/bin/sh
set -e

php-fpm && exec /usr/bin/supervisord -n -c /etc/supervisord.conf