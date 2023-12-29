<div>
    <div class="form-group">
        <label class="form-label">Название</label>
        <input type="text" wire:model.defer="category.{{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_NAME }}" class="form-control" placeholder="Название категории">
    </div>
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
            Необходимо заполнить поля:
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    @endif
    <button class="btn btn-success" wire:click.prevent="submit" wire:loading.attr="disabled">
       Обновить
    </button>
</div>
