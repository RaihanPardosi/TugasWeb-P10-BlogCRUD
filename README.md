   composer install
   cp .env.example .env
   php artisan key:generate
   # buat database blog_crud, lalu:
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve