<!--Смены создаются автоматически каждый день в 2 часа по местному времени на каждую точку. Вручную создать возможности нет -->
@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Смены<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="mr-3">
										<div class="input-group mr-3">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<span class="feather feather-clock"></span>
												</div>
											</div>
                                            <!--Фильтр для записей. Период - месяц-->
                                            <form id="filterForm" action="">
                                                <input name="filter" onchange="document.getElementById('filterForm').submit()" placeholder="Выберите период" value="{{ (request()->query('filter')) ? request()->query('filter') : \App\Helpers\Helper::getMonthName(date('n')) .' ' . date('Y') }}" class="form-control" id="datepicker-month" type="text">
                                            </form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Смены за период: <span>{{ $period }}</span></h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="days">
												<thead>
													<tr>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Точка</th>
														<th class="border-bottom-0">Сотрудники</th>
														<th class="border-bottom-0">Касса</th>
														<th class="border-bottom-0">Расходы</th>
														<th class="border-bottom-0">Зарплата</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @foreach($workshifts as $workshift)
													<tr>
                                                        <td data-order="{{ $workshift->date }}">{{ $workshift->date->format('d.m.Y') }}</td>
                                                        <td data-order="{{ $workshift->is_closed ? 1 : 0 }}" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
                                                            <a href="/money/days/{{ $workshift->id }}" class="badge {{ $workshift->is_closed ? 'bg-success-transparent' : 'bg-primary-transparent' }}">
                                                                {{ $workshift->is_closed ? 'Закрыта' : 'Открыта' }}
                                                            </a><!-- bg-success-transparent - если закрыта, bg-primary-transparent - если открыта -->
														</td>
                                                        <td data-order="{{ $workshift->city ? $workshift->city->name : '' }}">
                                                            <a href="{{ Helper::getEntityEditRoute($workshift->city) }}">
                                                                {{ $workshift->city ? $workshift->city->name : '' }}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $workshift->place ? $workshift->place->name : '' }}">
                                                            <a href="{{ Helper::getEntityEditRoute($workshift->place) }}">
                                                                {{ $workshift->place ? $workshift->place->name : '' }}
                                                            </a>
                                                        </td>
                                                        <td class="text-center" data-search="{{ $workshift->employeesNames }}"><!-- Имя фамилия всех через запятую -->
															<div class="avatar-list avatar-list-stacked">
                                                                @foreach($workshift->employees as $employee)
                                                                    <a href="{{url('structure/employees/' . $employee->user_id)}}" title="Сотрудник Сотрудников">
                                                                        <img class="avatar avatar-sm brround" src="{{URL::asset($employee->user->photo)}}" alt="img">
																</a>
                                                                @endforeach
															</div>
														</td>
                                                        <td data-order="{{ $workshift->total_sales }}" class="text-right">
                                                            {{ $workshift->total_sales }}₽
                                                        </td>
                                                        <td data-order="{{ $workshift->expenses }}" class="text-right">
                                                            {{ $workshift->expenses }}₽
                                                        </td>
                                                        <td data-order="{{ $workshift->salary }}" class="text-right">
                                                            {{ $workshift->salary }}₽
                                                        </td>
														<td>
															<!-- кнопка редактирования показывается:
															1. У админа всегда
															2. У сотрудников только если следующая по дате смена в этой же точке имеет статус "Открыта",
															в остальных случаях показывается кнопка посмотреть -->
                                                            <a class="btn btn-primary btn-icon btn-sm"  href="{{url('money/days/' . $workshift->id)}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
                                                    @endforeach

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')


@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/days.js')}}"></script>

@endsection
