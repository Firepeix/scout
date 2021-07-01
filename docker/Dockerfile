FROM phpdockerio/php80-fpm:latest
WORKDIR "/application"
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get -y --no-install-recommends install  php8.0-mysql php8.0-pgsql php8.0-redis php8.0-sqlite3 php8.0-xdebug php8.0-bz2 php8.0-gd php8.0-igbinary php8.0-imap php8.0-ldap php8.0-odbc php8.0-soap php8.0-yaml php8.0-mongodb \
    && apt-get -y install git \
    && apt-get -y install supervisor \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENTRYPOINT /application/docker/docker-entrypoint.sh
