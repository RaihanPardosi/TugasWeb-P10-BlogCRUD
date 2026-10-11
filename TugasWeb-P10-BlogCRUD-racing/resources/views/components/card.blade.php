@props(['title' => null])
<article {{ $attributes->class(['card']) }}>
    @isset($media)
        <div class="card__media">{{ $media }}</div>
    @endisset

    @if ($title)
        <header class="card__head">
            <h2 class="card__title">{{ $title }}</h2>
        </header>
    @endif

    <div class="card__body">{{ $slot }}</div>

    @isset($footer)
        <footer class="card__foot">{{ $footer }}</footer>
    @endisset
</article>
