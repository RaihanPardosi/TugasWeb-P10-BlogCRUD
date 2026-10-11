@extends('layouts.app')

@section('title', 'Tulis Artikel')

@section('content')
    <div class="narrow">
        <a href="{{ route('posts.index') }}" class="back"><x-icon name="arrow-left" :size="16" /> Kembali ke daftar</a>

        <x-card title="Tulis artikel baru">
            @include('posts._form', ['submitLabel' => 'Terbitkan'])
        </x-card>
    </div>
@endsection
