<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminNewsController extends Controller
{
    public function index()
    {
        $newsList = News::orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('newsList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'excerpt_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        News::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'category' => ['id' => $validated['category_id'] ?? 'Kegiatan RS', 'en' => $validated['category_id'] ?? 'Hospital Event'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'author_id' => Auth::id() ?? 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('success', 'Berita RS berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'excerpt_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        $news->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'category' => ['id' => $validated['category_id'] ?? 'Kegiatan RS', 'en' => $validated['category_id'] ?? 'Hospital Event'],
            'thumbnail' => $validated['thumbnail'] ?? null,
        ]);

        return back()->with('success', 'Data berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus!');
    }
}
