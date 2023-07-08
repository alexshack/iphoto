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
											<input class="form-control" id="datepicker-month" placeholder="Выберите период" value="Июнь 2023" type="text">
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
										<h4 class="card-title">Смены за период: <span>Июнь 2023</span></h4>
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
													<tr>
														<td data-order="<?php strtotime('24.06.2023') ?>">24.05.2023</td>
														<td data-order="1" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
															<a href="money/days/0" class="badge bg-success-transparent">Закрыта</a><!-- bg-success-transparent - если закрыта, bg-primary-transparent - если открыта -->
														</td>														
														<td data-order="Белгород"><a href="/structure/cities/0">Белгород</a></td>
														<td data-order="Аквапарк"><a href="/structure/places/0">Аквапарк</a></td>
														<td class="text-center" data-search="Сотрудник Сотрудников, Сотрудник Сотрудников"><!-- Имя фамилия всех через запятую -->
															<div class="avatar-list avatar-list-stacked">
																<!-- сотрудники в смене -->
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																</a>
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																</a>
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																</a>
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/5.jpg')}}" alt="img">
																</a>
															</div>
														</td>																												
														<td data-order="12000" class="text-right">12 000₽</td>
														<td data-order="500" class="text-right">500₽</td>
														<td data-order="2000" class="text-right">2 000₽</td>
														<td>
															<!-- кнопка редактирования показывается:
															1. У админа всегда
															2. У сотрудников только если следующая по дате смена в этой же точке имеет статус "Открыта",
															в остальных случаях показывается кнопка посмотреть -->
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('money/days/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td data-order="<?php strtotime('24.06.2023') ?>">24.05.2023</td>
														<td data-order="0" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
															<a href="money/days/0" class="badge bg-primary-transparent">Открыта</a><!-- bg-success-transparent - если закрыта, bg-primary-transparent - если открыта -->
														</td>														
														<td data-order="Белгород"><a href="/structure/cities/0">Белгород</a></td>
														<td data-order="Зоопарк"><a href="/structure/places/0">Зоопарк</a></td>
														<td class="text-center" data-search="Сотрудник Сотрудников, Сотрудник Сотрудников"><!-- Имя фамилия всех через запятую -->
															<div class="avatar-list avatar-list-stacked">
																<!-- сотрудники в смене -->
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																</a>
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																</a>
																<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																	<img class="avatar avatar-sm brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																</a>
															</div>
														</td>																												
														<td data-order="15000" class="text-right">15 000₽</td>
														<td data-order="400" class="text-right">400₽</td>
														<td data-order="2500" class="text-right">2 500₽</td>
														<td>															
															<!-- кнопка редактирования показывается:
															1. У админа всегда
															2. У сотрудников только если следующая по дате смена в этой же точке имеет статус "Открыта",
															в остальных случаях показывается кнопка посмотреть -->
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('money/days/0')}}" >
																<i class="feather feather-eye" data-toggle="tooltip" data-original-title="Посмотреть"></i>
															</a>
														</td>
													</tr>
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
