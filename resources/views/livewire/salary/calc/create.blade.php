<div>

    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            {{--<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('salary/calcs')}}" class="font-weight-normal text-muted ml-2">Начисления</a></h4>--}}
            <h4 class="page-title">Добавить начисление<a href="{{url('salary/calcs')}}" class="font-weight-normal text-muted ml-2">Начисления</a></h4>
        </div>
    </div>
    <!--End Page header-->


    <!-- Row -->
    <div class="row calcs-type">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Данные начисления</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" wire:submit.prevent="submit">
                        <div class="form-group row">
                            <label class="form-label col-md-3">Дата</label>
                            <div class="col-md-9">
                                <input type="text" wire:model="calc.date" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Вид начисления</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="calc.calcs_type_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}"  data-placeholder="Выберите вид начисления">
                                    <option label="Выберите вид начисления"></option>
                                    <!-- Виды начислений с типом Ввод вручную-->
                                    @foreach($calcTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Город</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="calc.city_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите город">
                                    <option label="Выберите город"></option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Точка</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="calc.place_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите точку">
                                    <option label="Выберите точку"></option>
                                    <!-- Точки с фильтром по городу, выбранному выше-->
                                    @foreach($places as $place)
                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Сотрудник</label>
                            <div class="col-md-9" wire:ignore.self>
                                <select data-select-init="true" wire:model="calc.user_id" data-pharaonic="select2" data-component-id="{{ $this->id  }}" data-placeholder="Выберите сотрудника">
                                    <option label="Выберите сотрудника"></option>
                                    <!-- Сотрудники с фильтром по городу, выбранному выше и полю выбранного вида начисления Должности, участвующие в расчете-->
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->getFullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Сумма</label>
                            <div class="col-md-9">
                                <input wire:model="calc.amount" type="number" class="form-control" placeholder="Введите сумму" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Примечания</label>
                            <div class="col-md-9">
                                <input wire:model="calc.note" type="text" class="form-control" placeholder="Укажите примечания к начислению" value="">
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
