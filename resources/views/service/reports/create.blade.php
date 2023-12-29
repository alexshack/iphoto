@extends('layouts.app')

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">
                Добавить отчет
                <a class="font-weight-normal text-muted ml-2" href="{{ route('reports.index') }}">Отчеты</a>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @livewire('service.report.create')
        </div>
    </div>
@endsection
