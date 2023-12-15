<?php

namespace App\Models\Service;

use App\Contracts\Service\PaysGeneratorContract;
use App\Contracts\UserContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaysGenerator extends Model
{
    use HasFactory;

    protected $fillable = PaysGeneratorContract::FILLABLE;

    protected $table = PaysGeneratorContract::TABLE;

    public function user()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
