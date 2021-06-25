#/usr/bin/bash

killall supervisord
supervisord -c /etc/supervisor/supervisord.conf
