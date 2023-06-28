@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">			

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('money/incomes')}}" class="font-weight-normal text-muted ml-2">Поступления ДС</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные поступления</h4>
									</div>
									<div class="card-body">
										<form class="form-horizontal">
											<div class="form-group row">
												<label class="form-label col-md-3">Дата</label>
												<div class="col-md-9">
													<input type="text" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="">
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Вид поступления</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите вид поступления">
														<option label="Выберите вид начисления"></option>
														<!-- incomes-types where incomes-types.status = active -->
														<option value="1">Перевод от собственников</option>
														<option value="2">Другое</option>
													</select>
												</div>
											</div>											
											<div class="form-group row">
												<label class="form-label  col-md-3">Город</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
														<option label="Выберите город"></option>
														<!-- Если Админ, то все города. Если Менеджер, только Менеджер.Город-->
														<option value="1">Белгород</option>
														<option value="2">Воронеж</option>
														<option value="3">Краснодар</option>
													</select>
												</div>
											</div>

											<div class="card-pay">
												<div class="row">
													<label class="form-label col-md-3">Выберите тип получателя</label>
													<ul class="tabs-menu nav col-md-9">
														<li class=""><a href="#tab-1" class="active" data-toggle="tab">Точка</a></li>
														<li><a href="#tab-2" data-toggle="tab" class="">Менеджер</a></li>
													</ul>
												</div>
												<div class="tab-content">
													<div class="tab-pane active show" id="tab-1">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label  col-md-3">Точка</label>
																<div class="col-md-9">
																	<select class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
																		<option label="Выберите точку"></option>
																		<!-- Если Админ, то точки с фильтром по городу, выбранному выше. Если менеджер, то все точки с Точка.Город = Менджер.Город -->
																		<option value="1">Аквапарк</option>
																		<option value="2">Зоопарк</option>
																		<option value="3">Сити-Молл</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="tab-pane show" id="tab-2">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label  col-md-3">Менеджер</label>
																<div class="col-md-9">
																	<select class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
																		<option label="Выберите менеджера"></option>
																		<!-- Если Админ, то менеджер с фильтром по городу, выбранному выше. Если менеджер, то только он -->
																		<option value="1">Менеджер 1</option>
																		<option value="2">Менеджер 2</option>
																		<option value="3">Менеджер 3</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>											
											<div class="form-group row">
												<label class="form-label col-md-3">Сумма</label>
												<div class="col-md-9">
													<input type="number" class="form-control" placeholder="Введите сумму" value="">
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label col-md-3">Примечания</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Укажите примечания к поступлению" value="">
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


@endsection('modals')

@section('scripts')


		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/income.js')}}"></script>

@endsection
