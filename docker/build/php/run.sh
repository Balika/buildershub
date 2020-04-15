#!/bin/bash
mkdir -p /var/www/html/var/cache /var/www/html/var/logs
touch /var/www/html/var/logs/prod.log

chgrp -R www-data .
chmod -R g+w /var/www/html/var/cache /var/www/html/var/logs
source /etc/apache2/envvars
tail -F /var/log/apache2/* /var/www/html/var/logs/prod.log &
exec apache2 -D FOREGROUND


