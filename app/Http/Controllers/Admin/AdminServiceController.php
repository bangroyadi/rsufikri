<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        
        // Ensure all existing services have a slug
        foreach ($services as $serv) {
            if (empty($serv->slug)) {
                $nameStr = is_array($serv->name) ? ($serv->name['id'] ?? 'layanan') : $serv->slug;
                $serv->slug = Str::slug($nameStr) ?: 'service-' . $serv->id;
                $serv->save();
            }
        }

        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:30720',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'services', 1200, 82);
            $imageUrl = 'storage/' . $path;
        }

        $maxOrder = Service::max('order') ?? 0;

        $slug = Str::slug($validated['name_id']);
        if (empty($slug)) {
            $slug = 'service-' . time();
        } else {
            $count = Service::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . time();
            }
        }

        Service::create([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => $slug,
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'briefcase-medical',
            'image' => $imageUrl,
            'order' => $maxOrder + 1,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
            'is_featured' => $request->has('is_featured') ? (bool)$request->is_featured : true,
        ]);

        return back()->with('success', 'Layanan medis berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:30720',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $imageUrl = $service->image;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'services', 1200, 82);
            $imageUrl = 'storage/' . $path;
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
        } elseif ($request->exists('image') && empty($request->input('image'))) {
            $imageUrl = null;
        }

        $slug = $service->slug;
        $nameId = $validated['name_id'];
        $currentName = is_array($service->name) ? ($service->name['id'] ?? '') : $service->name;
        if (empty($slug) || $currentName !== $nameId) {
            $slug = Str::slug($nameId);
            if (empty($slug)) {
                $slug = 'service-' . $service->id;
            } else {
                $count = Service::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug .= '-' . time();
                }
            }
        }

        $service->update([
            'name' => ['id' => $nameId, 'en' => $nameId],
            'slug' => $slug,
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'icon' => $validated['icon'] ?? $service->icon,
            'image' => $imageUrl,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : $service->is_active,
            'is_featured' => $request->has('is_featured') ? (bool)$request->is_featured : $service->is_featured,
        ]);

        return back()->with('success', 'Layanan medis berhasil diperbarui!');
    }

    /**
     * Upload photos specifically into service gallery
     */
    public function uploadGallery(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:30720',
            'image_url' => 'nullable|string|max:500',
        ], [
            'gallery_files.*.image' => 'File yang diunggah harus berupa gambar yang valid.',
            'gallery_files.*.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, WEBP, atau GIF.',
            'gallery_files.*.max' => 'Ukuran file foto tidak boleh lebih dari 30 MB.',
        ]);

        $gallery = is_array($service->gallery) ? $service->gallery : (json_decode($service->gallery, true) ?? []);

        $uploadedCount = 0;
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $path = ImageOptimizer::optimizeAndStore($file, 'services', 1400, 82);
                    $gallery[] = $path;
                    $uploadedCount++;
                }
            }
        }

        if ($request->filled('image_url')) {
            $gallery[] = trim($request->input('image_url'));
            $uploadedCount++;
        }

        $service->gallery = array_values(array_filter($gallery));
        $service->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $uploadedCount . ' foto berhasil ditambahkan ke galeri layanan!',
                'gallery' => $service->gallery_images,
            ]);
        }

        return back()->with('success', $uploadedCount . ' foto berhasil ditambahkan ke galeri layanan!');
    }

    /**
     * Delete a single photo from service gallery
     */
    public function deleteGalleryPhoto(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'photo_index' => 'nullable',
            'photo_url' => 'nullable|string',
        ]);

        // If gallery has not been customized yet, initialize from default gallery_images
        if (is_null($service->gallery)) {
            $gallery = $service->gallery_images;
        } else {
            $gallery = is_array($service->gallery) ? $service->gallery : (json_decode($service->gallery, true) ?? []);
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
        $service->gallery = array_values($gallery);
        $service->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus dari galeri.',
                'gallery' => $service->gallery_images,
            ]);
        }

        return back()->with('success', 'Foto berhasil dihapus dari galeri layanan!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Clean up gallery images from storage
        $gallery = is_array($service->gallery) ? $service->gallery : (json_decode($service->gallery, true) ?? []);
        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                if (is_string($img) && !str_starts_with($img, 'http') && Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus!');
    }
}
