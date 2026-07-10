#!/bin/sh

set -e

cd /app

if [ ! -d "/app/vendor" ]; then
    composer install
fi

exec "$@"