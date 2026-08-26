<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Polyclinic;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPolyclinicController extends Controller
{
    public function index()
    {
        $polyclinics = Polyclinic::withCount('doctors')->orderBy('id', 'asc')->get();
        return view('admin.polyclinics.index', compact('polyclinics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description_id' => 'nullable|string',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $path = ImageOptimizer::optimizeAndStore($file, 'polyclinics', 1400, 82);
                    $gallery[] = $path;
                }
            }
        }

        Polyclinic::create([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'stethoscope',
            'gallery' => $gallery,
            'is_active' => true,
        ]);

        return back()->with('success', 'Poliklinik baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $poli = Polyclinic::findOrFail($id);

        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description_id' => 'nullable|string',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $gallery = is_array($poli->gallery) ? $poli->gallery : (json_decode($poli->gallery, true) ?? []);

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $path = ImageOptimizer::optimizeAndStore($file, 'polyclinics', 1400, 82);
                    $gallery[] = $path;
                }
            }
        }

        $poli->update([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'stethoscope',
            'gallery' => array_values(array_filter($gallery)),
        ]);

        return back()->with('success', 'Data poliklinik berhasil diperbarui!');
    }

    /**
     * Upload photos specifically into polyclinic gallery
     */
    public function uploadGallery(Request $request, $id)
    {
        $poli = Polyclinic::findOrFail($id);

        $request->validate([
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:30720',
            'image_url' => 'nullable|string|max:500',
        ], [
            'gallery_files.*.image' => 'File yang diunggah harus berupa gambar yang valid.',
            'gallery_files.*.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, WEBP, atau GIF.',
            'gallery_files.*.max' => 'Ukuran file foto tidak boleh lebih dari 30 MB.',
        ]);

        $gallery = is_array($poli->gallery) ? $poli->gallery : (json_decode($poli->gallery, true) ?? []);

        $uploadedCount = 0;
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $path = ImageOptimizer::optimizeAndStore($file, 'polyclinics', 1400, 82);
                    $gallery[] = $path;
                    $uploadedCount++;
                }
            }
        }

        if ($request->filled('image_url')) {
            $gallery[] = trim($request->input('image_url'));
            $uploadedCount++;
        }

        $poli->gallery = array_values(array_filter($gallery));
        $poli->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $uploadedCount . ' foto berhasil ditambahkan ke galeri!',
                'gallery' => $poli->gallery_images,
            ]);
        }

        return back()->with('success', $uploadedCount . ' foto berhasil ditambahkan ke galeri poliklinik ' . ($poli->name['id'] ?? ''));
    }

    /**
     * Delete a single photo from polyclinic gallery
     */
    public function deleteGalleryPhoto(Request $request, $id)
    {
        $poli = Polyclinic::findOrFail($id);

        $request->validate([
            'photo_index' => 'nullable',
            'photo_url' => 'nullable|string',
        ]);

        // If gallery has not been customized yet (is null in DB), initialize from current gallery_images
        if (is_null($poli->gallery)) {
            $gallery = $poli->gallery_images;
        } else {
            $gallery = is_array($poli->gallery) ? $poli->gallery : (json_decode($poli->gallery, true) ?? []);
        }

        if (!is_array($gallery)) {
            $gallery = [];
        }

        $deleted = false;
        $idx = $request->input('photo_index');
        $targetUrl = $request->input('photo_url');

        // Priority 1: Match by index
        if ($idx !== null && is_numeric($idx) && isset($gallery[(int)$idx])) {
            $item = $gallery[(int)$idx];
            array_splice($gallery, (int)$idx, 1);
            $deleted = true;

            // Delete storage file if local path
            if (is_string($item) && !str_starts_with($item, 'http') && !str_starts_with($item, '/') && Storage::disk('public')->exists($item)) {
                Storage::disk('public')->delete($item);
            }
        } 
        // Priority 2: Match by URL or relative path
        elseif (!empty($targetUrl)) {
            $newGallery = [];
            foreach ($gallery as $item) {
                $itemFullUrl = str_starts_with($item, 'http') ? $item : asset('storage/' . $item);
                $isMatch = ($item === $targetUrl) || 
                           ($itemFullUrl === $targetUrl) || 
                           (basename($item) === basename($targetUrl));

                if ($isMatch && !$deleted) {
                    $deleted = true;
                    if (is_string($item) && !str_starts_with($item, 'http') && !str_starts_with($item, '/') && Storage::disk('public')->exists($item)) {
                        Storage::disk('public')->delete($item);
                    }
                } else {
                    $newGallery[] = $item;
                }
            }
            if ($deleted) {
                $gallery = $newGallery;
            }
        }

        // Always save as array (even [] when all photos are deleted)
        $poli->gallery = array_values($gallery);
        $poli->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus dari galeri.',
                'gallery' => $poli->gallery_images,
            ]);
        }

        return back()->with('success', 'Foto berhasil dihapus dari galeri poliklinik!');
    }

    public function destroy($id)
    {
        $poli = Polyclinic::findOrFail($id);

        // Clean up gallery images from storage
        $gallery = is_array($poli->gallery) ? $poli->gallery : (json_decode($poli->gallery, true) ?? []);
        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                if (is_string($img) && !str_starts_with($img, 'http') && Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $poli->delete();
        return back()->with('success', 'Poliklinik berhasil dihapus!');
    }
}
