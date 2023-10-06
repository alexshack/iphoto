@extends('layouts.app')
	<!-- На этой странице все CRUD-ы доступны, только если у смены статус ОТКРЫТА -->


@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL File Uploads css-->
        <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />

		<!-- INTERNAL Time picker css -->
		<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')
    <div id="workshift">
        <WorkShift/>
    </div>

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Смена 24.06.2023 - Белгород - Аквапарк  <a href="{{url('money/days')}}" class="font-weight-normal text-muted ml-2">Смены</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row">
							<div class="col-xl-3 col-md-12 col-lg-12">
								<div class="offer offer-success"><!--offer-danger если закрыта, offer-success если открыта-->
									<div class="card-header  border-0">
										<div class="card-title text text-success">Смена открыта</span> </div><!--text-danger если закрыта, text-success если открыта-->
									</div>
									<div class="card-body pt-2 pl-3 pr-3">
										<div class="table-responsive">
											<table class="table paddings-small">
												<tbody>
													<tr>
														<td>
															<span class="w-50">Снятие кассы</span>
														</td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">5 500₽</h4>
														</td>
													</tr>
													<tr>
														<td>
															<span class="w-50">Продажи, в том числе:</span>
														</td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">5 500₽</h4>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Общие продажи</span></td>
														<td>
															<div class="font-weight-semibold text-right">3 500₽</div>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Индивидуальные продажи</span></td>
														<td>
															<div class="font-weight-semibold text-right">2 000₽</div>
														</td>
													</tr>
													<tr>
														<td>
															<span class="w-50">Касса, в том числе:</span></td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">5 500₽</h4>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Наличные</span></td>
														<td>
															<div class="font-weight-semibold text-right">3 500₽</div>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Терминал</span></td>
														<td>
															<div class="font-weight-semibold text-right">2 000₽</div>
														</td>
													</tr>
													<tr>
														<td>
															<span class="w-50">Расходы из кассы, в том числе:</span>
														</td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">900₽</h4>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Расходы</span></td>
														<td>
															<div class="font-weight-semibold text-right">300₽</div>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Перемещения</span></td>
														<td>
															<div class="font-weight-semibold text-right">300₽</div>
														</td>
													</tr>
													<tr>
														<td><span class="w-50 pl-3">Выдача авансов</span></td>
														<td>
															<div class="font-weight-semibold text-right">300₽</div>
														</td>
													</tr>
													<tr>
														<td class="py-5">
															<span class="w-50 font-weight-semibold">Остаток наличных</span>
														</td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">2 600₽</h4>
														</td>
													</tr>
													<tr>
														<td>
															<span class="w-50">Начисленная зарплата</span>
														</td>
														<td>
															<h4 class="font-weight-semibold text-right mb-0">1 300₽</h4>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="py-3">
											<a href="#" class="btn btn-success btn-block font-weight-semibold" >ЗАКРЫТЬ СМЕНУ</a><!-- если смена открыта, видят только сотрудники и админ -->
											<a href="#" class="btn btn-danger btn-block font-weight-semibold" >ОТМЕНИТЬ ЗАКРЫТИЕ</a><!-- если смена закрыта, при этом следующая смена этой точки не закрыта. видят сотрудники и админ -->
										</div>
										<!-- Алерт отображается удалением класса d-none -->
										<div class="alert alert-danger" role="alert">
											<i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
											<span class="font-weight-semibold">Невозможно закрыть смену:</span>
											<div>Не совпадают суммы продаж и кассы</div>
											<div>Не заполнены суммы снятия кассы</div>
											<div>Не заполнены данные по оборудованию</div>
										</div>


									</div>
								</div>

							</div>
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="tab-menu-heading p-0 ">
									<div class="tabs-menu1">
										<!-- Tabs -->
										<ul class="nav panel-tabs">
											<li><a href="#tab1" data-toggle="tab" class="active">Смена</a></li>
											<li><a href="#tab2" data-toggle="tab">Продажи</a></li>
											<li><a href="#tab3" data-toggle="tab">Расходы из кассы</a></li>
											<li><a href="#tab4" data-toggle="tab">Итоговая касса</a></li>
											<li><a href="#tab5" data-toggle="tab">Учет оборудования</a></li>
											<li><a href="#tab6" data-toggle="tab">Расходники</a></li>
											<li><a href="#tab7" data-toggle="tab">Начисления ЗП</a></li><!-- Отображается только если статус смены Закрыт -->
										</ul>
									</div>
								</div>
								<div class="panel-body tabs-menu-body hremp-tabs1 p-0">
									<div class="tab-content">
										<div class="tab-pane active" id="tab1">
											<div class="card-header  border-0">
												<h4 class="card-title">Сотрудники</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#employee">Добавить сотрудника</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="employees">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Сотрудник</th>
																<th class="border-bottom-0">Приход</th>
																<th class="border-bottom-0">Уход</th>
																<th class="border-bottom-0">Время</th>
																<th class="border-bottom-0">Статус</th>
																<th class="border-bottom-0">Роль</th>
																<th class="border-bottom-0">Зарплата</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td data-order="Сидоров Сергей">
																	<div class="d-flex">
																		<span class="avatar avatar brround mr-3" style="background-image: url({{URL::asset('assets/images/users/1.jpg')}})"></span>
																		<div class="mr-3 mt-0 mt-sm-2 d-block">
																			<h6 class="mb-1 fs-14">Сидоров Сергей</h6>
																		</div>
																	</div>
																</td>
																<td data-order="<?php strtotime('24.06.2023 09:30') ?>">09:30</td>
																<td data-order="<?php strtotime('24.06.2023 12:00') ?>">12:00</td>
																<td data-order="150">02:30</td>
																<td>Ученик</td>
																<td>Фотограф</td>
																<td data-order="1627">1 627₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1" data-toggle="modal" data-target="#employee"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
															<tr>
																<td data-order="Сидоров Сергей">
																	<div class="d-flex">
																		<span class="avatar avatar brround mr-3" style="background-image: url({{URL::asset('assets/images/users/1.jpg')}})"></span>
																		<div class="mr-3 mt-0 mt-sm-2 d-block">
																			<h6 class="mb-1 fs-14">Сидоров Сергей</h6>
																		</div>
																	</div>
																</td>
																<td data-order="<?php strtotime('24.06.2023 09:30') ?>">09:30</td>
																<td data-order="<?php strtotime('24.06.2023 12:00') ?>">12:00</td>
																<td data-order="150">02:30</td>
																<td>Ученик</td>
																<td>Фотограф</td>
																<td data-order="1627">1 627₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1" data-toggle="modal" data-target="#employee"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="card-header  border-0">
												<h4 class="card-title">Снятие кассы</h4>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="times">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Время</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td data-order="<?php strtotime('24.06.2023 09:30') ?>">09:30</td>
																<td data-order="1627">1 627₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1" data-toggle="modal" data-target="#time"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																	</div>
																</td>
															</tr>
															<tr>
																<td data-order="<?php strtotime('24.06.2023 12:00') ?>">12:00</td>
																<td data-order="5300">5 300₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Изменить"  data-toggle="modal" data-target="#time"><i class="feather feather-edit-2  text-success"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab2">
											<div class="card-header  border-0">
												<h4 class="card-title">Общие продажи</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#all-good">Добавить товар</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="all-goods">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Товар</th>
																<th class="border-bottom-0">Цена</th>
																<th class="border-bottom-0">Количество</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Фото А4</td>
																<td data-order="200" class="text-right">200₽</td>
																<td class="text-right">20</td>
																<td data-order="4000" class="text-right  text-bold">4 000₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#all-good"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
															<tr>
																<td>Фото А4</td>
																<td data-order="200" class="text-right">500₽</td>
																<td class="text-right">10</td>
																<td data-order="4000" class="text-right  text-bold">5 000₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#all-good"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="card-header  border-0">
												<h4 class="card-title">Индивидуальные продажи</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#person-good">Добавить товар</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="person-goods">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Товар</th>
																<th class="border-bottom-0 text-center">Продавец</th>
																<th class="border-bottom-0">Цена</th>
																<th class="border-bottom-0">Количество</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Фоторамка</td>
																<td>Иванов Сергей</td>
																<td data-order="200" class="text-right">200₽</td>
																<td class="text-right">20</td>
																<td data-order="4000" class="text-right text-bold">4 000₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#person-good"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
															<tr>
																<td>Фотосессия</td>
																<td>Сергеев Иван, Иванов Сергей</td>
																<td data-order="200" class="text-right">500₽</td>
																<td class="text-right">10</td>
																<td data-order="4000" class="text-right  text-bold">5 000₽</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#person-good"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab3">
											<div class="card-header  border-0">
												<h4 class="card-title">Расходы</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#expence">Добавить расход</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expences">
														<thead>
															<tr>
																<th class="border-bottom-0">Расход</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Примечания</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Такси</td>
																<td data-order="500" class="text-right">500₽</td>
																<td>Такси Ситимолл-Зоопарк утро</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#expence"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="card-header  border-0">
												<h4 class="card-title">Перемещения денег</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#move">Добавить перемещение</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="moves">
														<thead>
															<tr>
																<th class="border-bottom-0">Получатель</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Примечания</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Менеджеров Менеджер</td>
																<td data-order="500" class="text-right">500₽</td>
																<td>Выручка</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#move"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="card-header  border-0">
												<h4 class="card-title">Выдача авансов</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#pay">Добавить аванс</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="pays">
														<thead>
															<tr>
																<th class="border-bottom-0">Получатель</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Примечания</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Сотрудников Сотрудник</td>
																<td data-order="5000" class="text-right">5 000₽</td>
																<td>По согласованию</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#pay"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab4">
											<div class="card-header  border-0">
												<h4 class="card-title">Данные кассы</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#sale">Добавить кассу</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="sales">
														<thead>
															<tr>
																<th class="border-bottom-0">Вид продажи</th>
																<th class="border-bottom-0">Сумма</th>
																<th class="border-bottom-0">Примечания</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Наличные</td>
																<td data-order="5000" class="text-right">5 000₽</td>
																<td></td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#sale"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab5">
											<div class="card-header  border-0">
												<h4 class="card-title">Оборудование</h4>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="devices">
														<thead>
															<tr>
																<th class="border-bottom-0">Оборудование</th>
																<th class="border-bottom-0">Серийный номер</th>
																<th class="border-bottom-0">Начало</th>
																<th class="border-bottom-0">Конец</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<!-- Заполняется автоматически всеми товарами, при Товар.Тип = ТМЦ И Товар.Вводить показания в смене = ДА, которые на дату смены привязаны к точке-->
															<tr>
																<td>Принтер Samsung</td>
																<td>W7YK170208</td>
																<td>3500</td>
																<td>3890</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#device"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab6">
											<div class="card-header  border-0">
												<h4 class="card-title">Отработка</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#lose">Добавить отработку</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="loses">
														<thead>
															<tr>
																<th class="border-bottom-0">Товар</th>
																<th class="border-bottom-0">Количество</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Фото А4</td>
																<td>15</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#lose"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="card-header  border-0">
												<h4 class="card-title">Расходные материалы</h4>
												<div class="card-options">
									                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#trash">Добавить расходник</a>
									            </div>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="trashes">
														<thead>
															<tr>
																<th class="border-bottom-0">Товар</th>
																<th class="border-bottom-0">Остаток</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Ножницы</td>
																<td>2</td>
																<td>
																	<div class="d-flex">
																		<a href="#" class="action-btns1"  data-toggle="modal" data-target="#trash"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
																		<a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="tab7">
											<div class="card-header  border-0">
												<h4 class="card-title">Начисления ЗП по смене</h4>
											</div>
											<div class="card-body pt-1">
												<div class="table-responsive">
													<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="calcs">
														<thead>
															<tr>
																<th class="border-bottom-0">Сотрудник</th>
																<th class="border-bottom-0">Вид начисления</th>
																<th class="border-bottom-0">Сумма</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Сергеев Иван</td>
																<td>Оклад</td>
																<td data-order="5000" class="text-right">5 000₽</td>
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
						<!-- End Row-->
						<!-- End Row-->

@endsection('content')

@section('modals')

			<div class="modal fade"  id="employee">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Сотрудник</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label class="form-label">Сотрудник:</label>
										<select name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите сотрудника">
											<option label="Выберите сотрудника"></option>
											<!-- Сотрудники текущего города -->
											<option value="1">Иванов Иван</option>
											<option value="2">Семенов Семен</option>
											<option value="3">Иванов Иван</option>
											<option value="4">Иванов Иван</option>
											<option value="5">Иванов Иван</option>
											<option value="6">Иванов Иван</option>
											<option value="7">Иванов Иван</option>
											<option value="8">Иванов Иван</option>
											<option value="9">Иванов Иван</option>
											<option value="10">Иванов Иван</option>
										</select>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Статус:</label>
										<select name="" class="form-control custom-select select2"  data-placeholder="Выберите статус">
											<option label="Выберите статус"></option>
											<option value="1">Стажер</option>
											<option value="2">Сотрудник</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Должность на смене:</label>
										<select name=""  class="form-control custom-select select2" data-placeholder="Выберите должность">
											<option label="Выберите должность"></option>
											<option value="1">Фотограф</option>
											<option value="2">Продавец</option>
											<option value="3">Ретушер</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Время прихода:</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<span class="feather feather-clock"></span>
												</div>
											</div><!-- input-group-prepend -->
											<input class="form-control ui-timepicker-input" id="tpStartTime" placeholder="Укажите время" type="text" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Время ухода:</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<span class="feather feather-clock"></span>
												</div>
											</div><!-- input-group-prepend -->
											<input class="form-control ui-timepicker-input" id="tpEndTime" placeholder="Укажите время" type="text" autocomplete="off">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="time">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Снятие кассы</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Время снятия:</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<span class="feather feather-clock"></span>
												</div>
											</div><!-- input-group-prepend -->
											<input class="form-control ui-timepicker-input" id="tpTimeTime" placeholder="Укажите время" type="text" autocomplete="off" value="12:30" disabled>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Сумма:</label>
										<input class="form-control" placeholder="Укажите сумму" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="all-good">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Продажа</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Товар</label>
										<select name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите товар">
											<option label="Выберите товар"></option>
											<!-- Товар с типом Продажа -->
											<option value="1">Фото А4</option>
											<option value="2">Фото А6</option>
											<option value="3">Фоторамка</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Количество:</label>
										<input class="form-control" placeholder="Укажите количество" type="number">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Цена:</label>
										<input class="form-control" placeholder="Укажите цену" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="person-good">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Индивидуальная продажа</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Товар</label>
										<select name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите товар">
											<option label="Выберите товар"></option>
											<!-- Товар с типом Индивидуальная продажа -->
											<option value="1">Фото А4</option>
											<option value="2">Фото А6</option>
											<option value="3">Фоторамка</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сотрудник</label>
										<!-- вариант селекта, если у выбранного товара опция Больше одного человека = НЕТ. В списке Сотрудники, указанные в Сотрудниках смены -->
										<select name=""  class="form-control custom-select select2-show-search " data-placeholder="Выберите сотрудника" >
											<option label="Выберите сотрудника"></option>
											<option value="1">Иванов Сергей</option>
											<option value="2">Сергеев Иван</option>
											<option value="3">Сотрудников Сотрудник</option>
										</select>
										<!-- вариант селекта, если у выбранного товара опция Больше одного человека = ДА. В списке Сотрудники, указанные в Сотрудниках смены -->
										<select name=""  class="form-control select-good-person" data-placeholder="Выберите сотрудника" multiple="multiple" >
											<option value="1">Иванов Сергей</option>
											<option value="2">Сергеев Иван</option>
											<option value="3">Сотрудников Сотрудник</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Количество:</label>
										<input class="form-control" placeholder="Укажите количество" type="number">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Цена:</label>
										<input class="form-control" placeholder="Укажите цену" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="expence">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Расход</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Вид расхода</label>
										<select name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите вид расхода">
											<option label="Выберите вид расхода"></option>
											<!-- виды расходов, с правом создания Сотрудник и статусом Активен -->
											<option value="1">Такси</option>
											<option value="2">Ресторан</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сумма</label>
										<input class="form-control" placeholder="Укажите сумму расхода" type="number">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-label">Чек</div>
										<input type="file" class="dropify" data-default-file="{{URL::asset('assets/images/photos/media1.jpg')}}" data-height="180"  />
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Примечания:</label>
										<input class="form-control" placeholder="Укажите примечания" type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="move">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Перемещение</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="card-pay">

								<label class="form-label">Выберите тип получателя</label>
								<ul class="tabs-menu nav">
									<li class="w-50"><a href="#move-tab-1" class="active" data-toggle="tab">Точка</a></li>
									<li class="w-50"><a href="#move-tab-2" data-toggle="tab" class="">Менеджер</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div class="tab-pane active show" id="move-tab-1">
									<div class="form-group">
										<label class="form-label  col-md-3">Точка</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
											<option label="Выберите точку"></option>
											<!--все точки с Точка.Город = Смена.Точка.Город -->
											<option value="1">Аквапарк</option>
											<option value="2">Зоопарк</option>
											<option value="3">Сити-Молл</option>
										</select>
									</div>

								</div>
								<div class="tab-pane show" id="move-tab-2">
									<div class="form-group">
										<label class="form-label">Менеджер</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
											<option label="Выберите менеджера"></option>
											<!-- Все менеджеры -->
											<option value="1">Менеджер 1</option>
											<option value="2">Менеджер 2</option>
											<option value="3">Менеджер 3</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сумма</label>
										<input class="form-control" placeholder="Укажите сумму перемещения" type="number">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Примечания:</label>
										<input class="form-control" placeholder="Укажите примечания" type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="pay">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Аванс</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сотрудник</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите сотрудника">
											<option label="Выберите сотрудника"></option>
											<!-- Все менеджеры -->
											<option value="1">Сотрудник 1</option>
											<option value="2">Сотрудник 2</option>
											<option value="3">Сотрудник 3</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Расчетный месяц</label>
										<input class="form-control" id="datepicker-month" placeholder="Выберите месяц" value="Июнь 2023" type="text">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сумма</label>
										<input class="form-control" placeholder="Укажите сумму аванса" type="number">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Примечания:</label>
										<input class="form-control" placeholder="Укажите примечания" type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="sale">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Касса</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Вид продажи</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите вид продажи">
											<option label="Выберите вид продажи"></option>
											<!-- Виды продаж, Статус = Активен -->
											<option value="1">Наличные</option>
											<option value="2">Терминал</option>
											<option value="3">СБП</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Сумма</label>
										<input class="form-control" placeholder="Укажите сумму" type="number">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Примечания:</label>
										<input class="form-control" placeholder="Укажите примечания" type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="device">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Оборудование</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Оборудование</label>
										<input class="form-control" value="Принтер Samsung, W7YK170208" type="text" disabled><!-- Наименование товара, серийный номер -->
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">На начало смены</label>
										<input class="form-control" placeholder="Укажите показания" type="number">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">На конец смены</label>
										<input class="form-control" placeholder="Укажите показания" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="lose">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Отработка</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Товар</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите отработку">
											<option label="Выберите отработку"></option>
											<!-- Товар при Товар.Тип = Отработка -->
											<option value="1">Фото А4</option>
											<option value="2">Фото А6</option>
											<option value="3">Фото А3</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Количество</label>
										<input class="form-control" placeholder="Укажите количество" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="trash">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Расходник</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Товар</label>
										<select class="form-control select2-show-search custom-select" data-placeholder="Выберите расходник">
											<option label="Выберите расходник"></option>
											<!-- Товар при Товар.Тип = Расходные материалы -->
											<option value="1">Фото А4</option>
											<option value="2">Фото А6</option>
											<option value="3">Фото А3</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Количество</label>
										<input class="form-control" placeholder="Укажите количество" type="number">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
							<button  class="btn btn-success" onclick="not1()">Сохранить</button>
						</div>
					</div>
				</div>
			</div>

@endsection('modals')

@section('scripts')
		<!-- INTERNAL Data tables -->
		{{--<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>--}}


		<!-- INTERNAL File uploads js -->
        <script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>

		<!-- INTERNAL Timepicker js -->
		<script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/day.js')}}"></script>

        <script>
            window.agenda = @js($agenda);
            window.workshiftData = JSON.parse('{!! json_encode($workshift) !!}');
            {{--window.workshiftData = @js($workshift);--}}
            window.workshiftTitle = '{{ $workshift->title }}';
            window.workshiftUrls = {
                update: '{{ route("money.days.update", ["id" => $workshift->id]) }}',
                employee: {
                    all: '{{ route("workshift.employee.index") }}',
                    delete: '{{ route("workshift.employee.destroy", ["employee" => "%s"]) }}',
                    positions: '{{ route("workshift.employee.position") }}',
                    show: '{{ route("workshift.employee.show", ["employee" => "%s"]) }}',
                    statuses: '{{ route("workshift.employee.status") }}',
                    store: '{{ route("workshift.employee.store") }}',
                    update: '{{ route("workshift.employee.update", ["employee" => "%s"]) }}',
                },
                expenses: {
                    all: '{{ route("workshift.expense.index") }}',
                    delete: '{{ route("workshift.expense.destroy", ["expense" => "%s"]) }}',
                    show: '{{ route("workshift.expense.show", ["expense" => "%s"]) }}',
                    store: '{{ route("workshift.expense.store") }}',
                    update: '{{ route("workshift.expense.update", ["expense" => "%s"]) }}',
                },
                expenseTypes: '{{ route("workshift.expenseTypes") }}',
                fcds: {
                    all: '{{ route("workshift.fcd.index") }}',
                    delete: '{{ route("workshift.fcd.destroy", ["fcd" => "%s"]) }}',
                    show: '{{ route("workshift.fcd.show", ["fcd" => "%s"]) }}',
                    store: '{{ route("workshift.fcd.store") }}',
                    update: '{{ route("workshift.fcd.update", ["fcd" => "%s"]) }}',
                },
                goods: {
                    all: '{{ route("workshift.goods.index") }}',
                    show: '{{ route("workshift.goods.show", ["good" => "%s"]) }}',
                    store: '{{ route("workshift.goods.store") }}',
                    update: '{{ route("workshift.goods.update", ["good" => "%s"]) }}',
                    delete: '{{ route("workshift.goods.destroy", ["good" => "%s"]) }}',
                },
                goodsList: '{{ route("workshift.goods_list") }}',
                moves: {
                    all: '{{ route("workshift.move.index") }}',
                    delete: '{{ route("workshift.move.destroy", ["move" => "%s"]) }}',
                    show: '{{ route("workshift.move.show", ["move" => "%s"]) }}',
                    store: '{{ route("workshift.move.store") }}',
                    update: '{{ route("workshift.move.update", ["move" => "%s"]) }}',
                },
                pays: {
                    all: '{{ route("workshift.pay.index") }}',
                    delete: '{{ route("workshift.pay.destroy", ["pay" => "%s"]) }}',
                    show: '{{ route("workshift.pay.show", ["pay" => "%s"]) }}',
                    store: '{{ route("workshift.pay.store") }}',
                    update: '{{ route("workshift.pay.update", ["pay" => "%s"]) }}',
                },
                ping: '{{ route("workshift.ping") }}',
                placesList: '{{ route("workshift.places_list") }}',
                salesTypes: '{{ route("workshift.salesTypes") }}',
                users: {
                    activeManagers: '{{ route("workshift.users.active_managers") }}',
                    city: '{{ route("workshift.users.city", ["cityID" => $workshift->city_id]) }}',
                },
                withdraw: {
                    all: '{{ route("workshift.withdraw.index") }}',
                    store: '{{ route("workshift.withdraw.store") }}',
                    update: '{{ route("workshift.withdraw.update", ["withdraw" => "%s"]) }}',
                    delete: '{{ route("workshift.withdraw.destroy", ["withdraw" => "%s"]) }}',
                },
            };
        </script>
        @vite(['resources/js/workshift.js'])

@endsection
