<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminJobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $careerId = $request->query('career_id');
        $status = $request->query('status');
        $search = $request->query('search');

        $query = JobApplication::with('career')->orderBy('created_at', 'desc');

        if (!empty($careerId) && $careerId !== 'all') {
            $query->where('career_id', $careerId);
        }

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('last_education', 'like', "%{$search}%");
            });
        }

        $applications = $query->get();
        $careers = Career::orderBy('title', 'asc')->get();

        // Statistics counters
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewed' => JobApplication::where('status', 'reviewed')->count(),
            'interview' => JobApplication::where('status', 'interview')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.careers.applications', compact('applications', 'careers', 'stats', 'careerId', 'status', 'search'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:pending,reviewed,interview,accepted,rejected',
            'hrd_notes' => 'nullable|string|max:2000',
        ]);

        $application->update([
            'status' => $validated['status'],
            'hrd_notes' => $validated['hrd_notes'] ?? $application->hrd_notes,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $application->status,
                'status_label' => $application->status_label,
                'message' => 'Status lamaran kandidat ' . $application->full_name . ' berhasil diperbarui!'
            ]);
        }

        return back()->with('success', 'Status lamaran kandidat ' . $application->full_name . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);

        if ($application->cv_file && str_starts_with($application->cv_file, 'storage/')) {
            $path = substr($application->cv_file, 8);
            Storage::disk('public')->delete($path);
        }

        $application->delete();

        return back()->with('success', 'Data lamaran kerja berhasil dihapus!');
    }
}
