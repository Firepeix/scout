#!/usr/bin/env sh
NEW_RELIC_INI=$(php -r "echo(PHP_CONFIG_FILE_SCAN_DIR);")/20-newrelic.ini

if [ ! -d "/application/vendor" ]; then
  cd /application && composer install
fi

echo "starting" >/application/storage/logs/app.log
echo "starting" >/application/storage/logs/backup.log
service php8.0-fpm start
if [ $APP_ENV != 'local' ]; then
  sed -i \
    -e "s/newrelic.license =.*/newrelic.license=\"${NEW_RELIC_KEY}\"/" \
    -e "s/newrelic.appname[[:space:]]=[[:space:]].*/newrelic.appname=\"Scout\"/" \
    -e "s/;\?newrelic.framework =.*/newrelic.framework = \llaravel/" \
    $NEW_RELIC_INI

  grep -q '^newrelic.distributed_tracing_enabled' $NEW_RELIC_INI &&
    sed -i 's/^newrelic.distributed_tracing_enabled.*/newrelic.distributed_tracing_enabled=true/' $NEW_RELIC_INI ||
    echo 'newrelic.distributed_tracing_enabled=true' >> $NEW_RELIC_INI
  cd /application && php artisan migrate --seed --force && php artisan log:clean
  if [ ! -d "/application/app/Infrastructure/Supervisor/services/scout-worker.conf" ]; then
    cp /application/app/Infrastructure/Supervisor/scout-worker.conf /application/app/Infrastructure/Supervisor/services/scout-worker.conf
  fi
  exec supervisord -c /application/app/Infrastructure/Supervisor/supervisord.conf
else
  exec supervisord -c /application/app/Infrastructure/Supervisor/supervisord.conf
fi
