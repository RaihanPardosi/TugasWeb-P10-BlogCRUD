@extends('layouts.app')

@section('title', 'Semua Post')

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Blog kopi</p>
            <h1>Semua Post</h1>
        </div>

        {{-- BONUS: pencarian --}}
        <form action="{{ route('posts.index') }}" method="GET" class="search" role="search">
            <input type="search" name="q" value="{{ $search }}" class="input" placeholder="Cari judul, penulis, isi..." aria-label="Cari post">
            <button type="submit" class="btn btn--primary" aria-label="Cari"><x-icon name="search" :size="18" /></button>
            @if ($search !== '')
                <a href="{{ route('posts.index') }}" class="btn btn--ghost" aria-label="Reset pencarian"><x-icon name="x" :size="18" /></a>
            @endif
        </form>
    </div>

    <p class="summary">
        @if ($posts->total() > 0)
            Menampilkan <strong>{{ $posts->firstItem() }}&ndash;{{ $posts->lastItem() }}</strong> dari <strong>{{ $posts->total() }}</strong> post
            @if ($search !== '') untuk pencarian "<strong>{{ $search }}</strong>" @endif
        @endif
        @if ($trashedCount > 0)
            <a class="summary__trash" href="{{ route('posts.trash') }}"><x-icon name="archive" :size="16" /> {{ $trashedCount }} di tempat sampah</a>
        @endif
    </p>

    @if ($posts->count())
        <div class="grid">
            @foreach ($posts as $post)
                <x-card class="post-card" :padded="false">
                    <a href="{{ route('posts.show', $post) }}" class="post-card__media" tabindex="-1" aria-hidden="true">
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="" loading="lazy">
                        @else
                            <div class="post-card__ph"><x-icon name="coffee" :size="56" /></div>
                        @endif
                    </a>
                    <div class="card__body post-card__body">
                        <p class="meta">
                            <span class="badge">{{ $post->author }}</span>
                            <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                        </p>
                        <h2 class="post-card__title">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="post-card__excerpt">{{ \Illuminate\Support\Str::limit($post->content, 120) }}</p>

                        <div class="actions">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn--sm"><x-icon name="eye" :size="16" /> Baca</a>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn--sm btn--ghost"><x-icon name="edit" :size="16" /> Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--sm btn--danger" aria-label="Hapus post"><x-icon name="trash" :size="16" /></button>
                            </form>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        {{ $posts->links('vendor.pagination.neo') }}
    @else
        <div class="empty">
            <x-icon name="coffee" :size="48" />
            <h2>{{ $search !== '' ? 'Tidak ada hasil' : 'Belum ada post' }}</h2>
            <p>{{ $search !== '' ? 'Coba kata kunci lain.' : 'Mulai tulis post pertamamu.' }}</p>
            <a href="{{ route('posts.create') }}" class="btn btn--primary"><x-icon name="plus" :size="18" /> Tulis Post</a>
        </div>
    @endif
@endsection
