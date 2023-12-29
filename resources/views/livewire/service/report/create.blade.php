<div class="card">
    <div class="card-header">
        <div class="card-title">Добавить отчет</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="report_type">Тип отчета</label>
                    <select class="custom-select" id="report_type" name="report_type" wire:model="reportType">
                        <option value=""></option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if($reportType === 'workshift')
            @livewire('service.report.custom-data.work-shift-fields')
        @endif
    </div>
</div>
