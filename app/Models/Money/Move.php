<?php

namespace App\Models\Money;

use App\Contracts\Money\MovesContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Move extends Model
{
    use HasFactory;

    protected $casts = MovesContract::CASTS;

    protected $table = MovesContract::TABLE;

    protected $fillable = MovesContract::FILLABLE_FIELDS;

    public function city()
    {
        return $this->belongsTo(City::class, MovesContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function getIsEditableAttribute() {
        return $this->{MovesContract::FIELD_DATE}->format('Y') === date('Y') && $this->{MovesContract::FIELD_DATE}->format('m') === date('m');
    }

    public function payer() {
        $externalKey = null;
        $internalKey = MovesContract::FIELD_PAYER_ID;
        $payerClass = null;
        if ($this->{MovesContract::FIELD_PAYER_TYPE} === 'place') {
            $payerClass = Place::class;
            $externalKey = PlaceContract::FIELD_ID;
        } elseif ($this->{MovesContract::FIELD_PAYER_TYPE} === 'manager') {
            $payerClass = User::class;
            $externalKey = UserContract::FIELD_ID;
        }
        return $this->belongsTo($payerClass, $internalKey, $externalKey);
    }

    public function recipient() {
        $externalKey = null;
        $internalKey = MovesContract::FIELD_RECIPIENT_ID;
        $recipientClass = null;
        if ($this->{MovesContract::FIELD_RECIPIENT_TYPE} === 'place') {
            $recipientClass = Place::class;
            $externalKey = PlaceContract::FIELD_ID;
        } elseif ($this->{MovesContract::FIELD_RECIPIENT_TYPE} === 'manager') {
            $recipientClass = User::class;
            $externalKey = UserContract::FIELD_ID;
        }
        return $this->belongsTo($recipientClass, $internalKey, $externalKey);
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = (Carbon::createFromFormat('d.m.Y', $value))->format('Y-m-d');
    }
}
