<?php

namespace App\Models\Service;

use App\Contracts\Service\ReportContract;
use App\Contracts\UserContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Report extends Model
{
    use HasFactory;

    protected $casts = ReportContract::CASTS;

    protected $table = ReportContract::TABLE;

    protected $fillable = ReportContract::FILLABLE;

    public function getFileNameAttribute()
    {
        $id = $this->{ ReportContract::FIELD_ID };
        $userID = $this->{ ReportContract::FIELD_USER_ID };
        $createdAt = $this->created_at;
        $type = $this->{ ReportContract::FIELD_TYPE };
        $uuid = base64_encode("$id-$type-$userID-$createdAt");
        return "$uuid.xlsx";
    }

    public function getTitleAttribute()
    {
        $typeName = $this->typeName;
        $customString = '';
        switch ($this->{ ReportContract::FIELD_TYPE }) {
        case 'workshift':
            $customData = $this->{ ReportContract::FIELD_CUSTOM_DATA };
            if (!is_array($customData)) {
                $customData = json_decode($customData, true);
            }
            if (isset($customData['date_start'])) {
                $customString .= "С {$customData['date_start']} ";
            }
            if (isset($customData['date_end'])) {
                $customString .= "по {$customData['date_end']}";
            }
            break;
        default:
            break;
        }
        return $customString;
    }

    public function getTypeNameAttribute()
    {
        return isset(ReportContract::TYPES[$this->{ ReportContract::FIELD_TYPE }]) ? ReportContract::TYPES[$this->{ ReportContract::FIELD_TYPE }] : '';
    }

    public function getUrlAttribute()
    {
        $fileName = $this->fileName;
        return Storage::disk('public')->url("report-files/$fileName");
    }

    public function scopeFilterData($query)
    {
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, ReportContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
