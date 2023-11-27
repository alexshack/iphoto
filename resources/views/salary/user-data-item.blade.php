@extends('layouts.app')

@section('content')
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">
                {{ $salaryData->user->getFullName() }}
                <span class="font-weight-normal text-muted ml-2">Редактирование расчета</span>
            </h4>
        </div>
        <div class="page-rightheader ml-md-auto">
            <div class="btn-list">
                <a href="{{ route('admin.structure.employees.edit', ['id' => $salaryData->user_id]) }}" class="btn btn-primary mr-3">К пользователю</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="card-title">Редактирование расчета</div>
                </div>
                <div class="card-body">
                    @livewire('user.salary-data.edit', compact('salaryData'))
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
@endsection
