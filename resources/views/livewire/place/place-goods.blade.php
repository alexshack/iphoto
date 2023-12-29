<div class="card">
    <div class="card-header">
        <h4 class="card-title">ТМЦ точки</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table goods-table table-vcenter text-nowrap table-bordered border-bottom">
                <thead>
                    <tr>
                        <th class="border-bottom-0">Наименование</th>
                        <th class="border-bottom-0">Серийный номер</th>
                        <th class="border-bottom-0">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($goods))
                        @foreach($goods as $good)
                            <tr>
                                <td>{{ $good->{ \App\Contracts\Goods\GoodsContract::FIELD_NAME } }}</td>
                                <td>{{ $good->{ \App\Contracts\Goods\GoodsContract::FIELD_SERIAL_NUMBER } }}</td>
                                <td>
                                    <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.goods.edit', ['id' => $good->{ \App\Contracts\Goods\GoodsContract::FIELD_ID }]) }}" >
                                        <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $goods->links() }}
        </div>

    </div>
</div>

