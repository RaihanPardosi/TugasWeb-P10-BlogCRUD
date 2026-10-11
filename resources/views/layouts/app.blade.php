<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Artikel') | Pitlane</title>
    <link rel="icon" href="data:,">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@1,700;1,800&family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a class="skip" href="#konten">Lewati ke konten</a>

    <header class="site-header">
        <div class="container site-header__inner">
            <a href="{{ route('posts.index') }}" class="brand">
                <span class="brand__mark"><x-icon name="flag" :size="18" /></span>
                Pitlane
            </a>
            <a href="{{ route('posts.create') }}" class="btn btn--primary btn--sm">
                <x-icon name="plus" :size="16" /> Tulis artikel
            </a>
        </div>
    </header>

    <main id="konten" class="container">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">Pitlane &middot; Tugas Rutin 10 &middot; Blog CRUD Laravel</div>
    </footer>

    <script>
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-dismiss]');
            if (!btn) return;
            var box = btn.closest('.alert');
            if (box) box.remove();
        });

        document.addEventListener('submit', function (e) {
            var form = e.target;
            var message = form.getAttribute('data-confirm');
            if (message && !window.confirm(message)) {
                e.preventDefault();
                return;
            }
            setTimeout(function () {
                form.querySelectorAll('button[type="submit"]').forEach(function (b) { b.disabled = true; });
            }, 0);
        });

        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            document.querySelectorAll('button[type="submit"]').forEach(function (b) { b.disabled = false; });
        });

        (function () {
            var input = document.getElementById('image');
            var box = document.getElementById('image-preview');
            if (!input || !box) return;
            var img = box.querySelector('img');
            input.addEventListener('change', function () {
                var file = input.files && input.files[0];
                if (!file || file.type.indexOf('image/') !== 0) {
                    box.hidden = true;
                    return;
                }
                if (img.dataset.url) URL.revokeObjectURL(img.dataset.url);
                img.dataset.url = URL.createObjectURL(file);
                img.src = img.dataset.url;
                box.hidden = false;
            });
        })();
    </script>
</body>
</html>
