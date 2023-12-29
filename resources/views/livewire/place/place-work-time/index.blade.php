@php
    use App\Contracts\Structure\PlaceWorkTimeContract;
@endphp
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Расписание работы</h4>
    </div>
    <div class="card-body">
        <button class="btn btn-success" type="button" wire:click="submit" wire:loading.attr="disabled">Сохранить график</button>
        <ul class="list-group">
            @foreach($workTimes as $key => $workTime)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-4">
                        <p class="lead">
                        <span class="text-bold">
                            {{ $workTime['weekDayName'] }}
                        </span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="workTime[{{ $key }}][{{ PlaceWorkTimeContract::FIELD_START_TIME }}]">
                                {{ PlaceWorkTimeContract::ATTRIBUTES[PlaceWorkTimeContract::FIELD_START_TIME] }}
                            </label>
                            <input wire:model.defer="workTimes.{{ $key }}.{{ PlaceWorkTimeContract::FIELD_START_TIME }}" type="time" class="form-control" id="workTime[{{ $key }}][{{ PlaceWorkTimeContract::FIELD_START_TIME }}]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="workTime[{{ $key }}][{{ PlaceWorkTimeContract::FIELD_END_TIME }}]">
                                {{ PlaceWorkTimeContract::ATTRIBUTES[PlaceWorkTimeContract::FIELD_END_TIME] }}
                            </label>
                            <input wire:model.defer="workTimes.{{ $key }}.{{ PlaceWorkTimeContract::FIELD_END_TIME }}" type="time" class="form-control" id="workTime[{{ $key }}][{{ PlaceWorkTimeContract::FIELD_END_TIME }}]">
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <button class="btn btn-success" type="button" wire:click="submit" wire:loading.attr="disabled">Сохранить график</button>
    </div>
    {{-- Success is as dangerous as failure. --}}
</div>
