@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Виды начислений<span class="font-weight-normal text-muted ml-2">Учет зарплаты</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href="{{url('salary/calcs-types/add')}}"  class="btn btn-primary mr-3">Добавить вид начисления</a>
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
										<h4 class="card-title">Виды начислений</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="calcs-types">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Тип начисления</th>
														<th class="border-bottom-0">Тип фильтра</th>
														<th class="border-bottom-0">Фильтр</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Проценты 17/13</td>
														<td>Процент от кассы</td>
														<td>Должность</td>
														<td>Фотограф, Ретушер, Сотрудник</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Проценты фотографы 3</td>
														<td>Процент от кассы</td>
														<td>Должность</td>
														<td>Фотограф</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Рамки 3 процента</td>
														<td>Процент от от товара</td>
														<td>Товар</td>
														<td>Рамка</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Оклад общий</td>
														<td>Оклад</td>
														<td>Статус</td>
														<td>Стажер, Сотрудник</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Ассортимент</td>
														<td>Фиксированная смена</td>
														<td>Должность</td>
														<td>Ассортимент</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Премия</td>
														<td>Ввод вручную</td>
														<td>Должность</td>
														<td>Ассортимент, Фотограф, Ретушер, Сотрудник</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="{{url('salary/calcs-types/0')}}" >
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
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

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/calcs-types.js')}}"></script>

@endsection
