<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCareerController extends Controller
{
    public function index()
    {
        $careers = Career::withCount('applications')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.careers.index', compact('careers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'employment_type' => 'required|string|max:100',
            'education_level' => 'required|string|max:100',
            'experience_years' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'requirements_text' => 'nullable|string',
            'responsibilities_text' => 'nullable|string',
            'benefits_text' => 'nullable|string',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'status' => 'required|string|in:open,closed',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'title_id.required' => 'Nama posisi lowongan kerja wajib diisi.',
            'department.required' => 'Bidang / Departemen wajib dipilih.',
            'employment_type.required' => 'Tipe pekerjaan wajib dipilih.',
            'education_level.required' => 'Pendidikan minimal wajib diisi.',
            'location.required' => 'Lokasi penempatan kerja wajib diisi.',
        ]);

        // Parse requirements from multiline text
        $requirements = [];
        if (!empty($request->requirements_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->requirements_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $requirements[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        // Parse responsibilities from multiline text
        $responsibilities = [];
        if (!empty($request->responsibilities_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->responsibilities_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $responsibilities[] = ltrim($trimmed, '-•* ');
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

        $slug = Str::slug($validated['title_id']);
        if (empty($slug)) {
            $slug = 'loker-' . time();
        } else {
            $count = Career::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . time();
            }
        }

        $maxOrder = Career::max('order') ?? 0;

        Career::create([
            'title' => [
                'id' => $validated['title_id'],
                'en' => $request->title_en ?: $validated['title_id'],
            ],
            'slug' => $slug,
            'department' => $validated['department'],
            'employment_type' => $validated['employment_type'],
            'education_level' => $validated['education_level'],
            'experience_years' => $validated['experience_years'] ?? 'Fresh Graduate',
            'location' => $validated['location'],
            'quota' => $validated['quota'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'requirements' => $requirements,
            'responsibilities' => $responsibilities,
            'benefits' => $benefits,
            'short_description' => [
                'id' => $validated['short_description_id'] ?? '',
                'en' => $request->short_description_en ?? '',
            ],
            'description' => [
                'id' => $validated['description_id'] ?? '',
                'en' => $request->description_en ?? '',
            ],
            'status' => $validated['status'] ?? 'open',
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.careers.index')->with('success', 'Lowongan pekerjaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $career = Career::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'employment_type' => 'required|string|max:100',
            'education_level' => 'required|string|max:100',
            'experience_years' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'requirements_text' => 'nullable|string',
            'responsibilities_text' => 'nullable|string',
            'benefits_text' => 'nullable|string',
            'short_description_id' => 'nullable|string|max:500',
            'description_id' => 'nullable|string',
            'status' => 'required|string|in:open,closed',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Parse requirements
        $requirements = [];
        if (!empty($request->requirements_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->requirements_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $requirements[] = ltrim($trimmed, '-•* ');
                }
            }
        }

        // Parse responsibilities
        $responsibilities = [];
        if (!empty($request->responsibilities_text)) {
            $lines = explode("\n", str_replace("\r", "", $request->responsibilities_text));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $responsibilities[] = ltrim($trimmed, '-•* ');
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

        $career->update([
            'title' => [
                'id' => $validated['title_id'],
                'en' => $request->title_en ?: ($career->getTranslation('title', 'en') ?: $validated['title_id']),
            ],
            'department' => $validated['department'],
            'employment_type' => $validated['employment_type'],
            'education_level' => $validated['education_level'],
            'experience_years' => $validated['experience_years'] ?? $career->experience_years,
            'location' => $validated['location'],
            'quota' => $validated['quota'] ?? $career->quota,
            'deadline' => $validated['deadline'] ?? null,
            'requirements' => $requirements,
            'responsibilities' => $responsibilities,
            'benefits' => $benefits,
            'short_description' => [
                'id' => $validated['short_description_id'] ?? '',
                'en' => $request->short_description_en ?? ($career->getTranslation('short_description', 'en') ?? ''),
            ],
            'description' => [
                'id' => $validated['description_id'] ?? '',
                'en' => $request->description_en ?? ($career->getTranslation('description', 'en') ?? ''),
            ],
            'status' => $validated['status'] ?? 'open',
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.careers.index')->with('success', 'Lowongan pekerjaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return redirect()->route('admin.careers.index')->with('success', 'Lowongan pekerjaan berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $career = Career::findOrFail($id);
        $career->is_active = !$career->is_active;
        $career->save();

        return response()->json([
            'success' => true,
            'is_active' => $career->is_active,
            'message' => 'Status aktif lowongan berhasil diubah.'
        ]);
    }

    public function toggleStatus($id)
    {
        $career = Career::findOrFail($id);
        $career->status = $career->status === 'open' ? 'closed' : 'open';
        $career->save();

        return response()->json([
            'success' => true,
            'status' => $career->status,
            'message' => 'Status pembukaan lowongan berhasil diubah.'
        ]);
    }
}
