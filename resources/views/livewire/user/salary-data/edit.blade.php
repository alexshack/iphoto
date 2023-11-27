<div>
    @php
        use App\Contracts\Salary\CalcsTypeContract;
    use App\Contracts\UserSalaryDataContract;
@endphp
<div class="form-group">
    <label class="form-label" for="calc_type">
        Тип расчета
    </label>
    <select id="calc_type" class="form-control" name="calc_type" wire:model="salaryData.{{ UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE }}">
        <option value=""></option>
        @foreach($typesList as $typeKey => $typeItem)
            <option value="{{ $typeKey }}">{{ $typeItem['label'] }}</option>
        @endforeach
    </select>

</div>
<div class="form-group">
    <label class="form-label">Дата начала действия расчета</label>
    <input type="text" class="form-control fc-datepicker"  placeholder="ДД.MM.ГГГ"  wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_START_DATE }}">
</div>
<div class="form-group">
    <label class="form-label">{{ $amountLabel }}</label>
    <input type="number" class="form-control" placeholder="Значение процента"   wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_AMOUNT }}" step="0.01">
</div>
@if((int)$salaryData[UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE] === 1)
    <div class="form-group">
        <label class="form-label">Расходы точки</label>
        <select multiple="multiple" class="form-control" wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_CUSTOM_DATA }}">
            @foreach($expenseTypes as $expenseType)
                <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
            @endforeach
        </select>
    </div>
@endif
@if($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger" role="alert">
            <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
            Необходимо заполнить поля:
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    </div>
@endif
<button type="button" wire:loading.attr="disabled" wire:click.prevent="submit" class="btn btn-primary">Сохранить</button>
</div>

@push('custom-scripts')
    <!-- End Change salary Modal  -->
    <script>
        function formCreateInit() {
            console.log('init')
            $( ".fc-datepicker" ).datepicker({
                dateFormat: "yy-mm-dd",
                monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
            }).on('change', function (e) {
                var data = $(this).val();
                var model = $(this).attr('wire:model.defer');
                @this.set(model, data);
            });
        };
document.addEventListener('DOMContentLoaded', () => {
    formCreateInit();
    window.Livewire.hook('component.initialized', (component) => {
        formCreateInit();
    });
    window.Livewire.on('inputHydrate', () => {
        formCreateInit();
    })
});
    </script>
@endpush
