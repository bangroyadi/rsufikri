<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'badge' => 'nullable|string|max:100',
            'original_price' => 'nullable|string|max:100',
            'promo_price' => 'nullable|string|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:30720',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'features_text' => 'nullable|string',
            'terms_conditions_id' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'whatsapp_number' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'title_id.required' => 'Judul promo wajib diisi.',
            'category.required' => 'Kategori promo wajib dipilih.',
            'image_file.max' => 'Ukuran file gambar tidak boleh melebihi 30 MB.',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'promos', 1200, 85);
            $imageUrl = 'storage/' . $path;
        }

        // Parse features from newline string
        $features = [];
        if (!empty($request->features_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->features_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $features[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        $slug = Str::slug($validated['title_id']);
        if (empty($slug)) {
            $slug = 'promo-' . time();
        } else {
            $count = Promo::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . time();
            }
        }

        $maxOrder = Promo::max('order') ?? 0;

        Promo::create([
            'title' => ['id' => $validated['title_id'], 'en' => $validated['title_id']],
            'slug' => $slug,
            'category' => $validated['category'],
            'badge' => $validated['badge'] ?? null,
            'original_price' => $validated['original_price'] ?? null,
            'promo_price' => $validated['promo_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'image' => $imageUrl,
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'features' => $features,
            'terms_conditions' => ['id' => $validated['terms_conditions_id'] ?? '', 'en' => $validated['terms_conditions_id'] ?? ''],
            'valid_until' => $validated['valid_until'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? '089678211575',
            'is_featured' => $request->has('is_featured') ? (bool)$request->is_featured : false,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
            'order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Paket promo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'badge' => 'nullable|string|max:100',
            'original_price' => 'nullable|string|max:100',
            'promo_price' => 'nullable|string|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:30720',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'features_text' => 'nullable|string',
            'terms_conditions_id' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'whatsapp_number' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $imageUrl = $promo->image;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'promos', 1200, 85);
            $imageUrl = 'storage/' . $path;
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
        } elseif ($request->exists('image') && empty($request->input('image'))) {
            $imageUrl = null;
        }

        // Parse features
        $features = [];
        if (!empty($request->features_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->features_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $features[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        $slug = $promo->slug;
        $titleId = $validated['title_id'];
        $currentTitle = is_array($promo->title) ? ($promo->title['id'] ?? '') : $promo->title;
        if (empty($slug) || $currentTitle !== $titleId) {
            $slug = Str::slug($titleId);
            if (empty($slug)) {
                $slug = 'promo-' . $promo->id;
            } else {
                $count = Promo::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug .= '-' . time();
                }
            }
        }

        $promo->update([
            'title' => ['id' => $titleId, 'en' => $titleId],
            'slug' => $slug,
            'category' => $validated['category'],
            'badge' => $validated['badge'] ?? null,
            'original_price' => $validated['original_price'] ?? null,
            'promo_price' => $validated['promo_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'image' => $imageUrl,
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['description_id'] ?? '', 'en' => $validated['description_id'] ?? ''],
            'features' => $features,
            'terms_conditions' => ['id' => $validated['terms_conditions_id'] ?? '', 'en' => $validated['terms_conditions_id'] ?? ''],
            'valid_until' => $validated['valid_until'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? '089678211575',
            'is_featured' => $request->has('is_featured') ? (bool)$request->is_featured : $promo->is_featured,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : $promo->is_active,
        ]);

        return back()->with('success', 'Paket promo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);

        if (!empty($promo->image) && !str_starts_with($promo->image, 'http')) {
            $storagePath = ltrim($promo->image, '/');
            if (str_starts_with($storagePath, 'storage/')) {
                $storagePath = substr($storagePath, 8);
            }
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
        }

        $promo->delete();
        return back()->with('success', 'Paket promo berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();

        return back()->with('success', 'Status aktif promo berhasil diubah!');
    }
}
