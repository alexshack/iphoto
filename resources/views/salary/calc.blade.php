@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">#2520 от 24.06.2023<a href="{{url('salary/calcs')}}" class="font-weight-normal text-muted ml-2">Начисления</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные начисления</h4>
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
												<label class="form-label  col-md-3">Вид начисления</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите вид начисления">
														<option label="Выберите вид начисления"></option>
														<!-- Виды начислений с типом Ввод вручную-->
														<option value="1">Премия</option>
														<option value="2">Штраф</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Город</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
														<option label="Выберите город"></option>
														<option value="1">Белгород</option>
														<option value="2">Воронеж</option>
														<option value="3">Краснодар</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Точка</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
														<option label="Выберите точку"></option>
														<!-- Точки с фильтром по городу, выбранному выше-->
														<option value="1">Аквапарк</option>
														<option value="2">Зоопарк</option>
														<option value="3">Сити-Молл</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label  col-md-3">Сотрудник</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" data-placeholder="Выберите сотрудника">
														<option label="Выберите сотрудника"></option>
														<!-- Сотрудники с фильтром по городу, выбранному выше и полю выбранного вида начисления Должности, участвующие в расчете-->
														<option value="1">Иванов Иван</option>
														<option value="2">Сидоренко Георгий</option>
														<option value="3">Сергеев Сергей</option>
													</select>
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
													<input type="text" class="form-control" placeholder="Укажите примечания к начислению" value="">
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

		<script src="{{URL::asset('assets/js/select2.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/calc.js')}}"></script>

@endsection
