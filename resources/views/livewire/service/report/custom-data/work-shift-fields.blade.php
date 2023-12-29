<div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_start">Дата начала</label>
                <input class="form-control" type="date" wire:model.defer="customData.date_start">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_end">Дата окончания</label>
                <input class="form-control" type="date" wire:model.defer="customData.date_end">
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($companyStructure as $city)
        <div class="col-md-4">
            <h4>{{ $city['label'] }}</h4>
            <ul class="list-group">
                @foreach($city['places'] as $place)
                <li class="list-group-item">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="place_{{ $place['id'] }}" wire:model.defer="customData.places.{{ $place['id'] }}">
                        <label class="custom-control-label" for="place_{{ $place['id'] }}">{{ $place['label'] }}</label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <button class="btn btn-success" type="submit" wire:click="submit" wire:loading.attr="disabled">Создать</button>
        </div>
    </div>
</div>
