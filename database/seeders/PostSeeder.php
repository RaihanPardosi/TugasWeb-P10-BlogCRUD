<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::withTrashed()->exists()) {
            return;
        }

        $posts = [
            ['Memahami alur request di Laravel', [
                'Setiap request masuk lewat public/index.php, lalu diteruskan ke router. Router mencocokkan URL dengan route yang terdaftar di routes/web.php dan menjalankan controller atau closure yang sesuai.',
                'Setelah controller selesai, hasilnya dikembalikan sebagai response. Memahami alur ini membuat proses debugging jauh lebih terarah.',
            ]],
            ['Route::resource dan tujuh method standar', [
                'Satu baris Route::resource mendaftarkan tujuh route sekaligus: index, create, store, show, edit, update, dan destroy. Setiap route otomatis mendapat nama seperti posts.index dan posts.store.',
                'Dengan konvensi ini, struktur controller menjadi seragam dan mudah ditebak oleh siapa pun yang membaca kode.',
            ]],
            ['Blade layout: satu kerangka, banyak halaman', [
                'Dengan @extends dan @yield, header, footer, dan tautan stylesheet cukup ditulis satu kali di layout. Halaman lain hanya mengisi bagian yang berbeda.',
                'Hasilnya, perubahan pada navigasi cukup dilakukan di satu file dan langsung berlaku di semua halaman.',
            ]],
            ['Validasi form yang ramah pengguna', [
                'Pesan error sebaiknya muncul tepat di bawah field yang bermasalah, bukan hanya sebagai daftar di atas form. Directive @error memudahkan hal ini.',
                'Jangan lupa mengembalikan isian lama dengan old() agar pengguna tidak perlu mengetik ulang dari awal.',
            ]],
            ['Route Model Binding tanpa find manual', [
                'Cukup menulis Post $post pada parameter controller, dan Laravel akan mengambil data berdasarkan id di URL. Jika data tidak ditemukan, respons 404 dikirim otomatis.',
                'Cara ini memangkas kode berulang dan mengurangi risiko lupa menangani data yang tidak ada.',
            ]],
            ['Kenapa setiap form memerlukan token CSRF', [
                'CSRF adalah serangan yang membuat browser pengguna mengirim request tanpa sepengetahuannya. Token pada form memastikan request benar-benar berasal dari halaman milik aplikasi.',
                'Untuk method PUT, PATCH, dan DELETE, tambahkan @method karena form HTML hanya mengenal GET dan POST.',
            ]],
            ['Soft delete: menghapus tanpa benar-benar menghapus', [
                'Dengan trait SoftDeletes, kolom deleted_at diisi alih-alih baris dihapus dari tabel. Data tetap aman dan bisa dipulihkan bila terjadi salah hapus.',
                'Untuk menghapus permanen tersedia forceDelete, yang sebaiknya disertai konfirmasi dan pembersihan file terkait.',
            ]],
            ['Mengunggah gambar dengan aman', [
                'Validasi tipe dan ukuran file sebelum disimpan. Aturan image, mimes, dan max membantu menolak file yang tidak semestinya.',
                'Simpan file di disk public lalu jalankan php artisan storage:link agar gambar dapat diakses dari browser.',
            ]],
            ['Pagination dan query string pencarian', [
                'Method paginate membagi hasil query menjadi beberapa halaman. Tambahkan withQueryString agar kata kunci pencarian tidak hilang saat pindah halaman.',
                'Tampilan tautan halaman dapat disesuaikan dengan view pagination buatan sendiri.',
            ]],
            ['Flash message untuk umpan balik singkat', [
                'Flash message disimpan di session hanya untuk satu request berikutnya. Cocok untuk memberi tahu pengguna bahwa data berhasil disimpan atau gagal diproses.',
                'Tampilkan pesan tersebut di layout agar semua halaman memakai gaya yang sama.',
            ]],
            ['Komponen Blade untuk tampilan yang konsisten', [
                'Potongan UI yang berulang, seperti alert dan card, lebih rapi dijadikan komponen. Pemanggilannya cukup berupa tag x-alert atau x-card.',
                'Slot memungkinkan isi komponen berbeda-beda tanpa menyalin markup yang sama berulang kali.',
            ]],
            ['Merapikan controller agar tetap ramping', [
                'Controller sebaiknya fokus mengatur alur: menerima request, memanggil logika, lalu mengembalikan response. Aturan validasi dan query yang panjang bisa dipindahkan ke tempat lain.',
                'Scope pada model, misalnya untuk pencarian, membuat query mudah dipakai ulang dan dibaca.',
            ]],
        ];

        $total = count($posts);

        foreach ($posts as $index => [$title, $paragraphs]) {
            $post = new Post([
                'title' => $title,
                'body' => implode("\n\n", $paragraphs),
            ]);

            $post->created_at = now()->subDays($total - $index);
            $post->updated_at = $post->created_at;
            $post->save();
        }
    }
}
