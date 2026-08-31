<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['doctors.polyclinic', 'author'])->orderBy('published_at', 'desc')->get();
        $polyclinics = Polyclinic::where('is_active', true)->with(['doctors' => fn($q) => $q->where('is_active', true)])->get();
        $doctors = Doctor::where('is_active', true)->with('polyclinic')->orderBy('name', 'asc')->get();
        return view('admin.articles.index', compact('articles', 'polyclinics', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'excerpt_id' => 'nullable|string|max:500',
            'content_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'polyclinic_ids' => 'nullable|array',
            'polyclinic_ids.*' => 'exists:polyclinics,id',
            'doctor_ids' => 'nullable|array',
            'doctor_ids.*' => 'exists:doctors,id',
        ]);

        $thumbUrl = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('articles', 'public');
            $thumbUrl = asset('storage/' . $path);
        }

        $content = !empty($validated['content_id']) ? $validated['content_id'] : ($validated['excerpt_id'] ?? '');

        $article = Article::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => Str::slug($validated['title_id']),
            'category' => ['id' => $validated['category_id'] ?? 'Artikel', 'en' => $validated['category_id'] ?? 'Article'],
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $content, 'en' => $content],
            'thumbnail' => $thumbUrl,
            'author_id' => auth()->id() ?? \App\Models\User::first()?->id ?? 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Sync doctors based on selected Polyclinics (or direct doctor_ids)
        if (!empty($validated['polyclinic_ids'])) {
            $docIds = Doctor::whereIn('polyclinic_id', $validated['polyclinic_ids'])->where('is_active', true)->pluck('id')->toArray();
            $article->doctors()->sync($docIds);
        } elseif (!empty($validated['doctor_ids'])) {
            $article->doctors()->sync($validated['doctor_ids']);
        }

        return back()->with('success', 'Artikel kesehatan berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'excerpt_id' => 'nullable|string|max:500',
            'content_id' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'polyclinic_ids' => 'nullable|array',
            'polyclinic_ids.*' => 'exists:polyclinics,id',
            'doctor_ids' => 'nullable|array',
            'doctor_ids.*' => 'exists:doctors,id',
        ]);

        $thumbUrl = $article->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('articles', 'public');
            $thumbUrl = asset('storage/' . $path);
        } elseif ($request->filled('thumbnail')) {
            $thumbUrl = $validated['thumbnail'];
        }

        $content = !empty($validated['content_id']) ? $validated['content_id'] : ($validated['excerpt_id'] ?? $article->tr('content'));

        $article->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'category' => ['id' => $validated['category_id'] ?? 'Artikel', 'en' => $validated['category_id'] ?? 'Article'],
            'excerpt' => ['id' => $validated['excerpt_id'] ?? '', 'en' => $validated['excerpt_id'] ?? ''],
            'content' => ['id' => $content, 'en' => $content],
            'thumbnail' => $thumbUrl,
        ]);

        // Sync doctors based on selected Polyclinics (or direct doctor_ids)
        if ($request->has('polyclinic_ids')) {
            $poliIds = $request->input('polyclinic_ids', []);
            $docIds = !empty($poliIds) 
                ? Doctor::whereIn('polyclinic_id', $poliIds)->where('is_active', true)->pluck('id')->toArray()
                : [];
            $article->doctors()->sync($docIds);
        } elseif ($request->has('doctor_ids')) {
            $article->doctors()->sync($request->input('doctor_ids', []));
        }

        return back()->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
