@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ isset($type) ? $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } : '' }}<a href="{{ route('admin.salary.calc_type.index') }}" class="font-weight-normal text-muted ml-2">Виды начислений</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Настройки начисления</h4>
									</div>
									<div class="card-body">
                                        @if(session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif
                                        @if(Route::currentRouteName() == 'admin.salary.calc_type.edit')
                                        <form class="form-horizontal" action="{{ route('admin.salary.calc_type.update', ['id' => $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_ID }]) }}" method="post">
                                        @else
                                        <form class="form-horizontal" action="{{ route('admin.salary.calc_type.store') }}" method="post">
                                        @endif
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="form-group row">
												<label class="form-label col-md-3">Название</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="name" placeholder="Введите название" value="{{ $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } ?? old(\App\Contracts\Salary\CalcsTypeContract::FIELD_NAME) }}">
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Статус</label>
												<div class="col-md-9">
													<select name="status" class="form-control custom-select select2">
														@foreach(\App\Contracts\Salary\CalcsTypeContract::STATUS_LIST as $key => $status)
                                                            <option value="{{ $key }}" {{ (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_STATUS } == $key) ? 'selected' : '' }}>{{ $status }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="card-pay">
												<div class="row">
													<label class="form-label col-md-3">Выберите тип начисления</label>
													<ul class="tabs-menu nav col-md-9">
														<!--Отдельное поле в таблице Тип начислений - у каждого типа - одно из пяти жестких значений. У каждого сохраняется свой набор значений полей -->
														@if( (!isset($type)) || (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 1) )
                                                            <li class=""><a href="?type=1" class="{{ ( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 1) || (request()->query('type') == 1) || (!isset($type) && request()->query('type') < 1) ) ? 'active' : '' }}">Процент от кассы</a></li>
                                                        @endif
                                                        @if( (!isset($type)) || (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 2) )
                                                            <li><a href="?type=2" class="{{ ( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 2)  || (request()->query('type') == 2) ) ? 'active' : '' }}">Продажа товара</a></li>
                                                        @endif
                                                        @if( (!isset($type)) || (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 3) )
                                                            <li><a href="?type=3" class="{{ ( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 3)  || (request()->query('type') == 3) ) ? 'active' : '' }}">Оклад</a></li>
                                                        @endif
                                                        @if( (!isset($type)) || (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 4) )
                                                            <li><a href="?type=4" class="{{ ( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 4)  || (request()->query('type') == 4) ) ? 'active' : '' }}">Фиксированная смена</a></li>
                                                        @endif
                                                        @if( (!isset($type)) || (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 5) )
                                                            <li><a href="?type=5" class="{{ ( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 5)  || (request()->query('type') == 5) ) ? 'active' : '' }}">Ввод вручную</a></li>
                                                        @endif
													</ul>
												</div>
												<div class="tab-content">
                                                    @if( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 1) || (request()->query('type') == 1) || (!isset($type) && request()->query('type') < 1) )
                                                        <div class="tab-pane show active" id="tab-1">
                                                            <input type="hidden" name="type" value="1">
                                                            <input type="hidden" name="automatic_calculation" value="1">
                                                            <div class="form-horizontal">
                                                                <div class="form-group row">
                                                                    <label class="form-label col-md-3">Участвует в автоматическом расчете</label>
                                                                    <div class="col-md-9">
                                                                        <!-- зашивается жестко у каждого типа начисления -->
                                                                        <select id="automatic_calculation" class="form-control" readonly="" disabled>
                                                                            <option value="1" selected>Да</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="form-label col-md-3">Должности, участвующие в расчете</label>
                                                                    <div class="col-md-9">
                                                                        <select name="custom_data[positions][]" multiple="multiple" class="select-position">
                                                                            <!--Список из таблицы Должности сотрудников -->
                                                                            @foreach($positions as $item)
                                                                                <option value="{{ $item->{ \App\Contracts\PositionContract::FIELD_ID } }}" {{ ($item->{ \App\Contracts\PositionContract::FIELD_STATUS } == 2) ? 'disabled' : '' }}  {{ (isset($type) && in_array($item->{ \App\Contracts\PositionContract::FIELD_ID }, $type->getCustom()->positions)) ? 'selected' : '' }}>{{ $item->{ \App\Contracts\PositionContract::FIELD_NAME } }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="form-label col-md-3">Процент, если один сотрудник</label>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="custom_data[percent_for_one]" class="form-control" placeholder="Введите значение процента" value="{{ (isset($type) ? $type->getCustom()->percent_for_one : old('custom_data.percent_for_one')) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="form-label col-md-3">Процент, если больше одного сотрудника</label>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="custom_data[percent_for_multiple]" class="form-control" placeholder="Введите значение процента"  value="{{ (isset($type) ? $type->getCustom()->percent_for_multiple : old('custom_data.percent_for_multiple')) }}">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    @endif
													@if( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 2)  || (request()->query('type') == 2) )
                                                            <div class="tab-pane show active" id="tab-2">
                                                                <input type="hidden" name="type" value="2">
                                                                <input type="hidden" name="automatic_calculation" value="1">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Участвует в автоматическом расчете</label>
                                                                        <div class="col-md-9">
                                                                            <!-- зашивается жестко у каждого типа начисления -->
                                                                            <select id="automatic_calculation" class="form-control" readonly="" disabled>
                                                                                <option value="1" selected>Да</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
													@endif
                                                    @if( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 3)  || (request()->query('type') == 3) )
                                                            <div class="tab-pane show active" id="tab-3">
                                                                <input type="hidden" name="type" value="3">
                                                                <input type="hidden" name="automatic_calculation" value="1">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Участвует в автоматическом расчете</label>
                                                                        <div class="col-md-9">
                                                                            <!-- зашивается жестко у каждого типа начисления -->
                                                                            <select id="automatic_calculation" class="form-control" readonly="" disabled>
                                                                                <option value="1" selected>Да</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Статусы, участвующие в расчете</label>
                                                                        <div class="col-md-9">
                                                                            <select name="custom_data[employee_statuses][]" multiple="multiple" class="select-position">
                                                                                <!--Список из таблицы Статусы сотрудников -->
                                                                                @foreach($statuses as $item)
                                                                                    <option value="{{ $item->{ \App\Contracts\Salary\EmployeeStatusContract::FIELD_ID } }}" {{ ($item->{ \App\Contracts\Salary\EmployeeStatusContract::FIELD_STATUS } == 2) ? 'disabled' : '' }} {{ (isset($type) && in_array($item->{ \App\Contracts\Salary\EmployeeStatusContract::FIELD_ID }, $type->getCustom()->employee_statuses)) ? 'selected' : '' }}>{{ $item->{ \App\Contracts\Salary\EmployeeStatusContract::FIELD_NAME } }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Процент от оклада</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" name="custom_data[salary_percent]" class="form-control" placeholder="Введите значение процента" value="{{ (isset($type) ? $type->getCustom()->salary_percent : old('custom_data.salary_percent')) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif
                                                    @if( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 4)  || (request()->query('type') == 4) )
                                                            <div class="tab-pane show active" id="tab-4">
                                                                <input type="hidden" name="type" value="4">
                                                                <input type="hidden" name="automatic_calculation" value="1">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Участвует в автоматическом расчете</label>
                                                                        <div class="col-md-9">
                                                                            <!-- зашивается жестко у каждого типа начисления -->
                                                                            <select id="automatic_calculation" class="form-control" readonly="" disabled>
                                                                                <option value="1" selected>Да</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Должности, участвующие в расчете</label>
                                                                        <div class="col-md-9">
                                                                            <select name="custom_data[positions][]" multiple="multiple" class="select-position">
                                                                                <!--Список из таблицы Должности сотрудников -->
                                                                                @foreach($positions as $item)
                                                                                    <option value="{{ $item->{ \App\Contracts\PositionContract::FIELD_ID } }}" {{ ($item->{ \App\Contracts\PositionContract::FIELD_STATUS } == 2) ? 'disabled' : '' }} {{ (isset($type) && in_array($item->{ \App\Contracts\PositionContract::FIELD_ID }, $type->getCustom()->positions)) ? 'selected' : '' }}>{{ $item->{ \App\Contracts\PositionContract::FIELD_NAME } }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Количество часов за смену</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" name="custom_data[hours_count]" class="form-control" placeholder="Введите значение часов" value="{{ (isset($type) ? $type->getCustom()->hours_count : old('custom_data.hours_count')) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif
                                                    @if( (isset($type) && $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_TYPE } == 5)  || (request()->query('type') == 5) )
                                                            <div class="tab-pane show active" id="tab-5">
                                                                <input type="hidden" name="type" value="5">
                                                                <input type="hidden" name="automatic_calculation" value="">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Участвует в автоматическом расчете</label>
                                                                        <div class="col-md-9">
                                                                            <!-- зашивается жестко у каждого типа начисления -->
                                                                            <select id="automatic_calculation" class="form-control" readonly="" disabled>
                                                                                <option value="" selected>Нет</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="form-label col-md-3">Должности, участвующие в расчете</label>
                                                                        <div class="col-md-9">
                                                                            <select name="custom_data[positions][]" multiple="multiple" class="select-position">
                                                                                <!--Список из таблицы Должности сотрудников -->
                                                                                @foreach($positions as $item)
                                                                                    <option value="{{ $item->{ \App\Contracts\PositionContract::FIELD_ID } }}" {{ ($item->{ \App\Contracts\PositionContract::FIELD_STATUS } == 2) ? 'disabled' : '' }} {{ (isset($type) && in_array($item->{ \App\Contracts\PositionContract::FIELD_ID }, $type->getCustom()->positions)) ? 'selected' : '' }}>{{ $item->{ \App\Contracts\PositionContract::FIELD_NAME } }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-md-3">Участвует в выплате оклада</div>
												<label class="custom-switch col-md-9">
													<input type="checkbox" name="salary_payment" class="custom-switch-input" {{ (isset($type) && (!empty($type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_SALARY_PAYMENT })) ) ? 'checked="checked"' : '' }}>
													<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
													<span class="custom-switch-description">Да</span>
												</label>
											</div>

                                            @if ($errors->any())
                                                <div class="alert alert-danger" role="alert">
                                                    <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li><i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

											<button class="btn btn-lg btn-primary" type="submit">Сохранить</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')


@endsection('modals')

@section('scripts')

		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/calcs-type.js')}}"></script>

@endsection
