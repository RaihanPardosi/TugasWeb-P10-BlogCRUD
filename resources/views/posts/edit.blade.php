@extends('layouts.app')

@section('title', 'Edit: ' . $post->title)

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Edit post</p>
            <h1>Ubah Tulisan</h1>
        </div>
        <a href="{{ route('posts.show', $post) }}" class="btn btn--ghost btn--sm">
            <x-icon name="arrow-left" :size="16" /> Kembali
        </a>
    </div>

    <x-card class="card--form" :title="'Edit: ' . \Illuminate\Support\Str::limit($post->title, 50)">
        @include('posts._form', ['post' => $post, 'action' => route('posts.update', $post)])
    </x-card>
@endsection
