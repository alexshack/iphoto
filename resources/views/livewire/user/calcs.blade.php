<div class="card">
    <div class="card-body">

    <table class="table  table-vcenter text-nowrap table-bordered border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Дата</th>
                <th class="border-bottom-0">Вид начисления</th>
                <th class="border-bottom-0">Город</th>
                <th class="border-bottom-0">Точка</th>
                <th class="border-bottom-0">Сотрудник</th>
                <th class="border-bottom-0">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calcs as $calc)
                <tr>
                    <td>{{ $calc->id }}</td>
                    <td data-order="<?php strtotime('24.06.2023') ?>">
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
                    <td data-order="{{ $calc->user ? $calc->user->getFullName() : '' }}">
                        <a href="{{ route('admin.structure.employees.edit', ['id' => $calc->user_id]) }}">
                            {{ $calc->user ? $calc->user->getFullName() : '' }}
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
