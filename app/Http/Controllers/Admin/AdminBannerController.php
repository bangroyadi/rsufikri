<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            // Otomatis kompres dan konversi ke format WebP kualitas tinggi (1920px Full HD, quality 85)
            $path = ImageOptimizer::optimizeAndStore(
                $request->file('image_file'),
                'banners',
                1920,
                85,
                true,
                1080
            );
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

        return back()->with('success', 'Banner homepage berhasil ditambahkan dan gambar otomatis dioptimasi!');
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
            // Hapus file gambar lama jika tersimpan lokal di storage
            self::deleteOldBannerImage($banner->image);

            // Otomatis kompres dan konversi ke format WebP kualitas tinggi (1920px Full HD, quality 85)
            $path = ImageOptimizer::optimizeAndStore(
                $request->file('image_file'),
                'banners',
                1920,
                85,
                true,
                1080
            );
            $imageUrl = 'storage/' . $path;
        } elseif ($request->filled('image')) {
            if ($banner->image !== $validated['image']) {
                self::deleteOldBannerImage($banner->image);
            }
            $imageUrl = $validated['image'];
        }

        $banner->update([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'button_text' => ['id' => $validated['button_text_id'] ?? 'Daftar Online', 'en' => $validated['button_text_id'] ?? 'Register Online'],
            'button_link' => $validated['button_link'] ?? '#',
            'image' => $imageUrl,
        ]);

        return back()->with('success', 'Banner homepage berhasil diperbarui dan gambar otomatis dioptimasi!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        self::deleteOldBannerImage($banner->image);
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Hapus file gambar banner lama dari storage disk public jika ada.
     */
    protected static function deleteOldBannerImage(?string $imagePath): void
    {
        if (empty($imagePath)) {
            return;
        }

        if (str_starts_with($imagePath, 'storage/banners/')) {
            $relativePath = str_replace('storage/', '', $imagePath);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}
