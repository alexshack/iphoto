<div class="card">
    @php
        use App\Contracts\Salary\PaysContract;
    @endphp
    <div class="card-header justify-content-between">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">Дата</label>
                <input type="text" wire:loading.attr="disabled" wire:model="filterDate" class="form-control filterDatePicker" placeholder="MM.YYYY" value="" id="filterDatePickerPays">
            </div>
        </div>
        <div class="col-md-3">
            <span>
                Итого: {{ $total }}
            </span>
        </div>
    </div>
    <div class="card-body">
    <table class="table  table-vcenter table-bordered border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Дата</th>
                <th class="border-bottom-0">Вид начисления</th>
                <th class="border-bottom-0">Город</th>
                <th class="border-bottom-0">Точка</th>
                <th class="border-bottom-0">Сумма</th>
                <th class="border-bottom-0">Выдано</th>
                <th class="border-bottom-0">Комментарий</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pays as $pay)
                <tr>
                    <td>{{ $pay->id }}</td>
                    <td data-order="<?php strtotime($pay->date) ?>">
                        @if($pay->type === 1)
                            {{ $pay->date->format('d.m.Y') }}
                        @else
                            <a href="/money/days/0">{{ $pay->date->format('d.m.Y') }}</a>
                        @endif
                    </td>
                    <td>
                        {{ $pay->calcType ? $pay->calcType->name : '' }}
                        <p><span class="text-muted text-small">{{ $pay->payType }}</span></p>
                    </td>
                    <td data-order="{{ $pay->city ? $pay->city->name : '' }}">
                        <a href="admin/structure/cities/{{ $pay->city_id }}">
                            {{ $pay->city ? $pay->city->name : '' }}
                        </a>
                    </td>
                    <td data-order="{{ $pay->{PaysContract::FIELD_SOURCE_ID} }}">
                        @if($pay->{PaysContract::FIELD_SOURCE_TYPE} === 2)
                        <a href="{{ route('admin.structure.places.edit', ['id' => $pay->{PaysContract::FIELD_SOURCE_ID}]) }}">
                            {{  $pay->source ? $pay->source->name : '' }}
                        </a>
                        @else
                            -
                        @endif
                    </td>
                    <td data-order="{{ $pay->amount }}" class="text-right {{ $pay->amount < 0 ? 'text-danger' : '' }}">
                        {{ $pay->amount }}₽
                    </td>
                    <td>
                        @if($pay->{ PaysContract::FIELD_ISSUED })
                            <div class="d-flex align-items-center align-content-center">
                                <span class="feather feather-check text-success mr-2"></span>
                                Выдано
                            </div>
                        @endif
                    </td>
                    <td>
                        {{ $pay->{ PaysContract::FIELD_NOTE } }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="card-footer">
        {{ $pays->links() }}
    </div>
</div>

@push('custom-scripts')
<script>
function payFilterCreateInit() {
    $('#filterDatePickerPays').bootstrapdatepicker({
        language: 'ru-RU',
        format: "MM yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        endDate: '0d'
    }).on('changeMonth', function (e) {
        var model = $(this).attr('wire:model');
        @this.emit('onChangeMonth', e.date.getMonth() + 1, e.date.getFullYear());
    });
}

$(document).ready(function() {
    payFilterCreateInit();
    window.livewire.on('updatedComponent',()=>{
        payFilterCreateInit();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    window.Livewire.hook('component.initialized', (component) => {
        payFilterCreateInit();
    });
});
</script>
@endpush
