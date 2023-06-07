@extends('layouts.admin')

@section('styles')



		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Администратор<span class="font-weight-normal text-muted ml-2">Главная</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">

							</div>
						</div>
						<!--End Page header-->


						<!--Row-->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Города</span>
															<h3 class="mb-0 mt-1 mb-2">15</h3><!-- количество городов -->
														</div>
													</div>
													<div class="col-3">
														<div class="icon1 my-auto  float-right"> <a href="{{url('structure/cities')}}"><i class="feather feather-map-pin"></i></a> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Точки</span>
															<h3 class="mb-0 mt-1 mb-2">124</h3><!-- количество точек -->
														</div>
													</div>
													<div class="col-3">
														<div class="icon1 my-auto  float-right"> 
															<a href="{{url('structure/places')}}">
																<i class="feather feather-shopping-cart"></i> </div>
															</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Сотрудники</span>
															<h3 class="mb-0 mt-1 mb-2">567</h3><!-- количество сотрудников -->
														</div>
													</div>
													<div class="col-3">
														<div class="icon1 my-auto  float-right"> 
															<a href="{{url('structure/employees')}}">
																<i class="feather feather-users"></i> </div>
															</a>
													</div>
												</div>
											</div>
										</div>
									</div>									
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">											
											<div class="card-body">												
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи сегодня</span>
														<h3 class="mb-0 mt-1  mb-2">584 225₽</h3> </div><!-- сумма данных по кассам за текущий день -->
													</div>
													<div class="col-3">
														<div class="icon1 brround my-auto  float-right">
															<a href="{{url('money/days')}}"> 
																<i class="feather feather-dollar-sign"></i> 
															</a>
														</div>
													</div>
												</div>
											</div>											
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">											
											<div class="card-body">												
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи вчера</span>
														<h3 class="mb-0 mt-1 mb-2">584 225₽</h3> </div><!-- сумма данных по кассам за вчерашний день -->
													</div>
													<div class="col-3">
														<div class="icon1 brround my-auto  float-right">
															<a href="{{url('money/days')}}"> 
																<i class="feather feather-dollar-sign"></i> 
															</a>
														</div>
													</div>
												</div>
											</div>											
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-md-12">
										<div class="card">											
											<div class="card-body">												
												<div class="row">
													<div class="col-9">
														<div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи за месяц</span>
														<h3 class="mb-0 mt-1  mb-2">10 584 225₽</h3> </div><!-- сумма продаж за месяц -->
													</div>
													<div class="col-3">
														<div class="icon1 brround my-auto  float-right">
															<a href="{{url('money/days')}}"> 
																<i class="feather feather-dollar-sign"></i> 
															</a>
														</div>
													</div>
												</div>
											</div>											
										</div>
									</div>																		
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header border-bottom-0">
										<h3 class="card-title">Смены</h3>
									</div>
									<div class="tab-menu-heading table_tabs mt-2 p-0 ">
										<div class="tabs-menu1">
											<!-- Tabs -->
											<ul class="nav panel-tabs">
												<li class="ml-4"><a href="#tab-today" class="active"  data-toggle="tab">Сегодня</a></li>
												<li><a href="#tab-yesterday" data-toggle="tab">Вчера</a></li>
											</ul>
										</div>
									</div>
									<div class="panel-body tabs-menu-body table_tabs1 p-0 border-0">
										<div class="tab-content">
											<div class="tab-pane active" id="tab-today">
												<div class="table-responsive pt-3 pl-3 pr-3">
													<table class="table table-vcenter text-nowrap mb-0" id="days-today">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Статус</th>
																<th class="border-bottom-0">Город</th>
																<th class="border-bottom-0">Точка</th>
																<th class="border-bottom-0 text-center">Сотрудники на точке</th>
																<th class="border-bottom-0 text-center">Время снятия кассы</th>
																<th class="border-bottom-0 text-center">Касса</th>
																<th class="border-bottom-0 text-center">Расходы</th>
																<th class="border-bottom-0 text-center">Зарплата</th>
																
															</tr>
														</thead>
														<tbody>
															<tr>
																<td data-order="1" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
																	<a href="money/days/0" class="badge bg-success-transparent">Закрыта</a><!-- bg-success-transparent - если закрыта, bg-primary-transparent - если открыта -->
																</td>																
																<td data-order="Белгород">
																	<a href="{{url('structure/cities/0')}}" class="text-dark font-weight-semibold">Белгород</a>
																</td>
																<td data-order="Сити Молл">
																	<a href="{{url('structure/places/0')}}" class="text-dark font-weight-semibold">Сити Молл</a>
																</td>																
																<td class="text-center">
																	<div class="avatar-list avatar-list-stacked"><!-- сотрудники, которые в данные момент на смене -->
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/5.jpg')}}" alt="img">
																		</a>
																	</div>
																</td>
																<td data-order="1303682400" class="text-center">15:00</td>
																<td data-order="12000" class="text-right">12 000₽</td>
																<td data-order="500" class="text-right">500₽</td>
																<td data-order="2000" class="text-right">2 000₽</td>
															</tr>
															<tr>
																<td data-order="0" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
																	<a href="money/days/0" class="badge bg-primary-transparent">Открыта</a><!-- bg-success-transparent - если закрыта, bg-primary-transparent - если открыта -->
																</td>																
																<td data-order="Белгород">
																	<a href="{{url('structure/cities/0')}}" class="text-dark font-weight-semibold">Белгород</a>
																</td>
																<td data-order="Зоопарк">
																	<a href="{{url('structure/places/0')}}" class="text-dark font-weight-semibold">Зоопарк</a>
																</td>																
																<td class="text-center">
																	<div class="avatar-list avatar-list-stacked"><!-- сотрудники, которые в данные момент на смене -->
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																		</a>
																	</div>
																</td>
																<td data-order="1303682400" class="text-center">15:00</td>
																<td data-order="12000" class="text-right">12 000₽</td>
																<td data-order="500" class="text-right">500₽</td>
																<td data-order="2000" class="text-right">2 000₽</td>
															</tr>															
														</tbody>
													</table>
												</div>
											</div>
											<div class="tab-pane" id="tab-yesterday">
												<div class="table-responsive pt-3 pl-3 pr-3">
													<table class="table table-vcenter text-nowrap mb-0" id="days-yesterday">
														<thead>
															<tr>
																<th class="border-bottom-0 text-center">Статус</th>
																<th class="border-bottom-0">Город</th>
																<th class="border-bottom-0">Точка</th>
																<th class="border-bottom-0 text-center">Сотрудники на точке</th>
																<th class="border-bottom-0 text-center">Время закрытия смены</th>
																<th class="border-bottom-0 text-center">Касса</th>
																<th class="border-bottom-0 text-center">Расходы</th>
																<th class="border-bottom-0 text-center">Зарплата</th>
																
															</tr>
														</thead>
														<tbody>
															<tr>
																<td data-order="1" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
																	<a href="money/days/0" class="badge bg-success-transparent">Закрыта</a><!-- bg-success-transparent - если закрыта, bg-danger-transparent - если открыта -->
																</td>																
																<td data-order="Белгород"><!-- data-order: city->name -->
																	<a href="{{url('structure/cities/0')}}" class="text-dark font-weight-semibold">Белгород</a>
																</td>
																<td data-order="Сити Молл"><!-- data-order: place->name -->
																	<a href="{{url('structure/places/0')}}" class="text-dark font-weight-semibold">Сити Молл</a>
																</td>																
																<td class="text-center">
																	<div class="avatar-list avatar-list-stacked"><!-- сотрудники, которые в данные момент на смене -->
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/5.jpg')}}" alt="img">
																		</a>
																	</div>
																</td>
																<td data-order="1303682400" class="text-center">15:00</td><!-- data-order: time -->
																<td data-order="12000" class="text-right">12 000₽</td><!-- data-order: int -->
																<td data-order="500" class="text-right">500₽</td><!-- data-order: int -->
																<td data-order="2000" class="text-right">2 000₽</td><!-- data-order: int -->
															</tr>
															<tr>
																<td data-order="0" class="text-center"><!-- data-order: 1 - если закрыта, 0 - если открыта -->
																	<a href="money/days/0" class="badge bg-danger-transparent">Открыта</a><!-- bg-success-transparent - если закрыта, bg-danger-transparent - если открыта -->
																</td>																
																<td data-order="Белгород">
																	<a href="{{url('structure/cities/0')}}" class="text-dark font-weight-semibold">Белгород</a>
																</td>
																<td data-order="Зоопарк">
																	<a href="{{url('structure/places/0')}}" class="text-dark font-weight-semibold">Зоопарк</a>
																</td>																
																<td class="text-center">
																	<div class="avatar-list avatar-list-stacked"><!-- сотрудники, которые в данные момент на смене -->
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img">
																		</a>
																		<a href="{{url('structure/employees/0')}}" title="Сотрудник Сотрудников">
																			<img class="avatar avatar-md brround" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img">
																		</a>
																	</div>
																</td>
																<td data-order="1303682400" class="text-center">15:00</td>
																<td data-order="12000" class="text-right">12 000₽</td>
																<td data-order="500" class="text-right">500₽</td>
																<td data-order="2000" class="text-right">2 000₽</td>
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

@endsection('content')

@section('modals')


@endsection('modals')

@section('scripts')


		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Vertical-scroll js-->
<!-- 		<script src="{{URL::asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/vertical-scroll/vertical-scroll.js')}}"></script> -->


		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/admin/index.js')}}"></script>

@endsection
