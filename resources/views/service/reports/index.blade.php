@extends('layouts.app')

@php
    use App\Contracts\Service\ReportContract;
@endphp

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Отчеты</h4>
        </div>
        <div class="page-right-header">
            <a class="btn btn-primary" href="{{ route('reports.create') }}">Создать отчет</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-title">Список отчетов</div>
                </div>
                <div class="card-body">
                    <div class="table-responsibe">
                        <table class="table table-bordered border-bottom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Тип</th>
                                    <th>Готов</th>
                                    <th>Создатель</th>
                                    <th>Дата создания/завершения генерации</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($reports->total() > 0)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>
                                                {{ $report->{ReportContract::FIELD_ID} }}
                                            </td>
                                            <td>{{ $report->typeName }}</td>
                                            <td>
                                                @if($report->{ ReportContract::FIELD_COMPLETED_AT })
                                                    <span class="text-success feather feather-check"></span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $report->user ? $report->user->name : '' }}
                                            </td>
                                            <td>
                                                {{ $report->created_at }}
                                                @if($report->{ ReportContract::FIELD_COMPLETED_AT })
                                                    / {{ $report->{ ReportContract::FIELD_COMPLETED_AT } }}
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-default" href="{{ route('reports.show', ['report' => $report->{ ReportContract::FIELD_ID }]) }}">
                                                    <span class="feather feather-eye"></span>
                                                </a>
                                                @if($report->{ ReportContract::FIELD_COMPLETED_AT })
                                                    <a class="btn btn-sm btn-default" href="{{ $report->url }}" target="blank">
                                                        <span class="span feather feather-download"></span>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Нет данных</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
