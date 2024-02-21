#!/bin/bash
set -e

# Загрузить последнюю версию приложения
cd /var/www/vitexopt/data/www/vitexopt.ru
git pull

npm run build >> /var/www/vitexopt/data/www/vitexopt.ru/app/Storage/log/log.txt

echo "Deployment finished!" >> app/Storage/log/log.txt
#bash echo "Deployment finished!" >> /var/www/vitexopt/data/www/vitexopt.ru/app/Storage/log/log.txt

