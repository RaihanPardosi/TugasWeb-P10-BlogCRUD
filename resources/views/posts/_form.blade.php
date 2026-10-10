{{-- Form dipakai bersama oleh create & edit. Butuh: $post, $action --}}
@php $isEdit = $post->exists; @endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="form" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-grid form-grid--2">
        <div class="field">
            <label for="title">Judul</label>
            <input id="title" name="title" type="text" required
                   class="input @error('title') is-invalid @enderror"
                   value="{{ old('title', $post->title) }}" placeholder="Judul tulisan kamu">
            @error('title')
                <p class="field-error"><x-icon name="alert" :size="16" /> {{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="author">Penulis</label>
            <input id="author" name="author" type="text" required
                   class="input @error('author') is-invalid @enderror"
                   value="{{ old('author', $post->author) }}" placeholder="Nama penulis">
            @error('author')
                <p class="field-error"><x-icon name="alert" :size="16" /> {{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="field">
        <label for="content">Isi Tulisan</label>
        <textarea id="content" name="content" rows="9" required
                  class="input textarea @error('content') is-invalid @enderror"
                  placeholder="Tulis ceritamu di sini...">{{ old('content', $post->content) }}</textarea>
        @error('content')
            <p class="field-error"><x-icon name="alert" :size="16" /> {{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="image">Gambar Sampul <span class="optional">(opsional, maks 2 MB)</span></label>

        @if ($isEdit && $post->image_url)
            <div class="current-image">
                <img src="{{ $post->image_url }}" alt="Gambar saat ini">
                <label class="check">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))>
                    <span>Hapus gambar ini</span>
                </label>
            </div>
        @endif

        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp"
               class="input input--file @error('image') is-invalid @enderror">
        @error('image')
            <p class="field-error"><x-icon name="alert" :size="16" /> {{ $message }}</p>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn--primary">
            <x-icon name="check" :size="18" /> {{ $isEdit ? 'Simpan Perubahan' : 'Publikasikan' }}
        </button>
        <a href="{{ $isEdit ? route('posts.show', $post) : route('posts.index') }}" class="btn btn--ghost">Batal</a>
    </div>
</form>
