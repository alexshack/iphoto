@php
    use App\Contracts\Goods\GoodsCategoryContract;
@endphp
<div class="table-responsive">
    <table class="table table-vcenter text-nowrap table-bordered border-bottom">
        <thead>
            <tr>
                <th>№</th>
                <th>{{ GoodsCategoryContract::ATTRIBUTES[GoodsCategoryContract::FIELD_NAME] }}</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->{GoodsCategoryContract::FIELD_ID} }}</td>
                <td>{{ $category->{GoodsCategoryContract::FIELD_NAME} }}</td>
                <td>
                    <a class="btn btn-default btn-sm" href="{{ route('admin.goods.categories.edit', ['id' => $category->{GoodsCategoryContract::FIELD_ID}]) }}">
                        <span class="feather feather-edit"></span>
                    </a>
                    <button wire:loading.attr="disabled" class="btn btn-danger btn-sm" wire:click="destroyCategory({{ $category->{GoodsCategoryContract::FIELD_ID} }})">
                        <span class="feather feather-trash"></span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>
