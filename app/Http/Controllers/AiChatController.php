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
     * Handle chat request dari frontend menggunakan Smart AI Engine Lokal.
     * POST /ai/chat
     */
    public function chat(Request $request)
    {
        // 1. Validasi input user
        $validated = $request->validate([
            'message'    => ['required', 'string', 'min:1', 'max:500'],
            'session_id' => ['nullable', 'string', 'max:100'],
        ]);

        $userMessage = trim($validated['message']);
        $sessionId = $validated['session_id'] ?? $request->session()->getId();

        try {
            // 2. Proses pertanyaan menggunakan SmartAssistantService (NLP, Context, Entity & Live DB)
            $result = $this->assistantService->processQuery($userMessage, $sessionId);

            return response()->json([
                'success'     => true,
                'reply'       => $result['answer'],
                'intent'      => $result['intent'] ?? null,
                'score'       => $result['score'] ?? 0,
                'is_fallback' => $result['is_fallback'] ?? false,
                'buttons'     => $result['buttons'] ?? [],
                'suggestions' => $result['suggestions'] ?? [],
                'session_id'  => $sessionId,
            ]);

        } catch (\Exception $e) {
            Log::error('AiChatController local processing error', [
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'query'   => $userMessage,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Maaf, Kakak Fikri sedang mengalami kendala sistem. Silakan coba beberapa saat lagi.',
            ], 500);
        }
    }

    /**
     * Reset sesi context percakapan
     * POST /ai/reset-session
     */
    public function resetSession(Request $request)
    {
        $this->assistantService->resetSession();

        return response()->json([
            'success' => true,
            'message' => 'Sesi percakapan berhasil direset.',
        ]);
    }
}
