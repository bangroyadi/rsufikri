<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmartAssistantService;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    protected SmartAssistantService $assistantService;

    public function __construct(SmartAssistantService $assistantService)
    {
        $this->assistantService = $assistantService;
    }

    /**
     * Handle chat request dari frontend menggunakan Smart AI Engine Lokal (Knowledge Base).
     * POST /ai/chat
     */
    public function chat(Request $request)
    {
        // 1. Validasi input user
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:500'],
        ]);

        $userMessage = trim($validated['message']);

        try {
            // 2. Proses pertanyaan menggunakan SmartAssistantService (NLP & Knowledge Base Lokal)
            $result = $this->assistantService->processQuery($userMessage);

            return response()->json([
                'success'     => true,
                'reply'       => $result['answer'],
                'intent'      => $result['intent'] ?? null,
                'score'       => $result['score'] ?? 0,
                'is_fallback' => $result['is_fallback'] ?? false,
                'suggestions' => $result['suggestions'] ?? [],
            ]);

        } catch (\Exception $e) {
            Log::error('AiChatController local processing error', [
                'error'   => $e->getMessage(),
                'query'   => $userMessage,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Maaf, Tanya Fikri sedang mengalami kendala teknis. Silakan coba beberapa saat lagi.',
            ], 500);
        }
    }
}
