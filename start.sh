#/usr/bin/bash
NEW_RELIC_INI=$(php -r "echo(PHP_CONFIG_FILE_SCAN_DIR);")/20-newrelic.ini

head -n 64 $NEW_RELIC_INI
