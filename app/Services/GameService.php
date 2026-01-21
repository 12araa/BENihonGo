<?php

namespace App\Services;

use App\Models\UserGamification;
use App\Models\BattleHistory;
use App\Models\UserStageProgress;
use App\Models\Stage;
use Illuminate\Support\Facades\DB;

class GameService
{
    const BASE_EXP_WIN = 50;
    const BASE_EXP_LOSE = 5;
    const BASE_GOLD_WIN = 20;

    public function processGameResult($user, $stageId, $score, $isCompleted)
    {
        $stage = Stage::findOrFail($stageId);

        $expEarned = $isCompleted ? (self::BASE_EXP_WIN + intval($score / 10)) : self::BASE_EXP_LOSE;
        $goldEarned = $isCompleted ? (self::BASE_GOLD_WIN + intval($score / 20)) : 0;

        return DB::transaction(function () use ($user, $stage, $score, $expEarned, $goldEarned, $isCompleted) {
            $isLevelUp = $this->updateUserGamification($user, $expEarned, $goldEarned);

            BattleHistory::create([
                'user_id' => $user->id,
                'stage_id' => $stage->id,
                'score' => $score,
                'exp_earned' => $expEarned,
                'gold_earned' => $goldEarned,
                'is_completed' => $isCompleted
            ]);

            if ($isCompleted) {
                $this->unlockNextStage($user, $stage);
            }

            return [
                'exp_gained' => $expEarned,
                'gold_gained' => $goldEarned,
                'is_level_up' => $isLevelUp,
            ];
        });
    }

private function updateUserGamification($user, $xp, $gold)
    {
        $gamification = UserGamification::firstOrCreate(['user_id' => $user->id]);
        $currentLevel = $gamification->current_level ?? 1;

        $gamification->total_xp += $xp;
        $gamification->today_xp += $xp;
        $gamification->gold += $gold;

        $totalXp = $gamification->total_xp;

        $calculatedLevel = floor(sqrt($totalXp / 20));

        if ($calculatedLevel < 1) {
            $calculatedLevel = 1;
        }

        $isUp = false;

        if ($calculatedLevel > $currentLevel) {
            $gamification->current_level = $calculatedLevel;
            $isUp = true;
        }

        $gamification->save();

        return $isUp;
    }

    private function unlockNextStage($user, $currentStage)
    {
        UserStageProgress::updateOrCreate(
            ['user_id' => $user->id, 'stage_id' => $currentStage->id],
            ['is_unlocked' => true, 'is_completed' => true, 'stars' => 3]
        );

        $nextStage = Stage::where('chapter_id', $currentStage->chapter_id)
                        ->where('stage_number', $currentStage->stage_number + 1)
                        ->first();

        if ($nextStage) {
            UserStageProgress::firstOrCreate(
                ['user_id' => $user->id, 'stage_id' => $nextStage->id],
                ['is_unlocked' => true, 'is_completed' => false]
            );
        }
    }
}
