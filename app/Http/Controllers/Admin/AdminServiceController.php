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
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'short_description_id' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('services', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        Service::create([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'briefcase-medical',
            'image' => $imageUrl,
            'is_featured' => true,
            'is_active' => true,
            'order' => Service::count() + 1,
        ]);

        return back()->with('success', 'Layanan RS berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'short_description_id' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imageUrl = $service->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('services', 'public');
            $imageUrl = asset('storage/' . $path);
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
        }

        $service->update([
            'name' => ['id' => $validated['name_id'], 'en' => $validated['name_id']],
            'slug' => Str::slug($validated['name_id']),
            'short_description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'description' => ['id' => $validated['short_description_id'] ?? '', 'en' => $validated['short_description_id'] ?? ''],
            'icon' => $validated['icon'] ?? 'briefcase-medical',
            'image' => $imageUrl,
        ]);

        return back()->with('success', 'Data layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus!');
    }
}
