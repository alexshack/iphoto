<div>
<!--Page header-->
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        {{--<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('money/moves')}}" class="font-weight-normal text-muted ml-2">Перемещения ДС</a></h4>--}}
        <h4 class="page-title">Добавить перемещение<a href="{{url('money/moves')}}" class="font-weight-normal text-muted ml-2">Перемещения ДС</a></h4>
    </div>
</div>
<!--End Page header-->


<!-- Row -->
<div class="row calcs-type">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Данные перемещения</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" wire:submit.prevent="submit">
                    <div class="form-group row">
                        <label class="form-label col-md-3">Дата</label>
                        <div class="col-md-9">
                            <input wire:model="moveData.date" type="text" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label  col-md-3">Город</label>
                        <div class="col-md-9">
                            <select wire:model="moveData.city_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
                                <option label="Выберите город"></option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-pay">
                        <div class="row">
                            <label class="form-label col-md-3">Выберите тип плательщика</label>
                            <ul class="tabs-menu nav col-md-9">
                                <li class="">
                                    <a wire:click="setPayerType('place')"
                                        href="#tab-1"
                                        {!! $moveData[App\Contracts\Money\MovesContract::FIELD_PAYER_TYPE] === 'place' ? 'class="active"' : '' !!}
                                        data-toggle="tab">
                                        Точка
                                    </a>
                                </li>
                                <li>
                                    <a wire:click="setPayerType('manager')"
                                        {!! $moveData[App\Contracts\Money\MovesContract::FIELD_PAYER_TYPE] === 'manager' ? 'class="active"' : '' !!}
                                        href="#tab-2"
                                        data-toggle="tab"
                                        >
                                        Менеджер
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane show {{ $moveData[App\Contracts\Money\MovesContract::FIELD_PAYER_TYPE] === 'place' ? 'active' : '' }}" id="tab-1">
                                <div class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="form-label col-md-3">Точка</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2-show-search custom-select" data-placeholder="Выберите точку" wire:model="moveData.payer_id">
                                                <option label="Выберите точку"></option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show {{ $moveData[App\Contracts\Money\MovesContract::FIELD_PAYER_TYPE] === 'manager' ? 'active' : '' }}" id="tab-2">
                                <div class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="form-label  col-md-3">Менеджер</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера" wire:model="moveData.payer_id">
                                                <option label="Выберите менеджера"></option>
                                                @foreach($managers as $manager)
                                                    <option value="{{ $manager->id }}">{{ $manager->getFullName() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-pay">
                        <div class="row">
                            <label class="form-label col-md-3">Выберите тип получателя</label>
                            <ul class="tabs-menu nav col-md-9">
                                <li class="">
                                    <a href="#tab-3"
                                       wire:click="setRecipientType('place')"
                                       {!! $moveData[App\Contracts\Money\MovesContract::FIELD_RECIPIENT_TYPE] === 'place' ? 'class="active"' : '' !!}
                                        data-toggle="tab">
                                        Точка
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab-4"
                                       wire:click="setRecipientType('manager')"
                                       {!! $moveData[App\Contracts\Money\MovesContract::FIELD_RECIPIENT_TYPE] === 'manager' ? 'class="active"' : '' !!}
                                        data-toggle="tab">
                                        Менеджер
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane {{ $moveData[App\Contracts\Money\MovesContract::FIELD_RECIPIENT_TYPE] === 'place' ? 'active' : '' }} show" id="tab-3">
                                <div class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="form-label col-md-3">Точка</label>
                                        <div class="col-md-9">
                                            <select wire:model="moveData.recipient_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
                                                <option label="Выберите точку"></option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{ $moveData[App\Contracts\Money\MovesContract::FIELD_RECIPIENT_TYPE] === 'manager' ? 'active' : '' }} show" id="tab-4">
                                <div class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="form-label  col-md-3">Менеджер</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
                                                <option label="Выберите менеджера"></option>
                                                @foreach($managers as $manager)
                                                    <option value="{{ $manager->id }}">{{ $manager->getFullName() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-md-3">Сумма</label>
                        <div class="col-md-9">
                            <input wire:model="moveData.amount" type="number" class="form-control" placeholder="Введите сумму" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-md-3">Примечания</label>
                        <div class="col-md-9">
                            <input wire:model="moveData.note" type="text" class="form-control" placeholder="Укажите примечания к перемещению" value="">
                        </div>
                    </div>

                    <!-- Алерт отображается удалением класса d-none -->
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            Необходимо заполнить поля:
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        </div>
                    @endif
                    <button class="btn btn-lg btn-primary" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@push('custom-scripts')
<script>
function moneyMoveCreateInit() {
    $('.select2-show-search2').select2({
        minimumResultsForSearch: 5,
        width: '100%'
    }).on('change', function(e) {
        var data = $(this).select2('val');
        var model = $(this).attr('wire:model');
        @this.set(model, data);
    });

    $( ".fc-datepicker" ).datepicker({
        dateFormat: "dd.mm.yy",
        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
    }).on('change', function (e) {
        var data = $(this).val();
        var model = $(this).attr('wire:model');
        console.log({model, data})
        @this.set(model, data);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    moneyMoveCreateInit();
    window.livewire.on('select2Hydrate',()=>{
        moneyMoveCreateInit();
    });
    window.Livewire.hook('component.initialized', (component) => {
        moneyMoveCreateInit();
    });
});
</script>
@endpush

