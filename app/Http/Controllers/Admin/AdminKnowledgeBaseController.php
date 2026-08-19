<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use App\Models\ChatbotUnrecognizedQuery;
use App\Services\ChatbotAutoLearningService;

class AdminKnowledgeBaseController extends Controller
{
    protected ChatbotAutoLearningService $autoLearningService;

    public function __construct(ChatbotAutoLearningService $autoLearningService)
    {
        $this->autoLearningService = $autoLearningService;
    }

    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = KnowledgeBase::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('intent', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $knowledgeBases = $query->orderBy('priority', 'desc')->orderBy('category', 'asc')->paginate(15);
        $categories = KnowledgeBase::select('category')->distinct()->pluck('category');

        // Unrecognized Queries (Learning Queue)
        $unrecognizedQueries = ChatbotUnrecognizedQuery::orderBy('created_at', 'desc')->paginate(15, ['*'], 'unrec_page');
        $unresolvedCount = ChatbotUnrecognizedQuery::where('is_resolved', false)->count();

        return view('admin.knowledge.index', compact('knowledgeBases', 'categories', 'unrecognizedQueries', 'unresolvedCount', 'category', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'  => ['required', 'string', 'max:100'],
            'intent'    => ['required', 'string', 'max:100', 'unique:knowledge_bases,intent'],
            'question'  => ['required', 'string', 'max:255'],
            'keywords'  => ['nullable', 'string'],
            'synonyms'  => ['nullable', 'string'],
            'answer'    => ['required', 'string'],
            'priority'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'unrec_id'  => ['nullable', 'integer'],
        ]);

        $validated['priority'] = $validated['priority'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        KnowledgeBase::create($validated);

        // Jika dibuat dari pertanyaan unrecognized, tandai sebagai resolved
        if (!empty($validated['unrec_id'])) {
            ChatbotUnrecognizedQuery::where('id', $validated['unrec_id'])->update(['is_resolved' => true]);
        }

        return redirect()->route('admin.knowledge.index')->with('success', 'Entri Knowledge Base berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kb = KnowledgeBase::findOrFail($id);

        $validated = $request->validate([
            'category'  => ['required', 'string', 'max:100'],
            'intent'    => ['required', 'string', 'max:100', 'unique:knowledge_bases,intent,' . $id],
            'question'  => ['required', 'string', 'max:255'],
            'keywords'  => ['nullable', 'string'],
            'synonyms'  => ['nullable', 'string'],
            'answer'    => ['required', 'string'],
            'priority'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['priority'] = $validated['priority'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $kb->update($validated);

        return redirect()->route('admin.knowledge.index')->with('success', 'Entri Knowledge Base berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kb = KnowledgeBase::findOrFail($id);
        $kb->delete();

        return redirect()->route('admin.knowledge.index')->with('success', 'Entri Knowledge Base berhasil dihapus.');
    }

    public function resolveUnrecognized($id)
    {
        $unrec = ChatbotUnrecognizedQuery::findOrFail($id);
        $unrec->update(['is_resolved' => true]);

        return redirect()->route('admin.knowledge.index')->with('success', 'Pertanyaan berhasil ditandai telah diselesaikan.');
    }

    public function destroyUnrecognized($id)
    {
        $unrec = ChatbotUnrecognizedQuery::findOrFail($id);
        $unrec->delete();

        return redirect()->route('admin.knowledge.index')->with('success', 'Log pertanyaan berhasil dihapus.');
    }

    public function autoProcess()
    {
        $stats = $this->autoLearningService->processPendingQueries();

        $msg = "⚡ Pemrosesan Otomatis Selesai: {$stats['spam_cleaned']} pertanyaan sampah dibersihkan, {$stats['auto_mapped']} pertanyaan berhasil dipetakan ke Knowledge Base, {$stats['skipped']} pertanyaan menunggu tindakan admin.";

        return redirect()->route('admin.knowledge.index')->with('success', $msg);
    }
}
