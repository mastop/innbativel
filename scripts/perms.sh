#!/bin/sh
sudo find /var/www/ -type d -exec chmod 755 "{}" \;
sudo find /var/www -type f -exec chmod 644 "{}" \;
sudo chmod 777 /var/www/innbativel.com.br/app/storage -Rf;
sudo chmod 777 /var/www/innbativel.com.br/public/assets -Rf;
sudo chown www-data:www-data /var/www -Rf;
