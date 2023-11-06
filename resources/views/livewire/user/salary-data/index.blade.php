<div class="user-salary-data">
    @php
        use App\Contracts\UserSalaryDataContract;
    @endphp
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="mb-5 mt-7 font-weight-bold">Заработная плата</h4>
        @livewire('user.salary-data.create', compact('user', 'typesList'))
    </div>
    @foreach($typesList as $typeKey => $type)
    <h5 class="mb-3 mt-1">{{ $type['label'] }}</h5>
    <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
        <thead>
            <tr>
                @foreach($type['columns'] as $columnKey => $column)
                    {{--<th class="border-bottom-0 w-10">Дата</th>--}}
                    <th class="border-bottom-0">{{ $column['attribute'] }}</th>
                    {{--<th class="border-bottom-0">Расходы</th>--}}
                @endforeach
                <th class="border-bottom-0">Действия</th>
            </tr>
        </thead>
        <tbody>
            @if($type['values']->count() > 0)
                @foreach($type['values'] as $valueIndex => $salaryDataItem)
                    <tr>
                        @foreach($type['columns'] as $columnKey => $column)
                            @if($columnKey === UserSalaryDataContract::FIELD_CUSTOM_DATA)
                                <td>
                                    {{ $salaryDataItem->customDataPreview }}
                                </td>
                            @else
                            <td>{{ $salaryDataItem->$columnKey }}</td>
                            @endif
                        @endforeach
                        <td>
                            -
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="{{ count($type['columns']) + 1 }}">Данных нет</td>
                </tr>
            @endif
        </tbody>
    </table>
    @endforeach
</div>
