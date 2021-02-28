#!/bin/bash

php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan view:cache
php artisan queue:restart
php artisan storage:link
