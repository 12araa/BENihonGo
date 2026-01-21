<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleHistory extends Model
{
    protected $fillable = [
        'user_id',
        'stage_id',
        'score',
        'exp_earned',
        'gold_earned',
        'is_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
