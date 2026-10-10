@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="page-head">
        <a href="{{ route('posts.index') }}" class="btn btn--ghost btn--sm">
            <x-icon name="arrow-left" :size="16" /> Semua Post
        </a>
        <div class="actions">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn--sm">
                <x-icon name="edit" :size="16" /> Edit
            </a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                  onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--sm btn--danger">
                    <x-icon name="trash" :size="16" /> Hapus
                </button>
            </form>
        </div>
    </div>

    <x-card class="article" :padded="false">
        @if ($post->image_url)
            <img class="article__cover" src="{{ $post->image_url }}" alt="{{ $post->title }}">
        @endif
        <div class="card__body">
            <p class="meta">
                <span class="badge">{{ $post->author }}</span>
                <span>{{ $post->created_at->translatedFormat('d F Y, H:i') }}</span>
                @if ($post->updated_at->gt($post->created_at))
                    <span>diperbarui {{ $post->updated_at->diffForHumans() }}</span>
                @endif
            </p>
            <h1 class="article__title">{{ $post->title }}</h1>
            <div class="article__content">{!! nl2br(e($post->content)) !!}</div>
        </div>
    </x-card>
@endsection
