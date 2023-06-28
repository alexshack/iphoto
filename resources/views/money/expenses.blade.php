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
								<h4 class="page-title">Расходы ДС<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
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
									<div class="btn-list">
										<a href="{{url('money/expenses/add')}}"  class="btn btn-primary mr-3">Добавить расход</a>
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
										<h4 class="card-title">Расходы за период</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expenses">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Вид расхода</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Плательщик</th>
														<th class="border-bottom-0">Сумма</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>2520</td>
														<td data-order="<?php strtotime('24.06.2023') ?>">24.05.2023</td>
														<td>Такси</td>
														<td data-order="Белгород"><a href="/structure/cities/0">Белгород</a></td>
														<td data-order="Аквапарк"><a href="/structure/places/0">Аквапарк</a></td>
														<td data-order="750" class="text-right">750₽</td>
														<td>
															<!-- кнопки редактирования и удаления показываются только если дата поступления в текущем месяце -->
														</td>
													</tr>
													<tr>
														<td>2521</td>
														<td data-order="<?php strtotime('24.06.2023') ?>">24.05.2023</td>
														<td>Аренда</td>
														<td data-order="Белгород"><a href="/structure/cities/0">Белгород</a></td>
														<td data-order="Иванов Иван"><a href="/structure/managers/0">Менеджеров Менеджер</a></td>
														<td data-order="40000" class="text-right">40 000₽</td>
														<td>
															<!-- кнопки редактирования и удаления показываются только если вид начисления вручную, не автоматический. И если еще не было закрытия месяца (выдача зп за месяц) -->
														</td>
													</tr>
													<tr>
														<td>2522</td>
														<td data-order="<?php strtotime('24.06.2023') ?>">24.06.2023</td>
														<td>Такси</td>
														<td data-order="Белгород"><a href="/structure/cities/0">Белгород</a></td>
														<td data-order="Аквапарк"><a href="/structure/places/0">Аквапарк</a></td>
														<td data-order="1000" class="text-right">1 000₽</td>
														<td>
															<!-- кнопки редактирования и удаления показываются только если вид начисления вручную, не автоматический. И если еще не было закрытия месяца (выдача зп за месяц) -->
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('money/expenses/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
															<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить">
																<i class="feather feather-trash-2"></i>
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
		<script src="{{URL::asset('assets/js/money/expenses.js')}}"></script>

@endsection