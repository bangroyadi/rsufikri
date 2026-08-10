<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('galleries', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        if (empty($imageUrl)) {
            return back()->withErrors(['image' => 'Pilih file gambar untuk diupload atau masukkan URL gambar.']);
        }

        Gallery::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'description' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'category' => ['id' => $validated['category_id'] ?? 'Fasilitas', 'en' => $validated['category_id'] ?? 'Facilities'],
            'image' => $imageUrl,
            'is_active' => true,
        ]);

        return back()->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imageUrl = $gallery->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('galleries', 'public');
            $imageUrl = asset('storage/' . $path);
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
        }

        $gallery->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'description' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'category' => ['id' => $validated['category_id'] ?? 'Fasilitas', 'en' => $validated['category_id'] ?? 'Facilities'],
            'image' => $imageUrl,
        ]);

        return back()->with('success', 'Data galeri foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return back()->with('success', 'Foto galeri berhasil dihapus!');
    }
}
