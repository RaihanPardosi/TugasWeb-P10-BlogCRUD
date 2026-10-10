<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Mengenal Perbedaan Kopi Arabika dan Robusta',
            'Cara Seduh V60 yang Benar di Rumah',
            'Kenapa Kopi Sumatra Punya Rasa Earthy',
            'Tips Memilih Biji Kopi Sangrai Medium',
            'French Press vs Aeropress: Mana yang Cocok?',
            'Rahasia Crema pada Espresso yang Sempurna',
            'Menggiling Biji Kopi: Halus atau Kasar?',
            'Kopi Susu Gula Aren ala Kedai Kekinian',
            'Sejarah Singkat Kopi Mandailing',
            'Berapa Suhu Air Terbaik untuk Seduh Kopi?',
            'Cold Brew: Sabar Demi Rasa Halus',
            'Mengenal Proses Pascapanen Natural dan Washed',
            'Alat Seduh Manual untuk Pemula',
            'Menyimpan Biji Kopi Agar Tetap Segar',
        ];

        $authors = ['Harun', 'Rani Barista', 'Bang Dedi', 'Sari Roastery'];

        $body = "Kopi bukan sekadar minuman pengantar kantuk. Di balik secangkir kopi ada proses panjang dari kebun, pascapanen, sangrai, sampai penyeduhan.\n\n"
              . "Pada tulisan ini kita bahas dasar-dasarnya dengan bahasa santai supaya mudah dipraktikkan di rumah maupun di kedai.\n\n"
              . "Selamat mencoba, dan jangan lupa catat resepmu supaya hasilnya konsisten.";

        foreach ($titles as $i => $title) {
            Post::create([
                'title'   => $title,
                'author'  => $authors[$i % count($authors)],
                'content' => $body,
            ]);
        }
    }
}
