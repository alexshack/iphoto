<?php

namespace App\Models;

 use App\Contracts\UserPersonalDataContract;
 use App\Contracts\UserWorkDataContract;
use App\Contracts\UserContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = UserContract::FILLABLE_FIELDS;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = UserContract::HIDDEN_FIELDS;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = UserContract::CASTS_FIELDS;

    public function personalData()
    {
        return $this->hasOne(UserPersonalData::class, UserPersonalDataContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }

    public function workData()
    {
        return $this->hasOne(UserWorkData::class, UserWorkDataContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }

    protected static function booted(): void
    {
        // Создание анкеты при добавлении пользователя
        static::created(function (User $user) {
            UserPersonalData::create([
                UserPersonalDataContract::FIELD_USER_ID => $user->{ UserContract::FIELD_ID }
            ]);
            UserWorkData::create([
                UserWorkDataContract::FIELD_USER_ID => $user->{ UserContract::FIELD_ID }
            ]);
        });
    }
}
