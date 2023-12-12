@php
    use App\Contracts\SettingContract;
@endphp

<div class="card">
    <div class="card-header">
        <div class="card-title">Редактирование настройки {{ $setting->{SettingContract::FIELD_NAME} }}</div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="type">Тип настройки</label>
            <select id="" class="form-control custom-select" name="" wire:model="setting.{{ SettingContract::FIELD_TYPE }}">
                @foreach($settingTypes as $settingTypeKey => $settingType)
                    <option value="{{ $settingTypeKey }}" {{ $settingTypeKey === $setting->{SettingContract::FIELD_TYPE} ? 'selected' : '' }}>
                        {{ SettingContract::TYPES_LIST_LABELS[$settingTypeKey] }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($setting->{SettingContract::FIELD_TYPE} === 2)
            <div class="form-group">
                <label for="modelName">Сущность</label>
                <select id="modelName" class="form-control custom-select" name="modelName" wire:model="setting.{{ SettingContract::FIELD_MODEL }}">
                    <option value=""></option>
                    @foreach($models as $modelName => $model)
                        <option value="{{ $modelName }}">{{ $model['label'] }}</option>
                    @endforeach
                </select>
            </div>

            @if($setting->{SettingContract::FIELD_MODEL})
                <div class="form-group">
                    <label for="valueModel">Значение</label>
                    <select id="valueModel" class="form-control custom-select" name="" wire:model="setting.{{ SettingContract::FIELD_VALUE }}">
                        <option value=""></option>
                        @foreach($modelOptions as $key => $value)
                            <option value="{{ $key }}"> {{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        @endif

        @if ($setting->{SettingContract::FIELD_TYPE} === 1)
            <div class="form-group">
                <label for="textValue">Значение</label>
                <input class="form-control" type="text" wire:model="setting.{{ SettingContract::FIELD_VALUE }}">
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                Необходимо заполнить поля:
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>
        @endif
    </div>

    <div class="card-footer">
        <button class="btn btn-success" type="button" wire:loading.attr="disabled" wire:click="submit">Сохранить</button>
    </div>
</div>
