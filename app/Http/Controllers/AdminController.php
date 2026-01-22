<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Flashcard;
use App\Models\Monster;
use App\Models\Quiz;
use App\Models\Stage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ==========================================
    //              1. CRUD CHAPTER
    // ==========================================
    public function indexChapters()
    {
        $chapters = Chapter::orderBy('chapter_number')->get();

        return response()->json([
            'success' => true,
            'data' => $chapters
        ]);
    }

    public function storeChapter(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'chapter_number' => 'required|integer|unique:chapters,chapter_number',
        ]);

        $chapter = Chapter::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Chapter berhasil dibuat!',
            'data' => $chapter
        ], 201);
    }

    public function showChapter($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['success' => false, 'message' => 'Chapter tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $chapter
        ]);
    }

    public function updateChapter(Request $request, $id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['success' => false, 'message' => 'Chapter tidak ditemukan'], 404);
        }

        $request->validate([
            'title' => 'string',
            'chapter_number' => 'integer|unique:chapters,chapter_number,' . $id,
        ]);

        $chapter->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Chapter berhasil diupdate!',
            'data' => $chapter
        ]);
    }

    public function destroyChapter($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['success' => false, 'message' => 'Chapter tidak ditemukan'], 404);
        }

        $chapter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chapter berhasil dihapus!'
        ]);
    }


    // ==========================================
    //               2. CRUD STAGE
    // ==========================================

    public function storeStage(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'stage_number' => 'required|integer',
            'level_req' => 'integer',
            'monster_id' => 'required|exists:monsters,id',
            'is_boss_level' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageDbPath = 'storage/assets/stages/default.png';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/assets/stages');
            $imageDbPath = str_replace('public/', 'storage/', $path);
        }

        $stage = Stage::create([
            'chapter_id' => $request->chapter_id,
            'name' => $request->name,
            'description' => $request->description ?? 'Latihan seru!',
            'stage_number' => $request->stage_number,
            'level_req' => $request->level_req ?? 1,
            'monster_id' => $request->monster_id,
            'is_boss_level' => $request->boolean('is_boss_level'),
            'image_path' => $imageDbPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stage berhasil dibuat!',
            'data' => $stage
        ], 201);
    }

    public function indexStages()
    {
        $stages = Stage::with('chapter')->orderBy('chapter_id')->orderBy('stage_number')->get();

        return response()->json([
            'success' => true,
            'data' => $stages
        ]);
    }

    public function showStage($id)
    {
        $stage = Stage::with(['chapter', 'monster'])->find($id);

        if (!$stage) {
            return response()->json(['success' => false, 'message' => 'Stage tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $stage
        ]);
    }

    public function updateStage(Request $request, $id)
    {
        $stage = Stage::find($id);

        if (!$stage) {
            return response()->json(['success' => false, 'message' => 'Stage tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'string',
            'stage_number' => 'integer',
            'monster_id' => 'exists:monsters,id',
            'is_boss_level' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dataToUpdate = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($stage->image_path && $stage->image_path !== 'storage/assets/stages/default.png') {
                $oldPath = str_replace('storage/', 'public/', $stage->image_path);
                \Illuminate\Support\Facades\Storage::delete($oldPath);
            }

            $path = $request->file('image')->store('public/assets/stages');
            $dataToUpdate['image_path'] = str_replace('public/', 'storage/', $path);
        }

        $stage->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Stage berhasil diupdate!',
            'data' => $stage
        ]);
    }

    public function destroyStage($id)
    {
        $stage = Stage::find($id);

        if (!$stage) {
            return response()->json(['success' => false, 'message' => 'Stage tidak ditemukan'], 404);
        }

        // Hapus
        $stage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stage berhasil dihapus!'
        ]);
    }


    // ==========================================
    //              3. CRUD FLASHCARD
    // ==========================================
    public function indexFlashcards()
    {
        $flashcards = Flashcard::with('stage')->orderBy('stage_id')->get();

        return response()->json([
            'success' => true,
            'data' => $flashcards
        ]);
    }

    public function showFlashcard($id)
    {
        $flashcard = Flashcard::with('stage')->find($id);

        if (!$flashcard) {
            return response()->json(['success' => false, 'message' => 'Flashcard tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $flashcard
        ]);
    }

    public function storeFlashcard(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'kanji' => 'required|string',
            'romaji' => 'required|string',
            'meaning' => 'required|string',
            'audio' => 'nullable|file|mimes:mp3,wav|max:2048'
        ]);

        $audioDbPath = null;

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('public/assets/audio');
            $audioDbPath = str_replace('public/', 'storage/', $path);
        }

        $flashcard = Flashcard::create([
            'stage_id' => $request->stage_id,
            'kanji' => $request->kanji,
            'romaji' => $request->romaji,
            'meaning' => $request->meaning,
            'audio_path' => $audioDbPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Flashcard berhasil ditambahkan!',
            'data' => $flashcard
        ], 201);
    }

    public function updateFlashcard(Request $request, $id)
    {
        $flashcard = Flashcard::find($id);

        if (!$flashcard) {
            return response()->json(['success' => false, 'message' => 'Flashcard tidak ditemukan'], 404);
        }

        $request->validate([
            'kanji' => 'string',
            'romaji' => 'string',
            'meaning' => 'string',
            'audio' => 'file|mimes:mp3,wav'
        ]);

        $dataToUpdate = $request->except(['audio']);

        if ($request->hasFile('audio')) {
            if ($flashcard->audio_path) {
                $oldPath = str_replace('storage/', 'public/', $flashcard->audio_path);
                \Illuminate\Support\Facades\Storage::delete($oldPath);
            }
            $path = $request->file('audio')->store('public/assets/audio');
            $dataToUpdate['audio_path'] = str_replace('public/', 'storage/', $path);
        }

        $flashcard->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Flashcard berhasil diupdate!',
            'data' => $flashcard
        ]);
    }

    public function destroyFlashcard($id)
    {
        $flashcard = Flashcard::find($id);

        if (!$flashcard) {
            return response()->json(['success' => false, 'message' => 'Flashcard tidak ditemukan'], 404);
        }

        $flashcard->delete();

        return response()->json([
            'success' => true,
            'message' => 'Flashcard berhasil dihapus!'
        ]);
    }



    // ==========================================
    //              4. CRUD QUIZ
    // ==========================================
    public function indexQuizzes()
    {
        $quizzes = Quiz::with('stage')->orderBy('stage_id')->get();

        return response()->json([
            'success' => true,
            'data' => $quizzes
        ]);
    }

    public function storeQuiz(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string',
        ]);

        if (!in_array($request->correct_answer, $request->options)) {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban benar tidak ditemukan di dalam opsi pilihan!'
            ], 422);
        }

        $quiz = Quiz::create([
            'stage_id' => $request->stage_id,
            'question' => $request->question,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Soal Quiz berhasil dibuat!',
            'data' => $quiz
        ], 201);
    }

    public function showQuiz($id)
    {
        $quiz = Quiz::with('stage')->find($id);

        if (!$quiz) {
            return response()->json(['success' => false, 'message' => 'Soal Quiz tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $quiz
        ]);
    }

    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['success' => false, 'message' => 'Soal Quiz tidak ditemukan'], 404);
        }

        $request->validate([
            'question' => 'string',
            'options' => 'array|min:2',
            'correct_answer' => 'string',
        ]);

        if ($request->has('options') && $request->has('correct_answer')) {
            if (!in_array($request->correct_answer, $request->options)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jawaban benar tidak ditemukan di dalam opsi pilihan!'
                ], 422);
            }
        }

        $quiz->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Soal Quiz berhasil diupdate!',
            'data' => $quiz
        ]);
    }

    public function destroyQuiz($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['success' => false, 'message' => 'Soal Quiz tidak ditemukan'], 404);
        }

        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal Quiz berhasil dihapus!'
        ]);
    }

    // ==========================================
    //            5. CRUD MONSTER (GAME DATA)
    // ==========================================
    public function indexMonsters()
    {
        $monsters = Monster::all();

        return response()->json([
            'success' => true,
            'data' => $monsters
        ]);
    }

    public function storeMonster(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'base_hp' => 'required|integer',
            'attack_interval_ms' => 'required|integer',
            'damage_per_hit' => 'required|integer',
            'exp_reward' => 'required|integer',
            'gold_reward' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $imageDbPath = 'storage/assets/monsters/default.png';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/assets/monsters');
            $imageDbPath = str_replace('public/', 'storage/', $path);
        }

        $monster = Monster::create([
            'name' => $request->name,
            'base_hp' => $request->base_hp,
            'attack_interval_ms' => $request->attack_interval_ms,
            'damage_per_hit' => $request->damage_per_hit,
            'exp_reward' => $request->exp_reward,
            'gold_reward' => $request->gold_reward,
            'asset_path' => $imageDbPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Monster berhasil ditambahkan!',
            'data' => $monster
        ], 201);
    }

    public function showMonster($id)
    {
        $monster = Monster::find($id);

        if (!$monster) {
            return response()->json(['success' => false, 'message' => 'Monster tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $monster
        ]);
    }

    public function updateMonster(Request $request, $id)
    {
        $monster = Monster::find($id);

        if (!$monster) {
            return response()->json(['success' => false, 'message' => 'Monster tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'string',
            'base_hp' => 'integer',
            'attack_interval_ms' => 'integer',
            'damage_per_hit' => 'integer',
            'exp_reward' => 'integer',
            'gold_reward' => 'integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $dataToUpdate = $request->except(['image', 'asset_path']);

        if ($request->hasFile('image')) {
            if ($monster->asset_path && $monster->asset_path !== 'storage/assets/monsters/default.png') {
                 $oldPath = str_replace('storage/', 'public/', $monster->asset_path);
                 \Illuminate\Support\Facades\Storage::delete($oldPath);
            }

            $path = $request->file('image')->store('public/assets/monsters');
            $dataToUpdate['asset_path'] = str_replace('public/', 'storage/', $path);
        }

        $monster->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Data Monster berhasil diupdate!',
            'data' => $monster
        ]);
    }
    public function destroyMonster($id)
    {
        $monster = Monster::find($id);

        if (!$monster) {
            return response()->json(['success' => false, 'message' => 'Monster tidak ditemukan'], 404);
        }

        $monster->delete();

        return response()->json([
            'success' => true,
            'message' => 'Monster berhasil dihapus!'
        ]);
    }
}
