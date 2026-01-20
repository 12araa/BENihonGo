<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'chapter_number', 'is_active'];

    public function stages()
    {
        return $this->hasMany(Stage::class)->orderBy('stage_number');
    }
}
