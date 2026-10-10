@props(['name', 'size' => 20])
<svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24"
     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="square" stroke-linejoin="miter"
     aria-hidden="true" focusable="false" {{ $attributes->merge(['class' => 'icon']) }}>
    @switch($name)
        @case('plus') <path d="M12 5v14M5 12h14"/> @break
        @case('search') <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/> @break
        @case('edit') <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/> @break
        @case('trash') <path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/> @break
        @case('eye') <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/> @break
        @case('arrow-left') <path d="M19 12H5M12 19l-7-7 7-7"/> @break
        @case('arrow-right') <path d="M5 12h14M12 5l7 7-7 7"/> @break
        @case('coffee') <path d="M17 8h1a4 4 0 0 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><path d="M6 2v3M10 2v3M14 2v3"/> @break
        @case('image') <rect x="3" y="3" width="18" height="18"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/> @break
        @case('restore') <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/> @break
        @case('check') <path d="M20 6 9 17l-5-5"/> @break
        @case('x') <path d="M18 6 6 18M6 6l12 12"/> @break
        @case('alert') <path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/> @break
        @case('archive') <rect x="2" y="3" width="20" height="5"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/> @break
    @endswitch
</svg>
