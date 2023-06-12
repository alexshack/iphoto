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
								<h4 class="page-title">Виды продаж<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href=""  data-target="#sale-type-crud" data-toggle="modal" class="btn btn-primary mr-3">Добавить вид продажи</a>
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
										<h4 class="card-title">Виды продаж</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="sales-types">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Получатель</th>
														<th class="border-bottom-0">Доп. расходы</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Наличные</td>
														<td>Точка</td>
														<td>0%</td>
														<td><span class="badge badge-success">Активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="" data-target="#sale-type-crud" data-toggle="modal">
																<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
															</a>
														</td>
													</tr>
													<tr>
														<td>Безналичные</td>
														<td>Бухгалтерия</td>
														<td>0.8%</td>
														<td><span class="badge badge-danger">Не активен</span></td>
														<td>
															<a class="btn btn-primary btn-icon btn-sm"  href="" data-target="#sale-type-crud" data-toggle="modal">
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

			<!--Change salary Modal -->
			<div class="modal fade"  id="sale-type-crud">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Вид продажи</h5>
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
								<label class="form-label">Получатель</label>
								<select class="form-control custom-select select2">
									<!--Список задается жестко -->
								   <option selected value="0">Точка</option>
								   <option value="1">Менеджер</option>
								   <option value="2">Бухгалтерия</option>
								</select>
							</div>								
							<div class="form-group">
								<label class="form-label">Дополнительные расходы, % (для статистики)</label>
								<input type="number" class="form-control" placeholder="Значение процента" value="">
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
			<!-- End Change salary Modal  -->

@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/sales-types.js')}}"></script>

@endsection
