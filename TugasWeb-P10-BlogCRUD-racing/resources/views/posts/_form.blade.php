@php($isEdit = $post->exists)

@if ($errors->any())
    <x-alert type="error">Ada {{ $errors->count() }} isian yang perlu diperbaiki. Periksa pesan di bawah setiap field.</x-alert>
@endif

<form method="POST" action="{{ $isEdit ? route('posts.update', $post) : route('posts.store') }}" enctype="multipart/form-data" class="form" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="field {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="title">Judul</label>
        <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" maxlength="150" required
               @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
        @error('title')
            <p class="field__error" id="title-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field {{ $errors->has('body') ? 'has-error' : '' }}">
        <label for="body">Isi artikel</label>
        <textarea id="body" name="body" rows="10" required
                  @error('body') aria-invalid="true" aria-describedby="body-error" @enderror>{{ old('body', $post->body) }}</textarea>
        <p class="field__hint">Pisahkan paragraf dengan satu baris kosong.</p>
        @error('body')
            <p class="field__error" id="body-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field {{ $errors->has('image') ? 'has-error' : '' }}">
        <label for="image">Gambar sampul <span class="optional">(opsional)</span></label>

        @if ($post->image_url)
            <div class="current-image">
                <img src="{{ $post->image_url }}" alt="Gambar sampul saat ini">
                <label class="check">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))>
                    Hapus gambar ini
                </label>
            </div>
        @endif

        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
               @error('image') aria-invalid="true" aria-describedby="image-error" @enderror>
        <p class="field__hint">JPG, PNG, atau WebP. Maksimal 2 MB.{{ $post->image_url ? ' Memilih file baru akan mengganti gambar saat ini.' : '' }}</p>
        @error('image')
            <p class="field__error" id="image-error">{{ $message }}</p>
        @enderror

        <div class="preview" id="image-preview" hidden>
            <img src="" alt="Pratinjau gambar baru">
        </div>
    </div>

    <div class="form__actions">
        <a href="{{ $isEdit ? route('posts.show', $post) : route('posts.index') }}" class="btn btn--ghost">Batal</a>
        <button type="submit" class="btn btn--primary">
            <x-icon name="save" :size="16" /> {{ $submitLabel }}
        </button>
    </div>
</form>
