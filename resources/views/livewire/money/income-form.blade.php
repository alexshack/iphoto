<div>
{{--    <form class="form-horizontal">--}}
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
        <input type="hidden" name="{{ \App\Contracts\Money\IncomeContract::FIELD_TYPE }}" wire:model="type">

        <div class="form-group row">
            <label class="form-label col-md-3">Дата</label>
            <div class="col-md-9">
                <input type="text" name="{{ \App\Contracts\Money\IncomeContract::FIELD_DATE }}" wire:model="date" class="form-control fc-datepicker" placeholder="DD.MM.YYYY">
            </div>
        </div>
        <div class="form-group row">
            <label class="form-label  col-md-3">Вид поступления</label>
            <div class="col-md-9">
                <select class="form-control select2-show-search2 custom-select" wire:model="income_type_id" name="{{ \App\Contracts\Money\IncomeContract::FIELD_TYPE_ID }}" data-placeholder="Выберите вид поступления">
                    <option label="Выберите вид начисления"></option>
                    <!-- incomes-types where incomes-types.status = active -->
                    @foreach($types as $type)
                        @if($type->{ \App\Contracts\Money\IncomesTypeContract::FIELD_STATUS } == 1)
                            <option value="{{ $type->{ \App\Contracts\Money\IncomesTypeContract::FIELD_ID } }}" {{ (isset($income) && $income->{ \App\Contracts\Money\IncomeContract::FIELD_TYPE_ID } == $type->{ \App\Contracts\Money\IncomesTypeContract::FIELD_ID }) ? 'selected' : '' }}>{{ $type->{ \App\Contracts\Money\IncomesTypeContract::FIELD_NAME } }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="form-label  col-md-3">Город</label>
            <div class="col-md-9">
                <select class="form-control select2-show-search2 custom-select" name="{{ \App\Contracts\Money\IncomeContract::FIELD_CITY_ID }}" wire:model="city_id" data-placeholder="Выберите город">
                    <option label="Выберите город"></option>
                    <!-- Если Админ, то все города. Если Менеджер, только Менеджер.Город-->
                    @foreach($cities as $city)
                        <option value="{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_ID } }}" {{ (isset($income) && $income->{ \App\Contracts\Money\IncomeContract::FIELD_CITY_ID } == $city->{ \App\Contracts\Structure\CityContract::FIELD_ID }) ? 'selected' : '' }}>{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-pay">
            <div class="row">
                <label class="form-label col-md-3">Выберите тип получателя</label>
                <ul class="tabs-menu nav col-md-9">
                    <li class=""><a href="#tab-1" wire:click="changeType(1)" class="{{ ($this->type == 1) ? 'active' : '' }}" data-toggle="tab">Точка</a></li>
                    <li><a href="#tab-2" wire:click="changeType(2)" class="{{ ($this->type == 2) ? 'active' : '' }}" data-toggle="tab">Менеджер</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane show {{ ($this->type == 1) ? 'active' : '' }}" id="tab-1">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Точка</label>
                            <div class="col-md-9">
                                <select wire:model="place_id" class="form-control select2-liveware select2-show-search2 custom-select" data-placeholder="Выберите точку">
                                    <option label="Выберите точку"></option>
                                    <!-- Если Админ, то точки с фильтром по городу, выбранному выше. Если менеджер, то все точки с Точка.Город = Менджер.Город -->
                                    @foreach($places as $place)
                                        <option value="{{ $place->{ \App\Contracts\Structure\PlaceContract::FIELD_ID } }}">{{ $place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane show {{ ($this->type == 2) ? 'active' : '' }}" id="tab-2">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <label class="form-label  col-md-3">Менеджер</label>
                            <div class="col-md-9">
                                <select wire:model="manager_id" class="form-control select2-show-search2 custom-select" data-placeholder="Выберите менеджера">
                                    <option label="Выберите менеджера"></option>
                                    <!-- Если Админ, то менеджер с фильтром по городу, выбранному выше. Если менеджер, то только он -->
                                    @foreach($users as $user)
                                        @if($user->user)
                                            <option value="{{ (isset($user->user)) ? $user->user->{ \App\Contracts\UserContract::FIELD_ID } : '' }}">{{ $user->user->getFullName() }}</option>
                                        @endif
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
                <input type="number" class="form-control" wire:model="amount" placeholder="Введите сумму" value="">
            </div>
        </div>
        <div class="form-group row">
            <label class="form-label col-md-3">Примечания</label>
            <div class="col-md-9">
                <input type="text" class="form-control" wire:model="note" placeholder="Укажите примечания к поступлению" value="">
            </div>
        </div>

        <!-- Алерт отображается удалением класса d-none -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button class="btn btn-lg btn-primary" wire:click="submit()">Сохранить</button>
{{--    </form>--}}
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $( ".fc-datepicker" ).datepicker({
                dateFormat: "dd.mm.yy",
                monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
            }).on('change', function (e) {
                var data = $(this).val();
                var model = $(this).attr('wire:model');
                @this.set(model, data);
            });

            $('.select2-show-search2').select2({
                minimumResultsForSearch: 5,
                width: '100%'
            }).on('change', function(e) {
                var data = $(this).select2('val');
                var model = $(this).attr('wire:model');
                @this.set(model, data);
            });
            window.livewire.on('select2Hydrate',()=>{
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
            });
        });
    </script>
@endpush
