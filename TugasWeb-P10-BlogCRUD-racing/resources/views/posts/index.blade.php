@extends('layouts.app')

@section('title', $trashed ? 'Sampah' : 'Artikel')

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $trashed ? 'Sampah' : 'Semua artikel' }}</h1>
            <p class="lead">
                {{ $trashed ? 'Artikel yang dihapus bisa dipulihkan atau dihapus permanen.' : 'Kumpulan catatan dan tulisan yang sudah diterbitkan.' }}
            </p>
        </div>
    </div>

    <div class="toolbar">
        <form method="GET" action="{{ route('posts.index') }}" class="search" role="search">
            @if ($trashed)
                <input type="hidden" name="trashed" value="1">
            @endif
            <div class="search__field">
                <x-icon name="search" :size="18" class="search__icon" />
                <label class="sr-only" for="q">Cari artikel</label>
                <input id="q" type="search" name="q" value="{{ $search }}" placeholder="Cari judul atau isi artikel">
            </div>
            <button type="submit" class="btn btn--primary">Cari</button>
        </form>

        <nav class="tabs" aria-label="Filter artikel">
            <a href="{{ route('posts.index', array_filter(['q' => $search])) }}" class="tab {{ $trashed ? '' : 'is-active' }}">
                Aktif <span class="tab__count">{{ $counts['active'] }}</span>
            </a>
            <a href="{{ route('posts.index', array_filter(['q' => $search, 'trashed' => 1])) }}" class="tab {{ $trashed ? 'is-active' : '' }}">
                Sampah <span class="tab__count">{{ $counts['trashed'] }}</span>
            </a>
        </nav>
    </div>

    @if ($search !== '')
        <p class="result-note">
            {{ $posts->total() }} hasil untuk &ldquo;{{ $search }}&rdquo;.
            <a href="{{ route('posts.index', array_filter(['trashed' => $trashed ? 1 : null])) }}">Hapus pencarian</a>
        </p>
    @endif

    @if ($posts->count())
        <div class="grid">
            @foreach ($posts as $post)
                <x-card class="post">
                    <x-slot:media>
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="" loading="lazy">
                        @else
                            <div class="placeholder"><x-icon name="image" :size="28" /></div>
                        @endif
                    </x-slot:media>

                    <p class="post__meta">
                        <x-icon name="timer" :size="14" />
                        @if ($trashed)
                            Dihapus {{ $post->deleted_at->locale('id')->diffForHumans() }}
                        @else
                            {{ $post->published_on }}
                        @endif
                    </p>
                    <h2 class="post__title">
                        @if ($trashed)
                            {{ $post->title }}
                        @else
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        @endif
                    </h2>
                    <p class="post__excerpt">{{ $post->excerpt }}</p>

                    <x-slot:footer>
                        <div class="actions">
                            @if ($trashed)
                                <form method="POST" action="{{ route('posts.restore', $post) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn--ghost btn--sm">
                                        <x-icon name="restore" :size="16" /> Pulihkan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('posts.force-delete', $post) }}" data-confirm="Hapus permanen artikel ini? Tindakan ini tidak bisa dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--ghost btn--sm btn--danger">
                                        <x-icon name="trash" :size="16" /> Hapus permanen
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('posts.show', $post) }}" class="btn btn--ghost btn--sm">
                                    <x-icon name="eye" :size="16" /> Baca
                                </a>
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn--ghost btn--sm">
                                    <x-icon name="pencil" :size="16" /> Edit
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" data-confirm="Pindahkan artikel ini ke sampah?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--ghost btn--sm btn--danger" aria-label="Hapus artikel {{ $post->title }}">
                                        <x-icon name="trash" :size="16" /> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <div class="pager">
            <p class="pager__info">Menampilkan {{ $posts->firstItem() }}&ndash;{{ $posts->lastItem() }} dari {{ $posts->total() }} artikel</p>
            {{ $posts->links('pagination.custom') }}
        </div>
    @else
        <div class="empty">
            <x-icon name="file" :size="36" />
            @if ($search !== '')
                <h2>Tidak ada hasil</h2>
                <p>Coba kata kunci lain atau periksa ejaan.</p>
            @elseif ($trashed)
                <h2>Sampah kosong</h2>
                <p>Artikel yang kamu hapus akan muncul di sini.</p>
            @else
                <h2>Belum ada artikel</h2>
                <p>Mulai dengan menulis artikel pertamamu.</p>
                <a href="{{ route('posts.create') }}" class="btn btn--primary"><x-icon name="plus" :size="16" /> Tulis artikel</a>
            @endif
        </div>
    @endif
@endsection
