#!/bin/sh
set -e

echo "-> Instalando dependências"
if [ "$APP_ENV" = "local" ]; then
    echo "-> Ambiente local detectado. Instalando dependências incluindo pacotes de desenvolvimento."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "-> Ambiente de produção detectado. Instalando dependências sem pacotes de desenvolvimento."
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

echo "-> Executando build do front"
npm install
npm run build

echo "-> Executando migrations"
php artisan migrate --force

echo "-> Otimizando cache"
php artisan optimize:clear

echo "-> Configurando storage"
php artisan storage:link

echo "-> Configurando Database"
touch database/database.sqlite
chown -R 1000:1000 /app/database
chmod -R ug+rw /app/database

echo "-> Executando o serviço principal"
/entrypoint "supervisord"
