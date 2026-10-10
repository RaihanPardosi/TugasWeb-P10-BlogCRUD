{{-- COMPONENT 2: Card. Pakai: <x-card title="Judul">isi</x-card> --}}
@props(['title' => null, 'padded' => true])
<article {{ $attributes->merge(['class' => 'card']) }}>
    @if ($title)
        <header class="card__head"><h2>{{ $title }}</h2></header>
    @endif
    @if ($padded)
        <div class="card__body">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif
</article>
