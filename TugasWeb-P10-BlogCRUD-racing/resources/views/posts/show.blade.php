@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="narrow">
        <a href="{{ route('posts.index') }}" class="back"><x-icon name="arrow-left" :size="16" /> Kembali ke daftar</a>

        <article class="article">
            <header class="article__head">
                <p class="post__meta">
                    <x-icon name="timer" :size="14" />
                    {{ $post->published_on }}
                    @if ($post->updated_at->gt($post->created_at->copy()->addMinute()))
                        &middot; diperbarui {{ $post->updated_at->locale('id')->diffForHumans() }}
                    @endif
                </p>
                <h1>{{ $post->title }}</h1>
            </header>

            @if ($post->image_url)
                <img class="article__cover" src="{{ $post->image_url }}" alt="Gambar sampul {{ $post->title }}">
            @endif

            <div class="prose">
                @foreach ($post->paragraphs as $paragraph)
                    <p>{!! nl2br(e($paragraph)) !!}</p>
                @endforeach
            </div>

            <footer class="article__foot">
                <a href="{{ route('posts.edit', $post) }}" class="btn btn--ghost">
                    <x-icon name="pencil" :size="16" /> Edit
                </a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" data-confirm="Pindahkan artikel ini ke sampah?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--ghost btn--danger">
                        <x-icon name="trash" :size="16" /> Hapus
                    </button>
                </form>
            </footer>
        </article>
    </div>
@endsection
