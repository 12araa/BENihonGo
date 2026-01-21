<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function gamification()
    {
        return $this->hasOne(UserGamification::class);
    }

    // 2. Settings (Target harian, Focus duration)
    public function setting()
    {
        return $this->hasOne(UserSetting::class);
    }

    // 3. Avatar yang sedang dipakai
    public function equippedAvatar()
    {
        return $this->belongsTo(Item::class, 'equipped_avatar_id');
    }

    // 4. Progress Stage (Mana yang udah unlock/selesai)
    public function stageProgress()
    {
        return $this->hasMany(UserStageProgress::class);
    }

    // 5. Inventory Item
    public function inventory()
    {
        return $this->hasMany(UserItem::class);
    }

    // 6. Log Pomodoro
    public function pomodoroLogs()
    {
        return $this->hasMany(PomodoroLog::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'user_items')
                    ->withPivot('is_equipped')
                    ->withTimestamps();
    }
}
