<div class="card">
    <div class="card-header justify-content-between">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">Дата</label>
                <input type="text" wire:loading.attr="disabled" wire:model="filterDate" class="form-control filterDatePicker" placeholder="MM.YYYY" value="" id="filterDatePickerCalcs">
            </div>
        </div>
        <div class="col-md-3">
            <span>
                Итого: {{ $total }}
            </span>
        </div>
    </div>
    <div class="card-body">
    <table class="table  table-vcenter text-nowrap table-bordered border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Дата</th>
                <th class="border-bottom-0">Вид начисления</th>
                <th class="border-bottom-0">Город</th>
                <th class="border-bottom-0">Точка</th>
                <th class="border-bottom-0">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calcs as $calc)
                <tr>
                    <td>{{ $calc->id }}</td>
                    <td data-order="<?php strtotime($calc->date) ?>">
                        @if($calc->type === 1)
                            {{ $calc->date->format('d.m.Y') }}
                        @else
                            <a href="/money/days/0">{{ $calc->date->format('d.m.Y') }}</a>
                        @endif

                    </td>
                    <td>{{ $calc->calcType ? $calc->calcType->name : '' }}</td>
                    <td data-order="{{ $calc->city ? $calc->city->name : '' }}">
                        <a href="admin/structure/cities/{{ $calc->city_id }}">
                            {{ $calc->city ? $calc->city->name : '' }}
                        </a>
                    </td>
                    <td data-order="{{ $calc->place ? $calc->place->name : '' }}">
                        <a href="{{ route('admin.structure.places.edit', ['id' => $calc->city_id]) }}">
                            {{ $calc->place ? $calc->place->name : '' }}
                        </a>
                    </td>
                    <td data-order="{{ $calc->amount }}" class="text-right {{ $calc->amount < 0 ? 'text-danger' : '' }}">
                        {{ $calc->amount }}₽
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="card-footer">
        {{ $calcs->links() }}
    </div>
</div>

@push('custom-scripts')
<script>
function calcFilterCreateInit() {
    $('#filterDatePickerCalcs').bootstrapdatepicker({
        language: 'ru-RU',
        format: "MM yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        endDate: '0d'
    }).on('changeMonth', function (e) {
        var model = $(this).attr('wire:model');
        @this.emit('onChangeMonth', e.date.getMonth() + 1, e.date.getFullYear());
        {{--@this.set(model, data);--}}
    });
}

$(document).ready(function() {
    calcFilterCreateInit();
    window.livewire.on('updatedComponent',()=>{
        calcFilterCreateInit();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    window.Livewire.hook('component.initialized', (component) => {
        calcFilterCreateInit();
    });
});
</script>
@endpush
