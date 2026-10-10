@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Soft delete</p>
            <h1>Tempat Sampah</h1>
        </div>
        <a href="{{ route('posts.index') }}" class="btn btn--ghost btn--sm">
            <x-icon name="arrow-left" :size="16" /> Semua Post
        </a>
    </div>

    @if ($posts->count())
        <div class="stack">
            @foreach ($posts as $post)
                <x-card class="trash-item">
                    <div class="trash-item__info">
                        <h2 class="trash-item__title">{{ $post->title }}</h2>
                        <p class="meta">
                            <span class="badge">{{ $post->author }}</span>
                            <span>dihapus {{ $post->deleted_at->diffForHumans() }}</span>
                        </p>
                    </div>
                    <div class="actions">
                        <form action="{{ route('posts.restore', $post) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn--sm btn--ok"><x-icon name="restore" :size="16" /> Pulihkan</button>
                        </form>
                        <form action="{{ route('posts.force-delete', $post) }}" method="POST"
                              onsubmit="return confirm('Hapus permanen? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--sm btn--danger"><x-icon name="trash" :size="16" /> Hapus Permanen</button>
                        </form>
                    </div>
                </x-card>
            @endforeach
        </div>

        {{ $posts->links('vendor.pagination.neo') }}
    @else
        <div class="empty">
            <x-icon name="archive" :size="48" />
            <h2>Tempat sampah kosong</h2>
            <p>Post yang kamu hapus akan muncul di sini.</p>
        </div>
    @endif
@endsection
