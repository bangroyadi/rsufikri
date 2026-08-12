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
            'button_text_id' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $imageUrl = 'storage/' . $path;
        }

        $maxOrder = Banner::max('order') ?? 0;

        Banner::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'subtitle' => ['id' => '', 'en' => ''],
            'button_text' => ['id' => $validated['button_text_id'] ?? 'Daftar Online', 'en' => $validated['button_text_id'] ?? 'Register Online'],
            'button_link' => $validated['button_link'] ?? '#',
            'image' => $imageUrl,
            'order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Banner homepage berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'button_text_id' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
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
            'button_text' => ['id' => $validated['button_text_id'] ?? 'Daftar Online', 'en' => $validated['button_text_id'] ?? 'Register Online'],
            'button_link' => $validated['button_link'] ?? '#',
            'image' => $imageUrl,
        ]);

        return back()->with('success', 'Banner homepage berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
