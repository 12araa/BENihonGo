<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Cast options agar otomatis jadi Array/JSON
    protected $casts = [
        'options' => 'array',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
