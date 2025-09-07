#!/bin/bash
php artisan config:cache
php artisan cache:clear
php artisan view:cache
php artisan route:cache
php artisan optimize