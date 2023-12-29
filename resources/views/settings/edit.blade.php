@extends('layouts.app')

@php
    use App\Contracts\SettingContract;
@endphp

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Настройки
                <span class="font-weight-normal text-muted ml-2">
                    {{ $setting->{SettingContract::FIELD_NAME} }}
                </span>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            @livewire('setting.edit', compact('setting'))
        </div>
    </div>
@endsection
