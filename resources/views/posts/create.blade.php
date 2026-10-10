@extends('layouts.app')

@section('title', 'Tulis Post Baru')

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Post baru</p>
            <h1>Tulis Post</h1>
        </div>
        <a href="{{ route('posts.index') }}" class="btn btn--ghost btn--sm">
            <x-icon name="arrow-left" :size="16" /> Kembali
        </a>
    </div>

    <x-card class="card--form" title="Form Post Baru">
        @include('posts._form', ['post' => $post, 'action' => route('posts.store')])
    </x-card>
@endsection
