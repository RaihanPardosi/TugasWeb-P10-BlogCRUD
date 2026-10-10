<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    private const PER_PAGE = 6;

    /** Daftar post + pencarian + pagination. */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString(); // supaya ?q= tidak hilang saat pindah halaman

        return view('posts.index', [
            'posts'        => $posts,
            'search'       => $search,
            'trashedCount' => Post::onlyTrashed()->count(),
        ]);
    }

    /** Form tulis post baru. */
    public function create(): View
    {
        return view('posts.create', ['post' => new Post()]);
    }

    /** Simpan post baru. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());
        unset($data['image']);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }
            $post = Post::create($data);
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal menyimpan post. Coba lagi sebentar lagi.');
        }

        return redirect()->route('posts.show', $post)
            ->with('success', "Post \"{$post->title}\" berhasil dipublikasikan.");
    }

    /** Detail post (Route Model Binding: {post} otomatis jadi objek Post). */
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    /** Form edit. */
    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    /** Update post. */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());
        unset($data['image']);

        try {
            if ($request->boolean('remove_image') && $post->image) {
                Storage::disk('public')->delete($post->image);
                $data['image'] = null;
            }

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $post->update($data);
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal memperbarui post. Coba lagi sebentar lagi.');
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post berhasil diperbarui.');
    }

    /** Hapus = soft delete (masuk tempat sampah). */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus post.');
        }

        return redirect()->route('posts.index')
            ->with('success', "Post \"{$post->title}\" dipindahkan ke tempat sampah.");
    }

    // ------------------------------------------------------------------
    // BONUS: soft delete (tempat sampah)
    // ------------------------------------------------------------------

    public function trash(): View
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(self::PER_PAGE);

        return view('posts.trash', compact('posts'));
    }

    public function restore(Post $post): RedirectResponse
    {
        try {
            $post->restore();
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal memulihkan post.');
        }

        return redirect()->route('posts.trash')
            ->with('success', "Post \"{$post->title}\" berhasil dipulihkan.");
    }

    public function forceDelete(Post $post): RedirectResponse
    {
        try {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->forceDelete();
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus permanen.');
        }

        return redirect()->route('posts.trash')
            ->with('success', 'Post dihapus permanen.');
    }

    // ------------------------------------------------------------------
    // Validasi
    // ------------------------------------------------------------------

    private function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'min:5', 'max:150'],
            'author'  => ['required', 'string', 'min:3', 'max:80'],
            'content' => ['required', 'string', 'min:20'],
            'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function messages(): array
    {
        return [
            'required'   => ':attribute wajib diisi.',
            'min.string' => ':attribute minimal :min karakter.',
            'max.string' => ':attribute maksimal :max karakter.',
            'image'      => ':attribute harus berupa file gambar.',
            'mimes'      => ':attribute harus berformat jpg, jpeg, png, atau webp.',
            'max.file'   => 'Ukuran :attribute maksimal :max KB.',
        ];
    }

    private function attributes(): array
    {
        return [
            'title'   => 'Judul',
            'author'  => 'Penulis',
            'content' => 'Isi tulisan',
            'image'   => 'Gambar',
        ];
    }
}
