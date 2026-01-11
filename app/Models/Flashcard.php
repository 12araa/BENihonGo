<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
