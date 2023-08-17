@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Выплаты<span class="font-weight-normal text-muted ml-2">Учет зарплаты</span></h4>
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
                                            <form id="filterForm" action="">
                                                <input name="filter" onchange="document.getElementById('filterForm').submit()" placeholder="Выберите период" value="{{ (request()->query('filter')) ? request()->query('filter') : \App\Helpers\Helper::getMonthName(date('n')) .' ' . date('Y') }}" class="form-control" id="datepicker-month" type="text">
                                            </form>
                                            <!--Фильтр для записей по полю Расчетный месяц. Период - месяц-->
										</div>
									</div>
									<div class="btn-list">
										<a href="{{ route('admin.salary.pay.create') }}" class="btn btn-primary mr-3">Добавить выплату</a>
										<!--Кнопки списков доступны только менеджеру-->
										<a href="" data-target="#pays-list-oklad" data-toggle="modal" class="btn btn-primary mr-3">Список на оклад</a>
										<a href="" data-target="#pays-list-zp" data-toggle="modal" class="btn btn-primary mr-3">Список на зарплату</a>
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
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="pays">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Вид выплаты</th>
														<th class="border-bottom-0">Расчетный месяц</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Источник</th>
														<th class="border-bottom-0">Сотрудник</th>
														<th class="border-bottom-0">Сумма</th>
														<th class="border-bottom-0">Выдано</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @foreach($pays as $pay)
													<tr>
                                                        <td>{{ $pay->id }}</td>
														<td data-order="<?php strtotime('05.07.2023') ?>">
                                                            <a href="/money/days/0">
                                                                05.07.2023
                                                            </a>
                                                        </td><!-- ссылка на смену ставится, только если Вид выплаты = Аванс и Источник = Точка  -->
														<td>
                                                            {{ $pay->calcType ? $pay->calcType->name : '' }}
                                                        </td><!-- Всего три типа: Аванс, Оклад, Зарплата -->
                                                        <td data-order="{{ $pay->billing_month }}">
                                                            {{ $pay->billingMonthHuman }}
                                                        </td>
                                                        <td data-order="{{ $pay->city ? $pay->city->name : '' }}">
                                                            <a href="{{ Helper::getEntityEditRoute($pay->city) }}">
                                                                {{ $pay->city ? $pay->city->name : '' }}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $pay->source ? $pay->source->name : '' }}">
                                                            <a href="{{ Helper::getEntityEditRoute($pay->source) }}">
                                                                {{ $pay->source ? $pay->source->name : '' }}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $pay->user ? $pay->user->name : '' }}">
                                                            <a href="{{ Helper::getEntityEditRoute($pay->user) }}">
                                                                {{ $pay->user->name }}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $pay->amount }}" class="text-right">
                                                            {{ $pay->amount }}₽
                                                        </td>
                                                        <td data-order="{{ $pay->issued ? 'Да' : 'Нет' }}" class="text-center">
                                                            @if($pay->issued)
                                                                <i class="feather feather-check text-success"></i>
                                                            @endif
                                                        </td>
														<td>
															<!-- кнопки редактирования и удаления показываются только если Выплата.Выдано = Нет -->
														</td>
													</tr>
                                                    @endforeach
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

			<!--Oklad Modal -->
			<!--Автоматически заполняются списком всех сотрудников по условиям:
					Сотрудник.Город = Менеджер.Город и Сотрудник.ДатаУвольнения < #datepicker-month.ПоследнееЧислоМесяца
				Сумма по сотруднику заполняется из суммы всех начислений по условиям:
					Начисление.Сотрудник = Сотрудник и Начисление.УчаствуетВвыплатеОклада = Да и Начисление.Дата(месяц) = #datepicker-month
			-->
			<div class="modal fade"  id="pays-list-oklad">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Выдача оклада за Июнь 2023</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="pays-oklad">
									<thead>
										<tr>
											<th class="border-bottom-0">Сотрудник</th>
											<th class="border-bottom-0">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<a href="#" class="btn btn-primary">Создать выплаты</a>
						</div>
					</div>
				</div>
			</div>
			<!-- При сохранении создаются выплаты на каждого сотрудника из таблицы #pays-oklad с заполнением полей:
				Выплата.Дата = Сегодня
				Выплата.ВидВыплаты = Оклад
				Выплата.РасчетныйМесяц = #datepicker-month
				Выплата.Город = Менеджер.Город
				Выплата.Источник = Менеджер
				Выплата.Сотрудник = #pays-oklad.Сотрудник
				Выплата.Сумма = #pays-oklad.Сумма
				Выплата.Выдано = Нет
			 -->
			<!-- End Oklad Modal  -->


			<!--ZP Modal -->
			<!--Автоматически заполняются списком всех сотрудников по условиям:
					Сотрудник.Город = Менеджер.Город и Сотрудник.ДатаУвольнения < #datepicker-month.ПоследнееЧислоМесяца
				Сумма по сотруднику заполняется по формуле (c - p + b), где :
				c = Сумма всех начислений по условиям:
					Начисление.Сотрудник = Сотрудник и Начисление.Дата(месяц) = #datepicker-month
				p = Сумма всех выплат по условиям:
					Выплата.Сотрудник = Сотрудник и Выплата.Дата(месяц) = #datepicker-month и Выплата.Выдано = Да
				b = Сотрудник.Баланс
			-->
			<div class="modal fade"  id="pays-list-zp">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Выдача зарплаты за Июнь 2023</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="pays-zp">
									<thead>
										<tr>
											<th class="border-bottom-0">Сотрудник</th>
											<th class="border-bottom-0">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
										<tr>
											<td>Иванов Иван</td>
											<td data-order="5750" class="text-right">5 750₽</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<a href="#" class="btn btn-primary">Создать выплаты</a>
						</div>
					</div>
				</div>
			</div>
			<!-- При сохранении создаются выплаты на каждого сотрудника из таблицы #pays-zp с заполнением полей:
				Выплата.Дата = Сегодня
				Выплата.ВидВыплаты = Зарплата
				Выплата.РасчетныйМесяц = #datepicker-month
				Выплата.Город = Менеджер.Город
				Выплата.Источник = Менеджер
				Выплата.Сотрудник = #pays-zp.Сотрудник
				Выплата.Сумма = #pays-zp.Сумма
				Выплата.Выдано = Нет
			 -->
			<!-- ZP Oklad Modal  -->
@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/pays.js')}}"></script>

@endsection
