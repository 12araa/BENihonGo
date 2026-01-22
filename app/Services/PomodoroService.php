<?php

namespace App\Services;

use App\Models\PomodoroLog;
use App\Models\UserGamification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PomodoroService
{
    const XP_PER_MINUTE = 2;
    const GOLD_PER_MINUTE = 1;

    public function startSession($user)
    {
        PomodoroLog::where('user_id', $user->id)
                   ->where('status', 'running')
                   ->update(['status' => 'interrupted', 'end_time' => now()]);

        $log = PomodoroLog::create([
            'user_id' => $user->id,
            'start_time' => Carbon::now(),
            'status' => 'running',
            'total_minutes' => 0,
            'earned_exp' => 0,
            'earned_gold' => 0
        ]);

        return $log;
    }

    public function stopSession($user, $status = 'completed')
    {
        $log = PomodoroLog::where('user_id', $user->id)
                          ->where('status', 'running')
                          ->latest()
                          ->first();

        if (!$log) {
            throw new \Exception("Tidak ada sesi Pomodoro yang aktif.");
        }

        return DB::transaction(function () use ($user, $log, $status) {
            $endTime = Carbon::now();
            $startTime = Carbon::parse($log->start_time);

        $minutesFloat = $startTime->floatDiffInMinutes($endTime);

        $actualMinutes = (int) round($minutesFloat);

        if ($actualMinutes < 1) {
            $actualMinutes = 0;
            $status = 'interrupted';
        }

        $xpEarned = $actualMinutes * self::XP_PER_MINUTE;
        $goldEarned = $actualMinutes * self::GOLD_PER_MINUTE;

        $log->update([
            'end_time' => $endTime,
            'total_minutes' => $actualMinutes, 
            'status' => $status,
            'earned_exp' => $xpEarned,
            'earned_gold' => $goldEarned
        ]);

            if ($xpEarned > 0) {
                $this->updateUserStats($user, $xpEarned, $goldEarned);
            }

            return [
                'log' => $log,
                'rewards' => [
                    'xp' => $xpEarned,
                    'gold' => $goldEarned,
                    'minutes' => $actualMinutes
                ]
            ];
        });
    }

    private function updateUserStats($user, $xp, $gold)
    {
        $gamification = UserGamification::firstOrCreate(['user_id' => $user->id]);

        $gamification->gold += $gold;
        $gamification->total_xp += $xp;
        $gamification->today_xp += $xp;

        $currentLevel = $gamification->level ?? 1;
        $newLevel = floor(sqrt($gamification->total_xp / 20));
        if ($newLevel < 1) $newLevel = 1;

        if ($newLevel > $currentLevel) {
            $gamification->level = $newLevel;
        }

        $gamification->save();
    }
}
