<?php

namespace App\Models;

 use App\Contracts\UserPersonalDataContract;
 use App\Contracts\UserWorkDataContract;
use App\Contracts\UserContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 use Illuminate\Support\Facades\Storage;
 use Illuminate\Support\Str;
 use Laravel\Sanctum\HasApiTokens;
 use \Illuminate\Auth\Passwords\CanResetPassword;
 use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, CanResetPassword;

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

    public function getPersonalData(): UserPersonalData
    {
        return $this->personalData()->first();
    }

    public function workData()
    {
        return $this->hasOne(UserWorkData::class, UserWorkDataContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }

    public function getWorkData(): UserWorkData
    {
        return $this->workData()->first();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
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

    public function getFullName($data = 'F I'):string
    {
        return str_replace(
            [
                'F',
                'I',
                'O'],
            [
                $this->getPersonalData()->{ UserPersonalDataContract::FIELD_LAST_NAME },
                $this->getPersonalData()->{ UserPersonalDataContract::FIELD_FIRST_NAME },
                $this->getPersonalData()->{ UserPersonalDataContract::FIELD_MIDDLE_NAME }
            ], $data);
    }

    public function getAgeAttribute()
    {
        if(!empty($this->getPersonalData()->{ UserPersonalDataContract::FIELD_BIRTHDAY })) {
            $birthDate = $this->getPersonalData()->{ UserPersonalDataContract::FIELD_BIRTHDAY };
            $currentDate = Carbon::now();
            return $currentDate->diffInYears($birthDate);
        }
        return 0;
    }

    public function updateUser(array $data, $photo)
    {
        if($this->{ UserContract::FIELD_EMAIL } != $data['user'][UserContract::FIELD_EMAIL]) {
            $this->update([UserContract::FIELD_EMAIL => $data['user'][UserContract::FIELD_EMAIL]]);
        }
        if(!empty($photo)) {
            $path = $this->uploadPhoto($photo);
            $this->update([UserContract::FIELD_PHOTO => $path]);
        }
        $this->getPersonalData()->update($data['personal']);
        $this->getWorkData()->update($data['work']);
    }

    public function uploadPhoto($photo)
    {
        $filename = Str::uuid().'.'.$photo->getClientOriginalExtension();
        $path = $photo->storeAs('images', $filename);
        return '/storage/' . $path;
    }
}
