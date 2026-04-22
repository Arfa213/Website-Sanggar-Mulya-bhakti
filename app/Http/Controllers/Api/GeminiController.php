<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Models\Chat; // Pastikan ini sudah ada
use Exception;

class GeminiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function chat(Request $request)
    {
        // Gunakan 'message' sesuai yang dikirim oleh chatbot.blade.php
        $userInput = $request->input('message');

        if (!$userInput) {
            return response()->json(['success' => false, 'reply' => 'Pesan kosong.'], 400);
        }

        try {
            // 1. Ambil jawaban dari Gemini
            $jawaban = $this->geminiService->generateResponse($userInput);

            // 2. Simpan ke Database
            Chat::create([
                'pesan_user' => $userInput,
                'jawaban_ai' => $jawaban,
                'model_used' => 'gemini-2.5-flash'
            ]);

            return response()->json([
                'success' => true,
                'reply' => $jawaban
            ]);

        } catch (Exception $e) {
    // Ubah baris ini agar kita tahu error aslinya apa
    return response()->json([
        'success' => true, // Set true sementara agar pesan error muncul di bubble chat
        'reply' => 'Waduh, ada error nih: ' . $e->getMessage()
    ]);
}
    }
}