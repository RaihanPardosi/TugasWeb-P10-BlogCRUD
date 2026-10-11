<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'body', 'image'];

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('body', 'like', "%{$term}%");
        });
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? asset('storage/'.$this->image) : null);
    }

    protected function excerpt(): Attribute
    {
        return Attribute::get(
            fn () => Str::limit(preg_replace('/\s+/', ' ', trim($this->body)), 130)
        );
    }

    protected function paragraphs(): Attribute
    {
        return Attribute::get(fn () => preg_split('/\R{2,}/', trim($this->body)) ?: []);
    }

    protected function publishedOn(): Attribute
    {
        return Attribute::get(
            fn () => $this->created_at
                ?->copy()
                ->timezone('Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('d F Y')
        );
    }
}
