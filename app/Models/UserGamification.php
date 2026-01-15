<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGamification extends Model
{
    use HasFactory;

    protected $table = 'user_gamifications';
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'total_xp',
        'today_xp',
        'last_played_date',
        'current_level',
        'gold',
        'break_tokens',
        'current_streak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
