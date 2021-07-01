#!/usr/bin/env sh
if [ ! -d "/application/vendor" ]
then
    cd /application && composer install
fi

cd /application && php artisan migrate --seed
exec supervisord -c /application/app/Infrastructure/Supervisor/supervisord.conf
