{{-- COMPONENT 1: Alert. Pakai: <x-alert type="success">Pesan</x-alert> --}}
@props(['type' => 'info'])
@php
    $icon = ['success' => 'check', 'error' => 'alert', 'info' => 'coffee'][$type] ?? 'coffee';
@endphp
<div {{ $attributes->merge(['class' => "alert alert--{$type}"]) }} role="{{ $type === 'error' ? 'alert' : 'status' }}">
    <x-icon :name="$icon" :size="22" />
    <div class="alert__body">{{ $slot }}</div>
    <button type="button" class="alert__close" aria-label="Tutup pesan" onclick="this.parentElement.remove()">
        <x-icon name="x" :size="18" />
    </button>
</div>
