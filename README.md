# TugasWeb-P10-BlogCRUD (NGOPI.NOTES)

Blog CRUD Laravel, tema neubrutalism gelap warna kopi, responsive.
File di folder ini adalah "overlay": salin ke root project Laravel baru.

## Langkah singkat
1. composer create-project laravel/laravel TugasWeb-P10-BlogCRUD
2. Extract isi zip ini ke root project (timpa routes/web.php dan DatabaseSeeder.php)
3. Atur database di .env (SQLite bawaan juga bisa, atau MySQL)
4. php artisan migrate --seed
5. php artisan storage:link
6. php artisan serve  -> buka http://127.0.0.1:8000

## Pemetaan requirement
| # | Requirement | Lokasi |
|---|-------------|--------|
| 1 | Route::resource('posts') + named routes | routes/web.php |
| 2 | PostController resource (7 method) | app/Http/Controllers/PostController.php |
| 3 | Blade layout master @extends/@yield | resources/views/layouts/app.blade.php |
| 4 | Minimal 2 component (Alert, Card) | resources/views/components/alert.blade.php, card.blade.php |
| 5 | Validasi + error per field + old input | PostController::rules() dan posts/_form.blade.php |
| 6 | Flash message sukses/gagal | controller with('success'/'error') + layout + x-alert |
| 7 | @csrf semua form + @method PUT/DELETE | posts/_form, index, show, trash |
| 8 | Route Model Binding + pagination | show(Post $post) dst., paginate(6), vendor/pagination/neo |
| Bonus | Pencarian, soft delete, upload gambar | index (q), trash/restore/force-delete, field image |
