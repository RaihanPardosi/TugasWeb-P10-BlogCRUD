@props(['type' => 'info'])
@php
    $icon = ['success' => 'check-circle', 'error' => 'x-circle', 'info' => 'info'][$type] ?? 'info';
@endphp
<div {{ $attributes->class(['alert', "alert--{$type}"]) }} role="{{ $type === 'error' ? 'alert' : 'status' }}">
    <x-icon :name="$icon" :size="20" class="alert__icon" />
    <div class="alert__body">{{ $slot }}</div>
    <button type="button" class="alert__close" data-dismiss aria-label="Tutup pesan">
        <x-icon name="x" :size="16" />
    </button>
</div>
