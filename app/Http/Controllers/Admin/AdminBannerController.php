<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'subtitle_id' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'button_text_id' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $imageUrl = 'storage/' . $path;
        }

        if (empty($imageUrl)) {
            return back()->withErrors(['image' => 'Pilih file gambar untuk diupload atau masukkan nama file / URL gambar.']);
        }

        Banner::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'subtitle' => ['id' => $validated['subtitle_id'] ?? '', 'en' => $validated['subtitle_id'] ?? ''],
            'image' => $imageUrl,
            'button_text' => ['id' => $validated['button_text_id'] ?? 'Daftar Online', 'en' => $validated['button_text_id'] ?? 'Online Registration'],
            'button_link' => $validated['button_link'] ?? '#kontak',
            'order' => Banner::count() + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Banner homepage berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'subtitle_id' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'button_text_id' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
        ]);

        $imageUrl = $banner->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $imageUrl = 'storage/' . $path;
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
        }

        $banner->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'subtitle' => ['id' => $validated['subtitle_id'] ?? '', 'en' => $validated['subtitle_id'] ?? ''],
            'image' => $imageUrl,
            'button_text' => ['id' => $validated['button_text_id'] ?? 'Daftar Online', 'en' => $validated['button_text_id'] ?? 'Online Registration'],
            'button_link' => $validated['button_link'] ?? '#kontak',
        ]);

        return back()->with('success', 'Data banner berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
