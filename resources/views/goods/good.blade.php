@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Фото А4<a href="{{url('goods')}}" class="font-weight-normal text-muted ml-2">Товары</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные товара</h4>
									</div>
									<div class="card-body">
										<form class="form-horizontal">
											<div class="form-group row">
												<label class="form-label  col-md-3">Категория</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите категорию товара">
														<option label="Выберите категорию товара"></option>
														<option value="1">Принтеры</option>
														<option value="2">Расходники</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label col-md-3">Наименование</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="" value="">
												</div>
											</div>

											<div class="card-pay">
												<div class="row">
													<label class="form-label col-md-3">Выберите тип товара</label>
													<ul class="tabs-menu nav col-md-9">
														<!-- Задаются жестко -->
														<li class=""><a href="#tab-1" class="active" data-toggle="tab">Продажа</a></li>
														<li><a href="#tab-2" data-toggle="tab" class="">Индивидуальная продажа</a></li>
														<li><a href="#tab-3" data-toggle="tab" class="">ТМЦ</a></li>
														<li><a href="#tab-4" data-toggle="tab" class="">Расходные материалы</a></li>
														<li><a href="#tab-5" data-toggle="tab" class="">Отработка</a></li>
													</ul>
												</div>
												<div class="tab-content">
													<div class="tab-pane active show" id="tab-1">

													</div>
													<div class="tab-pane show" id="tab-2">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Сумма премии</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" placeholder="" value="">
																</div>
															</div>															
															<div class="form-group row">
																<div class="form-label col-md-3">Больше одного человека</div>
																<label class="custom-switch col-md-9">
																	<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
																	<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
																	<span class="custom-switch-description">Да</span>
																</label>
															</div>
														</div>
													</div>
													<div class="tab-pane show" id="tab-3">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Серийный номер</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" placeholder="Укажите серийный номер ТМЦ" value="">
																</div>
															</div>															
															<div class="form-group row">
																<div class="form-label col-md-3">Вводить показания в смене</div>
																<label class="custom-switch col-md-9">
																	<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
																	<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
																	<span class="custom-switch-description">Да</span>
																</label>
															</div>
															<div class="form-group row">
																<div class="form-label col-md-3">Точка <a href="" data-target="#place-edit" data-toggle="modal" class="badge badge-primary">Добавить</a></div>
																<div class="col-md-9">
																	<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
																		<thead>
																			<tr>
																				<th class="border-bottom-0 w-10">Дата</th>
																				<th class="border-bottom-0">Город</th>
																				<th class="border-bottom-0">Точка</th>
																				<th class="border-bottom-0">Действия</th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td>05.05.2017</td>
																				<td>Белгород</td>
																				<td>Аквапарк</td>
																				<td>
																					<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#place-edit" data-toggle="modal">
																						<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																					</a>
																					<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
																				</td>															
																			</tr>
																			<tr>
																				<td>05.05.2020</td>
																				<td>Белгород</td>
																				<td>Зоопарк</td>
																				<td>
																					<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#place-edit" data-toggle="modal">
																						<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																					</a>
																					<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
																				</td>															
																			</tr>																											
																		</tbody>
																	</table>
																</div>
															</div>															
														</div>
													</div>
													<div class="tab-pane active show" id="tab-4">

													</div>
													<div class="tab-pane active show" id="tab-5">

													</div>																																						
												</div>
											</div>											

											<div class="form-group row">
												<label class="form-label col-md-3">Примечания</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Укажите примечания" value="">
												</div>
											</div>

											<!-- Алерт отображается удалением класса d-none -->
											<div class="alert alert-danger d-none" role="alert">
												<button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
												Необходимо заполнить поля:
											</div>																																	
											<button class="btn btn-lg btn-primary" type="submit">Сохранить</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')

			<!--Change place Modal -->
			<div class="modal fade"  id="place-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Точка</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Дата</label>
								<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Город</label>
								<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
									<option label="Выберите город"></option>
									<option value="1">Белгород</option>
									<option value="2">Воронеж</option>
									<option value="3">Краснодар</option>
								</select>								
							</div>
							<div class="form-group">
								<label class="form-label">Точка</label>
								<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
									<option label="Выберите город"></option>
									<option value="1">Аквапарк</option>
									<option value="2">Зоопарк</option>
									<option value="3">Сити-Молл</option>
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
			<!-- End Change place Modal  -->

@endsection('modals')

@section('scripts')


		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/goods/good.js')}}"></script>

@endsection
