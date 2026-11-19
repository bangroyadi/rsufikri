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
        // Auto-perbaiki jika ada data path lama yang mengandung casing 'App/Public' di database
        $brokenBanners = Banner::where('image', 'like', '%App/Public%')->get();
        foreach ($brokenBanners as $bb) {
            $cleaned = str_ireplace('storage/App/Public/', 'storage/', $bb->image);
            $cleaned = str_ireplace('App/Public/', '', $cleaned);
            $bb->update(['image' => $cleaned]);
        }

        $banners = Banner::orderBy('order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        // Deteksi apakah file melebihi upload_max_filesize di php.ini hosting
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
            $errCode = $_FILES['image_file']['error'];
            $maxUpload = ini_get('upload_max_filesize');
            $msg = match ($errCode) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "Ukuran file foto terlalu besar untuk server hosting (Batas upload hosting saat ini: {$maxUpload}). Silakan perkecil ukuran file atau naikkan batas upload_max_filesize di cPanel PHP Selector.",
                UPLOAD_ERR_PARTIAL => "File foto hanya terunggah sebagian karena koneksi terputus. Silakan coba lagi.",
                UPLOAD_ERR_NO_TMP_DIR => "Server hosting kehilangan folder penyimpanan sementara (missing tmp dir).",
                UPLOAD_ERR_CANT_WRITE => "Gagal menulis file ke disk server hosting (periksa izin tulis folder / disk space).",
                default => "Terjadi kendala saat upload file ke server (Kode PHP: {$errCode}).",
            };
            return back()->withInput()->withErrors(['image_file' => $msg]);
        }

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'button_text_id' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if (!empty($imageUrl)) {
            $imageUrl = str_ireplace('storage/App/Public/', 'storage/', $imageUrl);
            $imageUrl = str_ireplace('App/Public/', '', $imageUrl);
        }

        if ($request->hasFile('image_file')) {
            try {
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
            } catch (\Throwable $e) {
                return back()->withInput()->withErrors(['image_file' => 'Gagal memproses gambar banner: ' . $e->getMessage()]);
            }
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

        // Deteksi apakah file melebihi upload_max_filesize di php.ini hosting
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
            $errCode = $_FILES['image_file']['error'];
            $maxUpload = ini_get('upload_max_filesize');
            $msg = match ($errCode) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "Ukuran file foto terlalu besar untuk server hosting (Batas upload hosting saat ini: {$maxUpload}). Silakan perkecil ukuran file atau naikkan batas upload_max_filesize di cPanel PHP Selector.",
                UPLOAD_ERR_PARTIAL => "File foto hanya terunggah sebagian karena koneksi terputus. Silakan coba lagi.",
                UPLOAD_ERR_NO_TMP_DIR => "Server hosting kehilangan folder penyimpanan sementara (missing tmp dir).",
                UPLOAD_ERR_CANT_WRITE => "Gagal menulis file ke disk server hosting (periksa izin tulis folder / disk space).",
                default => "Terjadi kendala saat upload file ke server (Kode PHP: {$errCode}).",
            };
            return back()->withInput()->withErrors(['image_file' => $msg]);
        }

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'button_text_id' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $imageUrl = $banner->image;
        if ($request->hasFile('image_file')) {
            try {
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
            } catch (\Throwable $e) {
                return back()->withInput()->withErrors(['image_file' => 'Gagal memproses gambar banner: ' . $e->getMessage()]);
            }
        } elseif ($request->filled('image')) {
            $cleaned = trim($validated['image']);
            $cleaned = str_ireplace('storage/App/Public/', 'storage/', $cleaned);
            $cleaned = str_ireplace('App/Public/', '', $cleaned);

            if ($banner->image !== $cleaned) {
                self::deleteOldBannerImage($banner->image);
            }
            $imageUrl = $cleaned;
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
