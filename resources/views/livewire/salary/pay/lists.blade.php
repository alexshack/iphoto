<div class="card">
    @php
        use App\Contracts\Salary\PaysContract;
    @endphp
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Списки</h4>
        <div class="card-actions">
            @if($isInProcess)
                <div class="btn btn-primary">
                    <span class="spinner-border spinner-border-sm"></span>
                    Создание списков
                </div>
            @endif
            @if($isEmptyLists && !$isInProcess)
                <button class="btn btn-primary" type="button" wire:loading.attr="disabled" wire:click="generatePays">
                    Создать списки
                </button>
            @endif
        </div>

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Дата</label>
                    <input type="text" wire:loading.attr="disabled" wire:model="filterDate" class="form-control filterDatePicker" placeholder="MM.YYYY" value="" id="filterDatePickerPays">
                </div>
            </div>
            @if(count($lists) > 0)
            <div class="col-md-4">
                <div class="d-flex">
                    @foreach($lists as $title => $listURL)
                        <a class="btn btn-success mr-1" target="blank" href="{{ $listURL }}">
                            <span class="feather feather-download"></span>
                            {{ $title }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @if(!$isEmptyLists)
        <nav class="tab-menu-heading hremp-tabs p-0">
            <div class="tabs-menu1">
            <ul class="nav panel-tabs-tabs">
                <li class="ml-4">
                    <a class="active" href="#salary10" data-toggle="tab">
                        Список на зп
                    </a>
                </li>
                <li>
                    <a href="#salary25" data-toggle="tab">
                        Список на оклад
                    </a>
                </li>
            </ul>
            </div>
        </nav>
        <div class="tab-content">
            <div class="tab-pane active" id="salary10" role="tabpanel" aria-labeledby="tab">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Сотрудник</th>
                                <th class="border-bottom-0">Сумма</th>
                                <th class="border-bottom-0">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salary10'] as $payItem)
                                <tr>
                                    <td>{{ $payItem->user->name }}</td>
                                    <td>{{ $payItem->{ PaysContract::FIELD_AMOUNT } }}</td>
                                    <td>
                                        <div class="d-flex align-items-center align-content-center">
                                        @if($payItem->{ PaysContract::FIELD_ISSUED })
                                            <span class="feather feather-check text-success mr-2"></span>
                                            Выдано
                                        @else
                                            <button class="btn btn-primary btn-sm" wire:click="issuePayItem({{ $payItem->{ PaysContract::FIELD_ID } }})" wire:loading.attr="disabled">Выдать</button>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data['salary10']->links() }}
                </div>
            </div>
            <div class="tab-pane fade" id="salary25" role="tabpanel" aria-labeledby="tab">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Сотрудник</th>
                                <th class="border-bottom-0">Сумма</th>
                                <th class="border-bottom-0">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salary25'] as $payItem)
                                <tr>
                                    <td>{{ $payItem->user->name }}</td>
                                    <td>{{ $payItem->{ PaysContract::FIELD_AMOUNT } }}</td>
                                    <td>
                                        <div class="d-flex align-items-center align-content-center">
                                        @if($payItem->{ PaysContract::FIELD_ISSUED })
                                            <span class="feather feather-check text-success mr-2"></span>
                                            Выдано
                                        @else
                                            <button class="btn btn-primary btn-sm" wire:click="issuePayItem({{ $payItem->{ PaysContract::FIELD_ID } }})" wire:loading.attr="disabled">Выдать</button>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data['salary25']->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
    @if($isInProcess)
        <script>
        setTimeout(function () {
            @this.emit('checkSalaryGenerationProcess');
        }, 5000);
        </script>
    @endif
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
