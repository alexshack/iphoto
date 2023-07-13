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
								<h4 class="page-title">Товары<span class="font-weight-normal text-muted ml-2">Товарный учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
			
									<div class="btn-list">
										<a href="" data-target="#category-add" data-toggle="modal" class="btn btn-primary mr-3">Добавить категорию</a>
										<a href="{{url('goods/add')}}"  class="btn btn-primary mr-3">Добавить товар</a>
									</div>
								</div>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card" id="tabs-style4">
									<div class="card-header border-bottom-0">
										<div class="card-title">
											Товары
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
												<div class="panel panel-primary tabs-style-4">
													<div class="tab-menu-heading border-0">
														<div class="tabs-menu ">
															<!-- Tabs -->
															<ul class="nav panel-tabs flex-column">
																<li class=""><a href="#tab21" class="active" data-toggle="tab">Фотографии</a></li>
																<li><a href="#tab22" data-toggle="tab">Принтеры</a></li>
																<li><a href="#tab23" data-toggle="tab">Категория 3</a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<div class="tabs-style-4 col-md-9">
												<div class="panel-body ">
													<div class="tab-content">
														<div class="tab-pane active" id="tab21">
															<div class="table-responsive">
																<table class="table goods-table table-vcenter text-nowrap table-bordered border-bottom">
																	<thead>
																		<tr>
																			<th class="border-bottom-0">Вид товара</th>
																			<th class="border-bottom-0">Наименование</th>
																			<th class="border-bottom-0">Серийный номер</th>
																			<th class="border-bottom-0">Действия</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>Продажа</td>
																			<td>Фото А4</td>
																			<td></td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
																					<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>Продажа</td>
																			<td>Фото А6</td>
																			<td></td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
																					<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																				</a>
																			</td>
																		</tr>																		
																	</tbody>
																</table>
															</div>
														</div>
														<div class="tab-pane" id="tab22">
															<div class="table-responsive">
																<table class="table goods-table table-vcenter text-nowrap table-bordered border-bottom">
																	<thead>
																		<tr>
																			<th class="border-bottom-0">Вид товара</th>
																			<th class="border-bottom-0">Наименование</th>
																			<th class="border-bottom-0">Серийный номер</th>
																			<th class="border-bottom-0">Действия</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>ТМЦ</td>
																			<td>Принтер Samsung</td>
																			<td>W7YK170208</td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
																					<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>ТМЦ</td>
																			<td>Принтер Samsung</td>
																			<td>W7YK087770</td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
																					<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																				</a>
																			</td>
																		</tr>																		
																	</tbody>
																</table>
															</div>
														</div>
														<div class="tab-pane" id="tab23">
															<div class="table-responsive">
																<table class="table goods-table table-vcenter text-nowrap table-bordered border-bottom">
																	<thead>
																		<tr>
																			<th class="border-bottom-0">Вид товара</th>
																			<th class="border-bottom-0">Наименование</th>
																			<th class="border-bottom-0">Серийный номер</th>
																			<th class="border-bottom-0">Действия</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>ТМЦ</td>
																			<td>Принтер Samsung</td>
																			<td>W7YK170208</td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
																					<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>ТМЦ</td>
																			<td>Принтер Samsung</td>
																			<td>W7YK087770</td>
																			<td>
																				<a class="btn btn-primary btn-icon btn-sm"  href="{{url('goods/0')}}" >
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
										</div>
									</div>
								</div>								
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')

			<!--add category Modal -->
			<div class="modal fade"  id="category-add">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Категория</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Название</label>
								<input type="text" class="form-control" placeholder="Название категории">
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<a href="#" class="btn btn-primary">Сохранить</a>
						</div>
					</div>
				</div>
			</div>
			<!-- End category Modal  -->

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
		<script src="{{URL::asset('assets/js/goods/goods.js')}}"></script>

@endsection
