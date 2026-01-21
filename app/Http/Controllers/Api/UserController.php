<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserGamification;
use Illuminate\Http\Request;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->load(['gamification', 'setting', 'items' => function ($query) {
            $query->wherePivot('is_equipped', true);
        }]);

        $equippedAvatar = $user->items->first();
        $avatarPath = $equippedAvatar ? $equippedAvatar->asset_path : 'assets/avatars/headband.png';

        $currentLevel = $user->gamification->current_level ?? 1;
        $maxXp = $currentLevel * 100;

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $avatarPath,

                'gamification' => [
                    'level' => $currentLevel,
                    'gold' => $user->gamification->gold ?? 0,
                    'total_xp' => $user->gamification->total_xp ?? 0,
                    'max_xp' => $maxXp,
                ],

                'daily_progress' => [
                    'current' => $user->gamification->today_xp ?? 0,
                    'target' => $user->setting->daily_target_exp ?? 100,
                    'is_target_reached' => ($user->gamification->today_xp ?? 0) >= ($user->setting->daily_target_exp ?? 100)
                ],
            ]
        ]);
    }

    public function history()
    {
        $history = \App\Models\BattleHistory::with('stage')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

public function leaderboard()
    {
        $userId = Auth::id();
        $topUsers = UserGamification::with(['user.items' => function ($query) {
                $query->wherePivot('is_equipped', true);
            }])
            ->orderByDesc('total_xp')
            ->limit(10)
            ->get();

            $leaderboardData = $topUsers->map(function ($data, $index) use ($userId) {
            $user = $data->user;

            $equippedAvatar = $user->items->first();
            $avatarPath = $equippedAvatar ? $equippedAvatar->asset_path : 'assets/avatars/headband.png';

            return [
                'rank' => $index + 1,
                'name' => $user->name,
                'level' => $data->current_level,
                'total_xp' => $data->total_xp,
                'avatar' => $avatarPath,
                'is_me' => $user->id === $userId
            ];
        });

        $myGamification = UserGamification::where('user_id', $userId)->first();
        $myRankData = null;

        if ($myGamification) {
            $higherRankCount = UserGamification::where('total_xp', '>', $myGamification->total_xp)->count();
            $myRank = $higherRankCount + 1;

            /** @var \App\Models\User $me */
            $me = Auth::user();
            $me->load(['items' => function ($q) { $q->wherePivot('is_equipped', true); }]);
            $myAvatarItem = $me->items->first();
            $myAvatarPath = $myAvatarItem ? $myAvatarItem->asset_path : 'assets/avatars/headband.png';

            $myRankData = [
                'rank' => $myRank,
                'name' => $me->name,
                'level' => $myGamification->level,
                'total_xp' => $myGamification->total_xp,
                'avatar' => $myAvatarPath,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil leaderboard',
            'data' => [
                'leaderboard' => $leaderboardData,
                'user_rank' => $myRankData 
            ]
        ]);
    }

    public function submitOnboarding(Request $request){

        $request->validate([
            'focus_duration' => 'required|integer|min:5|max:60',
            'daily_target_exp' => 'required|integer|min:10',
        ]);

        $user = Auth::user();

        $setting = UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'focus_duration' => $request->focus_duration,
                'daily_target_exp' => $request->daily_target_exp,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil disimpan!',
            'data' => $setting
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'data' => $user
        ]);
    }

    public function inventory()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $inventory = $user->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'image_path' => $item->asset_path,

                'is_equipped' => (bool) $item->pivot->is_equipped,
                'purchased_at' => $item->pivot->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }
}
