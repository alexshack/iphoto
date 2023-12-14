@extends('layouts.app')

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">
                Выплаты
                <span class="font-weight-normal text-muted ml-2">Списки на оклад и зп</span>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @livewire('salary.pay.lists')
        </div>
    </div>
@endsection
