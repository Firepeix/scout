#!/usr/bin/env sh
NEW_RELIC_INI=$(php -r "echo(PHP_CONFIG_FILE_SCAN_DIR);")/20-newrelic.ini
NEW_RELIC_KEY=$(grep '^NEW_RELIC_KEY=' /application/.env | sed -e 's/NEW_RELIC_KEY=//')

if [ ! -d "/application/vendor" ]
then
    cd /application && composer install
fi

#INSTALL NEW RELIC

sed -i \
    -e "s/newrelic.license =.*/newrelic.license=\"${NEW_RELIC_KEY}\"/" \
    -e "s/newrelic.appname[[:space:]]=[[:space:]].*/newrelic.appname=\"Scout\"/" \
    -e "s/;\?newrelic.framework =.*/newrelic.framework = \laravel/" \
    $NEW_RELIC_INI

grep -q '^newrelic.distributed_tracing_enabled' $NEW_RELIC_INI && \
 sed -i 's/^newrelic.distributed_tracing_enabled.*/newrelic.distributed_tracing_enabled=true/' $NEW_RELIC_INI || \
 echo 'newrelic.distributed_tracing_enabled=true' >> $NEW_RELIC_INI

cd /application && php artisan migrate --seed
exec supervisord -c /application/app/Infrastructure/Supervisor/supervisord.conf
