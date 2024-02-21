#!/bin/bash
set -e

cd /var/www/vitexopt/data/www/vitexopt.ru

npm run build

echo "Deployment finished!" >> app/Storage/log/log.txt