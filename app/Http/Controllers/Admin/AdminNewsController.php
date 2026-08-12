<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'category_id' => 'nullable|string|max:255',
            'excerpt_id' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $thumbUrl = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('news', 'public');
            $thumbUrl = asset('storage/' . $path);
        }

        News::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'category' => ['id' => $validated['category_id'] ?? 'Berita', 'en' => $validated['category_id'] ?? 'News'],
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'thumbnail' => $thumbUrl,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('success', 'Berita berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'excerpt_id' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $thumbUrl = $news->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('news', 'public');
            $thumbUrl = asset('storage/' . $path);
        } elseif ($request->filled('thumbnail')) {
            $thumbUrl = $validated['thumbnail'];
        }

        $news->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'category' => ['id' => $validated['category_id'] ?? 'Berita', 'en' => $validated['category_id'] ?? 'News'],
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'thumbnail' => $thumbUrl,
        ]);

        return back()->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus!');
    }
}
