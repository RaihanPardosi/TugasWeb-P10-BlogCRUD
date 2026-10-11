@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <div class="narrow">
        <a href="{{ route('posts.show', $post) }}" class="back"><x-icon name="arrow-left" :size="16" /> Kembali ke artikel</a>

        <x-card title="Edit artikel">
            @include('posts._form', ['submitLabel' => 'Simpan perubahan'])
        </x-card>
    </div>
@endsection
