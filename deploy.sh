cd /var/www/webmaster/data/www/test.24iphoto.ru

sudo git pull origin dev

php8.1 $(which composer) install --no-interaction --prefer-dist --optimize-autoloader --no-dev

php8.1 artisan migrate

php8.1 artisan optimize:clear

npm install
npm run build
