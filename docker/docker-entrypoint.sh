#!/usr/bin/env sh
NEW_RELIC_INI=$(php -r "echo(PHP_CONFIG_FILE_SCAN_DIR);")/20-newrelic.ini
NEW_RELIC_KEY=$(grep '^NEW_RELIC_KEY=' /application/.env | sed -e 's/NEW_RELIC_KEY=//')

LOGSTASH_HOST=$(grep '^LOGSTASH_HOST=' /application/.env | sed -e 's/LOGSTASH_HOST=//')
LOGSTASH_PORT=$(grep '^LOGSTASH_PORT=' /application/.env | sed -e 's/LOGSTASH_PORT=//')

if [ ! -d "/application/vendor" ]
then
    cd /application && composer install
fi

echo "starting" > /application/storage/logs/app.log
echo "starting" > /application/storage/logs/backup.log


#Install FileBeat
filebeat modules enable logstash
cp /application/src/Shared/Infrastructure/Logger/logstash.yml /etc/filebeat/modules.d/logstash.yml
sed -e "s/LOGSTASH_HOST/${LOGSTASH_HOST}/" -e "s/LOGSTASH_PORT/${LOGSTASH_PORT}/" /application/src/Shared/Infrastructure/Logger/filebeat.yml > /etc/filebeat/filebeat.yml
service filebeat start


#INSTALL NEW RELIC

sed -i \
    -e "s/newrelic.license =.*/newrelic.license=\"${NEW_RELIC_KEY}\"/" \
    -e "s/newrelic.appname[[:space:]]=[[:space:]].*/newrelic.appname=\"Scout\"/" \
    -e "s/;\?newrelic.framework =.*/newrelic.framework = \llaravel/" \
    $NEW_RELIC_INI

grep -q '^newrelic.distributed_tracing_enabled' $NEW_RELIC_INI && \
 sed -i 's/^newrelic.distributed_tracing_enabled.*/newrelic.distributed_tracing_enabled=true/' $NEW_RELIC_INI || \
 echo 'newrelic.distributed_tracing_enabled=true' >> $NEW_RELIC_INI

cd /application && php artisan migrate --seed && php artisan log:clean
exec supervisord -c /application/app/Infrastructure/Supervisor/supervisord.conf
