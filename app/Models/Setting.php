<?php

namespace App\Models;

use App\Contracts\SettingContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = SettingContract::TABLE;

    protected $fillable = SettingContract::FILLABLE;

    public function getClassNameAttribute()
    {
        $modelName = $this->{SettingContract::FIELD_MODEL};
        $className = '';
        if (isset(SettingContract::MODELS[$modelName])) {
            $className = SettingContract::MODELS[$modelName]['class'];
        }
        return $className;
    }

    public function getValuePreviewAttribute()
    {
        $str = '';

        if ($this->{SettingContract::FIELD_TYPE} === 2) {
            if (class_exists($this->className)) {
                $className = $this->className;
                $entity = $className::find($this->{SettingContract::FIELD_VALUE});
                if ($entity) {
                    $str = $entity->name;
                }
            } else {
                $str = '-';
            }
        } else {
            $str = $this->{SettingContract::FIELD_VALUE};
        }

        return $str;
    }

    public function getModelValueOptions()
    {
        $options = [];
        if ($this->{SettingContract::FIELD_TYPE} === 2) {
            $className = $this->className;
            if (class_exists($className)) {
                $entries = $className::all();
                if ($entries->count() > 0) {
                    $options[0] = 'Выберите значение';

                    foreach ($entries as $entry) {
                        $options[$entry->id] = $entry->name;
                    }
                }
            }
        }
        return $options;
    }
}
