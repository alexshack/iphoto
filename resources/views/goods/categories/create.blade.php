@extends('layouts.app')

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">
                Товары
                <span class="font-weight-normal text-muted ml-2">Добавить категорию</span>
            </h4>
        </div>
        <div class="page-rightheader ml-md-auto">
            <div class="btn-list">
                <a href="{{ route('admin.goods.categories.index') }}" class="btn btn-primary mr-3">
                    Категории
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="card-title">Добавить категорию</div>
                </div>
                <div class="card-body">
                    @livewire('goods-category.create')
                </div>
            </div>
        </div>
    </div>
@endsection
