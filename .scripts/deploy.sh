#!/bin/bash
set -e

# Загрузить последнюю версию приложения
git pull

npm run build

echo "Deployment finished!"
