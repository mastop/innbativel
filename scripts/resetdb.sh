#!/bin/sh
php artisan migrate:install --env=$1
php artisan migrate:refresh --seed --env=$1