<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | NGOPI.NOTES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/neo.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container topbar__inner">
            <a class="brand" href="{{ route('posts.index') }}">
                <x-icon name="coffee" :size="28" />
                <span>NGOPI<em>.NOTES</em></span>
            </a>
            <nav class="nav" aria-label="Menu utama">
                <a class="nav__link {{ request()->routeIs('posts.index', 'posts.show', 'posts.edit') ? 'is-active' : '' }}"
                   href="{{ route('posts.index') }}">Semua Post</a>
                <a class="nav__link {{ request()->routeIs('posts.trash') ? 'is-active' : '' }}"
                   href="{{ route('posts.trash') }}">Tempat Sampah</a>
                <a class="btn btn--primary btn--sm" href="{{ route('posts.create') }}">
                    <x-icon name="plus" :size="16" /> Tulis Post
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        {{-- Flash message sukses / gagal --}}
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif
        @if ($errors->any())
            <x-alert type="error">Form belum lengkap: ada {{ $errors->count() }} isian yang perlu diperbaiki.</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <span>NGOPI.NOTES</span>
            <span>Tugas Rutin 10 &mdash; Blog CRUD Laravel</span>
        </div>
    </footer>
</body>
</html>
