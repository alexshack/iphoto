<div class="card">
    @php
        use App\Contracts\Salary\PaysContract;
    @endphp
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Списки</h4>
        <div class="card-actions">
            @if($isInProcess && $isEmptyLists)
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
        @if(!$isEmptyLists)
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#salary10">
                        Список на зп
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#salary25">
                        Список на оклад
                    </a>
                </li>
            </ul>
        </nav>
        <div class="tab-content">
            <div class="tab-pane fade active show" role="tabpanel" aria-labeledby="tab">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Сотрудник</th>
                                <th class="border-bottom-0">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salary10'] as $payItem)
                                <tr>
                                    <td>{{ $payItem->user->name }}</td>
                                    <td>{{ $payItem->{ PaysContract::FIELD_AMOUNT } }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data['salary10']->links() }}
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" aria-labeledby="tab">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Сотрудник</th>
                                <th class="border-bottom-0">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salary25'] as $payItem)
                                <tr>
                                    <td>{{ $payItem->user->name }}</td>
                                    <td>{{ $payItem->{ PaysContract::FIELD_AMOUNT } }}</td>
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
</div>
