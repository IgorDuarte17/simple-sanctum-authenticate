#!/usr/bin/env bash
source $(dirname "$0")/colors.sh
options=(`docker container ls --filter "label=php" --format "{{.Names}}"`)

echo -e $RED_COLOR"Composer Install..."$RESET_COLOR
docker-compose -f ./docker-compose.yaml exec php-fpm composer install --no-interaction
