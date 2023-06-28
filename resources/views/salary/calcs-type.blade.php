@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Проценты 17/13<a href="{{url('salary/calcs-types')}}" class="font-weight-normal text-muted ml-2">Виды начислений</a></h4>
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
										<form class="form-horizontal">
											<div class="form-group row">
												<label class="form-label col-md-3">Название</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Введите название" value="Проценты 17/13">
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Статус</label>
												<div class="col-md-9">
													<select class="form-control custom-select select2">
														<!--Список задается жестко -->
													   <option selected value="1">Активен</option>
													   <option value="0">Не активен</option>
													</select>
												</div>
											</div>											
											<div class="card-pay">
												<div class="row">
													<label class="form-label col-md-3">Выберите тип начисления</label>
													<ul class="tabs-menu nav col-md-9">
														<!--Отдельное поле в таблице Тип начислений - у каждого типа - одно из пяти жестких значений. У каждого сохраняется свой набор значений полей -->
														<li class=""><a href="#tab-1" class="active" data-toggle="tab">Процент от кассы</a></li>
														<li><a href="#tab-3" data-toggle="tab" class="">Оклад</a></li>
														<li><a href="#tab-4" data-toggle="tab" class="">Фиксированная смена</a></li>
														<li><a href="#tab-5" data-toggle="tab" class="">Ввод вручную</a></li>
													</ul>
												</div>
												<div class="tab-content">
													<div class="tab-pane active show" id="tab-1">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Участвует в автоматическом расчете</label>
																<div class="col-md-9">
																	<!-- зашивается жестко у каждого типа начисления -->
																	<input type="text" class="form-control" readonly value="ДА">
																</div>
															</div>																
															<div class="form-group row">
																<label class="form-label col-md-3">Должности, участвующие в расчете</label>
																<div class="col-md-9">
																	<select multiple="multiple" class="select-position">
																		<!--Список из таблицы Должности сотрудников -->
																	   <option selected value="122">Фотограф</option>
																	   <option selected value="135">Ретушер</option>
																	   <option value="150">Продавец</option>
																	</select>
																</div>
															</div>															
															<div class="form-group row">
																<label class="form-label col-md-3">Процент, если один сотрудник</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" placeholder="Введите значение процента" value="13">
																</div>
															</div>
															<div class="form-group row">
																<label class="form-label col-md-3">Процент, если больше одного сотрудника</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" placeholder="Введите значение процента"  value="17">
																</div>
															</div>															

															
														</div>
													</div>
													<div class="tab-pane show" id="tab-3">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Участвует в автоматическом расчете</label>
																<div class="col-md-9">
																	<!-- зашивается жестко у каждого типа начисления -->
																	<input type="text" class="form-control" readonly value="ДА">
																</div>
															</div>																
															<div class="form-group row">
																<label class="form-label col-md-3">Статусы, участвующие в расчете</label>
																<div class="col-md-9">
																	<select multiple="multiple" class="select-position">
																		<!--Список из таблицы Статусы сотрудников -->
																	   <option selected value="122">Стажер</option>
																	   <option value="135">Сотрудник</option>
																	</select>
																</div>
															</div>															
															<div class="form-group row">
																<label class="form-label col-md-3">Процент от оклада</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" placeholder="Введите значение процента" value="100">
																</div>
															</div>														
														</div>
													</div>
													<div class="tab-pane show" id="tab-4">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Участвует в автоматическом расчете</label>
																<div class="col-md-9">
																	<!-- зашивается жестко у каждого типа начисления -->
																	<input type="text" class="form-control" readonly value="ДА">
																</div>
															</div>																
															<div class="form-group row">
																<label class="form-label col-md-3">Должности, участвующие в расчете</label>
																<div class="col-md-9">
																	<select multiple="multiple" class="select-position">
																		<!--Список из таблицы Должности сотрудников -->
																	   <option value="122">Фотограф</option>
																	   <option value="135">Ретушер</option>
																	   <option value="150">Продавец</option>
																	   <option selected value="155">Ассортимент</option>
																	</select>
																</div>
															</div>															
															<div class="form-group row">
																<label class="form-label col-md-3">Количество часов за смену</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" placeholder="Введите значение часов" value="8">
																</div>
															</div>														
														</div>
													</div>
													<div class="tab-pane show" id="tab-5">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Участвует в автоматическом расчете</label>
																<div class="col-md-9">
																	<!-- зашивается жестко у каждого типа начисления -->
																	<input type="text" class="form-control" readonly value="НЕТ">
																</div>
															</div>																
															<div class="form-group row">
																<label class="form-label col-md-3">Должности, участвующие в расчете</label>
																<div class="col-md-9">
																	<select multiple="multiple" class="select-position">
																		<!--Список из таблицы Должности сотрудников -->
																	   <option selected value="122">Фотограф</option>
																	   <option selected value="135">Ретушер</option>
																	   <option selected value="150">Продавец</option>
																	   <option selected value="155">Ассортимент</option>
																	</select>
																</div>
															</div>															
														</div>
													</div>																										
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-md-3">Участвует в выплате оклада</div>
												<label class="custom-switch col-md-9">
													<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
													<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
													<span class="custom-switch-description">Да</span>
												</label>
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

		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/calcs-type.js')}}"></script>

@endsection
