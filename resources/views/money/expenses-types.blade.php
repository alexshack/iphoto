@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">		

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Виды расходов<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href=""  data-target="#expense-type-crud" data-toggle="modal" class="btn btn-primary mr-3">Добавить вид расходов</a>
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
										<h4 class="card-title">Виды расходов</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expenses-types">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Право создания</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Аренда</td>
														<td>Менеджер</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="" data-target="#expense-type-crud" data-toggle="modal">
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Такси</td>
														<td>Менеджер, Сотрудник</td>
														<td><span class="badge badge-danger">Не активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="" data-target="#expense-type-crud" data-toggle="modal">
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

			<div class="modal fade"  id="expense-type-crud">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Вид поступлений</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Название</label>
								<input type="text" class="form-control" placeholder="Введите название">
							</div>
							<div class="form-group">
								<label class="form-label">Право создания расхода</label>
								<select multiple="multiple" class="select1">
									<!--Список задается жестко, value проставь сам, как удобнее - ID роли пользователя -->
								   <option selected value="122">Менеджер</option>
								   <option selected value="135">Сотрудник</option>
								</select>
							</div>							
							<div class="form-group">
								<label class="form-label">Статус</label>
								<select class="form-control custom-select select2">
									<!--Список задается жестко -->
								   <option selected value="1">Активен</option>
								   <option value="0">Не активен</option>
								</select>
							</div>							
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<a href="#" class="btn btn-primary">Сохранить</a>
						</div>
					</div>
				</div>
			</div>


@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/expenses-types.js')}}"></script>

@endsection
