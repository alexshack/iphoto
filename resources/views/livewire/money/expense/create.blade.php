<div>
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            {{--<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('money/expenses')}}" class="font-weight-normal text-muted ml-2">Расходы ДС</a></h4>--}}
            <h4 class="page-title">Добавить расход<a href="{{url('money/expenses')}}" class="font-weight-normal text-muted ml-2">Расходы ДС</a></h4>
        </div>
    </div>
    <!--End Page header-->


    <!-- Row -->
    <div class="row calcs-type">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Данные расхода</h4>
                </div>
                <div class="card-body">
                    {{--<p>{{ serialize($expense) }}</p>--}}
                    {{--<p>{{ serialize($payerType) }}</p>--}}
                    <form class="form-horizontal" wire:submit.prevent="submit">
                        <div class="form-group row">
                            <label class="form-label col-md-3">Дата</label>
                            <div class="col-md-9">
                                <input wire:model="expense.date" type="text" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Вид расхода</label>
                            <div class="col-md-9">
                                <select wire:model="expense.expense_type_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите вид расхода">
                                    <option label="Выберите вид расхода"></option>
                                    <!-- expenses-types where expenses-types.status = active and user.role in expenses-types.roles -->
                                    @foreach($expenseTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Город</label>
                            <div class="col-md-9">
                                <select wire:model="expense.city_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
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
                                <label class="form-label col-md-3">Выберите тип плательщика</label>
                                <ul class="tabs-menu nav col-md-9">
                                    <li class="">
                                        <a
                                            wire:click="setPayerType({{ \App\Contracts\Money\ExpenseContract::TYPE_PLACE }})"
                                            href="#tab-1"
                                            class="@if($payerType === \App\Contracts\Money\ExpenseContract::TYPE_PLACE)active @endif"
                                            data-toggle="tab">Точка</a>
                                    </li>
                                    <li>
                                        <a
                                            wire:click="setPayerType({{ \App\Contracts\Money\ExpenseContract::TYPE_MANAGER }})"
                                            class="@if($payerType === \App\Contracts\Money\ExpenseContract::TYPE_MANAGER)active @endif"
                                            href="#tab-2"
                                            data-toggle="tab" class="">Менеджер</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane @if($payerType === \App\Contracts\Money\ExpenseContract::TYPE_PLACE)active @endif show" id="tab-1">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="form-label  col-md-3">Точка</label>
                                            <div class="col-md-9">
                                                <select wire:model="expense.place_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
                                                    <option label="Выберите точку"></option>
                                                    <!-- Если Админ, то точки с фильтром по городу, выбранному выше. Если менеджер, то все точки с Точка.Город = Менджер.Город -->
                                                    @foreach($places as $place)
                                                        <option value="{{ $place->id }}">{{ $place->name }} {{ $place->city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane show @if($payerType === \App\Contracts\Money\ExpenseContract::TYPE_MANAGER)active @endif" id="tab-2">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="form-label  col-md-3">Менеджер</label>
                                            <div class="col-md-9">
                                                <select wire:model="expense.manager_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
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
                            <label class="form-label col-md-3">Сумма</label>
                            <div class="col-md-9">
                                <input wire:model="expense.amount" type="number" class="form-control" placeholder="Введите сумму" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Чек</label>
                            <div class="input-group col-md-9 file-browser">
                                <input type="text" class="form-control browse-file" wire:model="expense.check_file" placeholder="Загрузите чек">
                                <label class="input-group-append">
                                    <span class="btn btn-primary">
                                        Выбрать файл <input  wire:model="checkFile" type="file" style="display: none;">
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-md-3">Примечания</label>
                            <div class="col-md-9">
                                <input type="text" wire:model="expense.note" class="form-control" placeholder="Укажите примечания к расходу" value="">
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

@push('custom-scripts')
<script>
function moneyExpenseCreateInit() {
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
        @this.set(model, data);
    });
}

$(document).ready(function() {
    moneyExpenseCreateInit();
    window.livewire.on('select2Hydrate',()=>{
        moneyExpenseCreateInit();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    window.Livewire.hook('component.initialized', (component) => {
        moneyExpenseCreateInit();
    });
});
</script>
@endpush

