<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    // 1. GET /api/flashcards
    // Fitur: Menampilkan semua daftar kanji (Kamus)
    public function index(Request $request)
    {
        // Opsional: Bisa filter by Stage kalau mau (misal ?stage_id=1)
        $query = Flashcard::query();

        if ($request->has('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }

        // Ambil data + info stage-nya
        $flashcards = $query->with('stage')->get();

        return response()->json([
            'success' => true,
            'data' => $flashcards
        ]);
    }

    // 2. GET /api/flashcards/{id}
    // Fitur: Detail satu kanji (misal mau lihat contoh kalimatnya)
    public function show($id)
    {
        $flashcard = Flashcard::with('stage')->find($id);

        if (!$flashcard) {
            return response()->json(['message' => 'Kanji not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $flashcard
        ]);
    }
}
