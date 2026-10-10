<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes; // BONUS: soft delete

    protected $fillable = ['title', 'author', 'content', 'image'];

    /** URL publik gambar (null kalau tidak ada gambar). */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset('storage/' . $this->image) : null
        );
    }
}
