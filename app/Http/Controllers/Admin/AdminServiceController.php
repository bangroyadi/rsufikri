<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
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
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:20480',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = \App\Services\ImageOptimizer::optimizeAndStore($request->file('image_file'), 'services', 1200, 82);
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
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:20480',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $imageUrl = $service->image;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = \App\Services\ImageOptimizer::optimizeAndStore($request->file('image_file'), 'services', 1200, 82);
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

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus!');
    }
}

