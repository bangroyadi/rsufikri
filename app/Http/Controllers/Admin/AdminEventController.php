<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalEvent;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = HospitalEvent::orderBy('order', 'asc')->orderBy('event_date', 'asc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:50',
            'end_time' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|string|max:100',
            'price_type' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'speakers_text' => 'nullable|string',
            'benefits_text' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:30720',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'registration_link' => 'nullable|string|max:500',
            'whatsapp_contact' => 'nullable|string|max:50',
            'status' => 'required|string|in:upcoming,ongoing,completed',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'title_id.required' => 'Judul agenda event wajib diisi.',
            'category.required' => 'Kategori event wajib dipilih.',
            'event_date.required' => 'Tanggal pelaksanaan event wajib diisi.',
            'location.required' => 'Lokasi pelaksanaan event wajib diisi.',
            'image_file.max' => 'Ukuran file poster/flyer tidak boleh melebihi 30 MB.',
        ]);

        $imageUrl = $validated['image'] ?? null;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'events', 1200, 85);
            $imageUrl = 'storage/' . $path;
        }

        // Parse speakers from lines "Nama | Spesialisasi" or simple names
        $speakers = [];
        if (!empty($request->speakers_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->speakers_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    if (str_contains($trimmed, '|')) {
                        $parts = explode('|', $trimmed, 2);
                        $speakers[] = [
                            'name' => trim($parts[0]),
                            'role' => trim($parts[1] ?? ''),
                        ];
                    } else {
                        $speakers[] = [
                            'name' => ltrim($trimmed, '-•* '),
                            'role' => 'Narasumber',
                        ];
                    }
                }
            }
        }

        // Parse benefits from newline string
        $benefits = [];
        if (!empty($request->benefits_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->benefits_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $benefits[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        $slug = Str::slug($validated['title_id']);
        if (empty($slug)) {
            $slug = 'event-' . time();
        } else {
            $count = HospitalEvent::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . time();
            }
        }

        $maxOrder = HospitalEvent::max('order') ?? 0;

        HospitalEvent::create([
            'title' => [
                'id' => $validated['title_id'],
                'en' => $request->title_en ?: $validated['title_id'],
            ],
            'slug' => $slug,
            'category' => $validated['category'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'],
            'speakers' => $speakers,
            'quota' => $validated['quota'] ?? null,
            'price_type' => $validated['price_type'] ?: 'Gratis / Free',
            'price' => $validated['price'] ?? null,
            'benefits' => $benefits,
            'image' => $imageUrl,
            'short_description' => [
                'id' => $validated['short_description_id'] ?? '',
                'en' => $request->short_description_en ?? '',
            ],
            'description' => [
                'id' => $validated['description_id'] ?? '',
                'en' => $request->description_en ?? '',
            ],
            'registration_link' => $validated['registration_link'] ?? null,
            'whatsapp_contact' => $validated['whatsapp_contact'] ?? '089678211575',
            'status' => $validated['status'] ?? 'upcoming',
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Agenda Event berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $event = HospitalEvent::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:50',
            'end_time' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|string|max:100',
            'price_type' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'speakers_text' => 'nullable|string',
            'benefits_text' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:30720',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'registration_link' => 'nullable|string|max:500',
            'whatsapp_contact' => 'nullable|string|max:50',
            'status' => 'required|string|in:upcoming,ongoing,completed',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $imageUrl = $validated['image'] ?? $event->image;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            if ($event->image && str_starts_with($event->image, 'storage/')) {
                $oldPath = substr($event->image, 8);
                Storage::disk('public')->delete($oldPath);
            }
            $path = ImageOptimizer::optimizeAndStore($request->file('image_file'), 'events', 1200, 85);
            $imageUrl = 'storage/' . $path;
        }

        // Parse speakers
        $speakers = [];
        if (!empty($request->speakers_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->speakers_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    if (str_contains($trimmed, '|')) {
                        $parts = explode('|', $trimmed, 2);
                        $speakers[] = [
                            'name' => trim($parts[0]),
                            'role' => trim($parts[1] ?? ''),
                        ];
                    } else {
                        $speakers[] = [
                            'name' => ltrim($trimmed, '-•* '),
                            'role' => 'Narasumber',
                        ];
                    }
                }
            }
        }

        // Parse benefits
        $benefits = [];
        if (!empty($request->benefits_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->benefits_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $benefits[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        $event->update([
            'title' => [
                'id' => $validated['title_id'],
                'en' => $request->title_en ?: ($event->getTranslation('title', 'en') ?: $validated['title_id']),
            ],
            'category' => $validated['category'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'],
            'speakers' => $speakers,
            'quota' => $validated['quota'] ?? null,
            'price_type' => $validated['price_type'] ?: 'Gratis / Free',
            'price' => $validated['price'] ?? null,
            'benefits' => $benefits,
            'image' => $imageUrl,
            'short_description' => [
                'id' => $validated['short_description_id'] ?? '',
                'en' => $request->short_description_en ?? ($event->getTranslation('short_description', 'en') ?? ''),
            ],
            'description' => [
                'id' => $validated['description_id'] ?? '',
                'en' => $request->description_en ?? ($event->getTranslation('description', 'en') ?? ''),
            ],
            'registration_link' => $validated['registration_link'] ?? null,
            'whatsapp_contact' => $validated['whatsapp_contact'] ?? '089678211575',
            'status' => $validated['status'] ?? 'upcoming',
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Agenda Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = HospitalEvent::findOrFail($id);
        if ($event->image && str_starts_with($event->image, 'storage/')) {
            $oldPath = substr($event->image, 8);
            Storage::disk('public')->delete($oldPath);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Agenda Event berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $event = HospitalEvent::findOrFail($id);
        $event->is_active = !$event->is_active;
        $event->save();

        return response()->json([
            'success' => true,
            'is_active' => $event->is_active,
            'message' => 'Status aktif event berhasil diperbarui.'
        ]);
    }
}
