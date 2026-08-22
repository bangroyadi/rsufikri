<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiktokPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTiktokPostController extends Controller
{
    public function index()
    {
        $posts = TiktokPost::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.tiktok.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'views_count' => 'nullable|string|max:50',
            'tag' => 'nullable|string|max:255',
            'tiktok_url' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'thumbnail_url' => 'nullable|string|max:500',
            'video_file' => 'nullable|mimes:mp4,webm,mov,ogg|max:51200',
            'video_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
        ]);

        $thumbnail = $validated['thumbnail_url'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('tiktok/thumbnails', 'public');
            $thumbnail = $path;
        }

        $videoUrl = $validated['video_url'] ?? null;
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('tiktok/videos', 'public');
            $videoUrl = $path;
        }

        $maxOrder = TiktokPost::max('order') ?? 0;

        TiktokPost::create([
            'title' => $validated['title'],
            'views_count' => $validated['views_count'] ?: '10.5K',
            'tag' => $validated['tag'] ?: '#RSUFikriMedika #TipsSehat',
            'tiktok_url' => $validated['tiktok_url'] ?: 'https://www.tiktok.com/@rsu.fikrimedika',
            'thumbnail' => $thumbnail ?: 'gedung1_web.jpg',
            'video_url' => $videoUrl ?: 'https://assets.mixkit.co/videos/preview/mixkit-doctor-checking-a-patient-41484-large.mp4',
            'order' => $validated['order'] ?? ($maxOrder + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Postingan TikTok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $post = TiktokPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'views_count' => 'nullable|string|max:50',
            'tag' => 'nullable|string|max:255',
            'tiktok_url' => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'thumbnail_url' => 'nullable|string|max:500',
            'video_file' => 'nullable|mimes:mp4,webm,mov,ogg|max:51200',
            'video_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
        ]);

        $thumbnail = $post->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('tiktok/thumbnails', 'public');
            $thumbnail = $path;
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnail = $validated['thumbnail_url'];
        }

        $videoUrl = $post->video_url;
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('tiktok/videos', 'public');
            $videoUrl = $path;
        } elseif (!empty($validated['video_url'])) {
            $videoUrl = $validated['video_url'];
        }

        $post->update([
            'title' => $validated['title'],
            'views_count' => $validated['views_count'] ?: $post->views_count,
            'tag' => $validated['tag'] ?: $post->tag,
            'tiktok_url' => $validated['tiktok_url'] ?: $post->tiktok_url,
            'thumbnail' => $thumbnail,
            'video_url' => $videoUrl,
            'order' => $validated['order'] ?? $post->order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Postingan TikTok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $post = TiktokPost::findOrFail($id);
        $post->delete();

        return back()->with('success', 'Postingan TikTok berhasil dihapus!');
    }
}
