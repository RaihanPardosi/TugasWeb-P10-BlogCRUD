<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $trashed = $request->boolean('trashed');

        $posts = Post::query()
            ->when($trashed, fn ($query) => $query->onlyTrashed())
            ->when($search !== '', fn ($query) => $query->search($search))
            ->latest($trashed ? 'deleted_at' : 'created_at')
            ->paginate(9)
            ->onEachSide(1)
            ->withQueryString();

        $counts = [
            'active' => Post::count(),
            'trashed' => Post::onlyTrashed()->count(),
        ];

        return view('posts.index', compact('posts', 'search', 'trashed', 'counts'));
    }

    public function create(): View
    {
        return view('posts.create', ['post' => new Post()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $data = Arr::only($validated, ['title', 'body']);
        $path = null;

        try {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $data['image'] = $path;
            }

            $post = Post::create($data);
        } catch (Throwable $e) {
            report($e);

            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with('error', 'Artikel gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $data = Arr::only($validated, ['title', 'body']);

        $oldImage = $post->image;
        $newImage = null;
        $removeImage = $request->boolean('remove_image');

        try {
            if ($request->hasFile('image')) {
                $newImage = $request->file('image')->store('posts', 'public');
                $data['image'] = $newImage;
            } elseif ($removeImage) {
                $data['image'] = null;
            }

            $post->update($data);
        } catch (Throwable $e) {
            report($e);

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            return back()
                ->withInput()
                ->with('error', 'Perubahan gagal disimpan. Silakan coba lagi.');
        }

        if ($oldImage && ($newImage || $removeImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Artikel gagal dihapus. Silakan coba lagi.');
        }

        return redirect()
            ->route('posts.index')
            ->with('success', "Artikel \"{$post->title}\" dipindahkan ke sampah.");
    }

    public function restore(Post $post): RedirectResponse
    {
        try {
            $post->restore();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Artikel gagal dipulihkan. Silakan coba lagi.');
        }

        return redirect()
            ->route('posts.index', ['trashed' => 1])
            ->with('success', "Artikel \"{$post->title}\" berhasil dipulihkan.");
    }

    public function forceDelete(Post $post): RedirectResponse
    {
        try {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->forceDelete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Artikel gagal dihapus permanen. Silakan coba lagi.');
        }

        return redirect()
            ->route('posts.index', ['trashed' => 1])
            ->with('success', "Artikel \"{$post->title}\" dihapus permanen.");
    }

    private function validatePost(Request $request): array
    {
        return $request->validate(
            [
                'title' => ['required', 'string', 'min:5', 'max:150'],
                'body' => ['required', 'string', 'min:20'],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'remove_image' => ['nullable', 'boolean'],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks.',
                'min.string' => ':attribute minimal :min karakter.',
                'max.string' => ':attribute maksimal :max karakter.',
                'image' => ':attribute harus berupa file gambar.',
                'mimes' => ':attribute harus berformat JPG, PNG, atau WebP.',
                'max.file' => ':attribute maksimal 2 MB.',
                'uploaded' => ':attribute gagal diunggah. Pastikan ukurannya tidak lebih dari 2 MB.',
            ],
            [
                'title' => 'Judul',
                'body' => 'Isi artikel',
                'image' => 'Gambar sampul',
            ]
        );
    }
}
