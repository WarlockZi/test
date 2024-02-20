#!/bin/bash
set -e

# Загрузить последнюю версию приложения
git pull

npm run build

echo "Deployment finished!" >> /var/www/vitexopt/data/www/vitexopt.ru/app/Storage/log/log.txt
