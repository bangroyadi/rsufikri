<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'excerpt_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        Article::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'category' => ['id' => $validated['category_id'] ?? 'Edukasi Kesehatan', 'en' => $validated['category_id'] ?? 'Health Education'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'author_id' => Auth::id() ?? 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('success', 'Artikel Kesehatan berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'excerpt_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        $article->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'category' => ['id' => $validated['category_id'] ?? 'Edukasi Kesehatan', 'en' => $validated['category_id'] ?? 'Health Education'],
            'thumbnail' => $validated['thumbnail'] ?? null,
        ]);

        return back()->with('success', 'Data artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
