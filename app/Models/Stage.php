<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'chapter_id',
        'name',
        'description',
        'stage_number',
        'level_req',
        'is_boss_level',
        'monster_id',
        'image_path',
        'is_active'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function monster()
    {
        return $this->belongsTo(Monster::class);
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserStageProgress::class);
    }
}
