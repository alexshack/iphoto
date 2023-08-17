<div>
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Добавить выплату<a href="{{url('salary/pays')}}" class="font-weight-normal text-muted ml-2">Выплаты</a></h4>
            {{--<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('salary/pays')}}" class="font-weight-normal text-muted ml-2">Выплаты</a></h4>--}}
        </div>
    </div>
    <!--End Page header-->


    <!-- Row -->
    <div class="row calcs-type">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Данные выплаты</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" wire:submit.prevent="submit">
                        <p>{{ serialize($pay) }}</p>
                        <p>{{ $billingMonth }}</p>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Дата</label>
                            <div class="col-md-9">
                                <input type="text" wire:model="pay.date" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Вид выплаты</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="pay.calcs_type_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите вид начисления">
                                    <option label="Выберите вид начисления"></option>
                                    <!-- Задаются жестко-->
                                    @foreach($calcTypes as $calcType)
                                        <option value="{{ $calcType->id }}">{{ $calcType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Расчетный месяц</label>
                            <div class="col-md-9">
                                <input wire:model="billingMonth" class="form-control" id="datepicker-month" placeholder="Выберите месяц" value="Июнь 2023" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Город</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="pay.city_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите город">
                                    <option label="Выберите город"></option>
                                    <!-- Если Админ, то все города. Если Менеджер, только Менеджер.Город-->
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-pay">
                            <div class="row">
                                <label class="form-label col-md-3">Выберите тип источника</label>
                                <ul class="tabs-menu nav col-md-9">
                                    <li class="">
                                        <a href="#tab-1"
                                           wire:click="setSourceType('place')"
                                           {!! $pay[App\Contracts\Salary\PaysContract::FIELD_SOURCE_TYPE] === 'place' ? 'class="active"' : '' !!}
                                            data-toggle="tab">
                                            Точка
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab-2"
                                           wire:click="setSourceType('manager')"
                                           {!! $pay[App\Contracts\Salary\PaysContract::FIELD_SOURCE_TYPE] === 'manager' ? 'class="active"' : '' !!}
                                            data-toggle="tab">
                                            Менеджер
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane show {{ $pay[App\Contracts\Salary\PaysContract::FIELD_SOURCE_TYPE] === 'place' ? 'active' : '' }}" id="tab-1">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="form-label  col-md-3">Точка</label>
                                            <div class="col-md-9" wire:ignore.self>
                                                <select data-select-init="true" wire:model="pay.source_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите точку">
                                                    <option label="Выберите точку"></option>
                                                    <!-- Если Админ, то точки с фильтром по городу, выбранному выше. Если менеджер, то все точки с Точка.Город = Менджер.Город -->
                                                    @foreach($places as $place)
                                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane show {{ $pay[App\Contracts\Salary\PaysContract::FIELD_SOURCE_TYPE] === 'manager' ? 'active' : '' }}" id="tab-2">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="form-label  col-md-3">Менеджер</label>
                                            <div class="col-md-9" wire:ignore.self>
                                                <select data-select-init="true" wire:model="pay.source_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите менеджера">
                                                    <option label="Выберите менеджера"></option>
                                                    <!-- Если Админ, то менеджер с фильтром по городу, выбранному выше. Если менеджер, то только он -->
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
                            <label class="form-label  col-md-3">Сотрудник</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="pay.user_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите сотрудника">
                                    <option label="Выберите сотрудника"></option>
                                    <!-- Сотрудники с фильтром по городу, выбранному выше -->
                                    @foreach($managers as $user)
                                        <option value="{{ $user->id }}">{{ $user->getFullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Сумма</label>
                            <div class="col-md-9">
                                <input wire:model="pay.amount" type="number" class="form-control" placeholder="Введите сумму" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-label col-md-3">Выдано</div>
                            <label class="custom-switch col-md-9">
                                <input wire:model="pay.issued" type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator custom-switch-indicator-xl"></span>
                                <span class="custom-switch-description">Да</span>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Примечания</label>
                            <div class="col-md-9">
                                <input wire:model="pay.note" type="text" class="form-control" placeholder="Укажите примечания к начислению" value="">
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
    <!-- End Row-->
</div>

@push('custom-scripts')
<script>
function moneyCalcCreateInit() {
    $( ".fc-datepicker" ).datepicker({
        dateFormat: "dd.mm.yy",
        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
    }).on('change', function (e) {
        var data = $(this).val();
        var model = $(this).attr('wire:model');
        @this.set(model, data);
    });
    $('#datepicker-month').bootstrapdatepicker({
        language: 'ru-RU',
        format: "MM yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        endDate: '0d'
    }).on('changeDate', function (e) {
        var data = $(this).val();
        var model = $(this).attr('wire:model');
        @this.set(model, data);
    });
}

$(document).ready(function() {
    moneyCalcCreateInit();
    window.livewire.on('select2Hydrate',()=>{
        moneyCalcCreateInit();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    window.Livewire.hook('component.initialized', (component) => {
        moneyCalcCreateInit();
    });
});
</script>
@endpush
