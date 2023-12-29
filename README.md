## helpers

Разворачиваем сайт:

1. запускаем миграции `php artisan migrate`
2. прописываем переменные `DEMO_ADMIN_LOGIN` и `DEMO_ADMIN_PASSWORD` в файл `.env`
3. раскомментировать строки с сидами в `repository/database/seeders/DatabaseSeeder.php`
4. запускаем seed `php artisan db:seed`
5. возвращаем комменты из п.3 (хз зачем, но так было)