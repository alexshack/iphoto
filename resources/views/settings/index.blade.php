@extends('layouts.app')

@php
    use App\Contracts\SettingContract;
@endphp

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Настройки</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-title">Настройки</div>
                </div>
                <div class="card-body">
                    @if($settings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered border-bottom">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Имя</th>
                                        <th class="border-bottom-0">Значение</th>
                                        <th class="border-bottom-0">Ссылка</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($settings as $setting)
                                        <tr>
                                            <td>{{ $setting->{SettingContract::FIELD_NAME} }}</td>
                                            <td>{{ $setting->valuePreview }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('settings.edit', ['setting' => $setting->{SettingContract::FIELD_ID}]) }}">
                                                    <span class="feather feather-edit"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
