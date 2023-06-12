@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Ratings css -->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/css/ratings.css')}}">
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/css/rating-themes.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Иванов Иван<span class="font-weight-normal text-muted ml-2">Сотрудник</span></h4>
							</div>
						</div>
						<!--End Page header-->

						<!-- Row -->
						<div class="row">
							<div class="col-xl-3 col-md-12 col-lg-12">
								<div class="card box-widget widget-user">
									<div class="card-body text-center">
										<div class="widget-user-image mx-auto text-center">
											<img  class="avatar avatar-xxl brround rounded-circle" alt="img" src="{{URL::asset('assets/images/users/1.jpg')}}">
										</div>
										<div class="pro-user mt-3">
											<h5 class="pro-user-username text-dark mb-1 fs-16">Иванов Иван</h5>
											<h6 class="pro-user-desc text-muted fs-14">Фотограф</h6>
											<h6 class="pro-user-desc fs-14"><a href="{{url('structure/cities/0')}}">Белгород</a></h6>
											<span class="badge badge-success">Работает</span>
										</div>

									</div>

								</div>

							</div>
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="tab-menu-heading hremp-tabs p-0 ">
									<div class="tabs-menu1">
										<!-- Tabs -->
										<ul class="nav panel-tabs">
											<li class="ml-4"><a href="#tab5" class="active"  data-toggle="tab">Личные данные</a></li>
											<li><a href="#tab6"  data-toggle="tab">Рабочие данные</a></li>
										</ul>
									</div>
								</div>
								<div class="panel-body tabs-menu-body hremp-tabs1 p-0">
									<div class="tab-content">
										<div class="tab-pane active" id="tab5">
											<div class="card-body">
												<h4 class="mb-4 font-weight-bold">Основное</h4>
												<div class="form-group ">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">ФИО</label>
														</div>
														<div class="col-md-9">
															<div class="row">
																<div class="col-md-4">
																	<input type="text" class="form-control mb-md-0 mb-5"  placeholder="Фамилия" value="Иванов">
																	<span class="text-muted"></span>
																</div>
																<div class="col-md-4">
																	<input type="text" class="form-control"  placeholder="Имя" value="Иван">
																</div>
																<div class="col-md-4">
																	<input type="text" class="form-control"  placeholder="Отчество" value="Иванович">
																</div>																
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Номер телефона</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control"  placeholder="Phone Number" value="9685321475">
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Дополнительный номер телефона</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control"  placeholder="Contact Number01" value="8695324712">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Дата рождения</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control fc-datepicker" placeholder="DD.MM.YYYY" value="01.01.1994">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label">Пол</label>
														</div>
														<div class="col-md-9">
															<div class="custom-controls-stacked d-md-flex">
																<label class="custom-control custom-radio mr-4">
																	<input type="radio" class="custom-control-input" name="example-radios4" value="option1">
																	<span class="custom-control-label">Мужской</span>
																</label>
																<label class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" name="example-radios4" value="option2" checked>
																	<span class="custom-control-label">Женский</span>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Семейное положение</label>
														</div>
														<div class="col-md-9">
															<select name="projects"  class="form-control custom-select select2">
																<option value="0">Не указано</option>
																<option value="1" selected>Холост/Не замужем</option>
																<option value="2">Женат/Замужем</option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Образование</label>
														</div>
														<div class="col-md-9">
															<select name="projects"  class="form-control custom-select select2">
																<option value="0">Не указано</option>
																<option value="1" selected>Среднее</option>
																<option value="2">Средне-специальное</option>
																<option value="3">Высшее неоконченное</option>
																<option value="4">Высшее</option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Email</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control"  placeholder="email" value="faith@gmail.com">
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Адрес регистрации</label>
														</div>
														<div class="col-md-9">
															<textarea rows="3" class="form-control" placeholder="">4102 Masonic Hill Road Little Rock Arkansas-727212</textarea>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Адрес проживания</label>
														</div>
														<div class="col-md-9">
															<textarea rows="3" class="form-control" placeholder="">4102 Masonic Hill Road Little Rock Arkansas-727212</textarea>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<div class="form-label mb-0 mt-2">Фото сотрудника</div>
														</div>
														<div class="col-md-9">
															<div class="input-group file-browser">
																<input type="text" class="form-control border-right-0 browse-file" placeholder="Загрузите фотографию" readonly>
																<label class="input-group-append mb-0">
																	<span class="btn ripple btn-primary">
																		Загрузить <input type="file" class="file-browserinput"  style="display: none;">
																	</span>
																</label>
															</div>
														</div>
													</div>
												</div>
												<h4 class="mb-5 mt-7 font-weight-bold">Данные аккаунта</h4>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Email</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control"  placeholder="Email" value="faith@gmail.com">
														</div>
													</div>
												</div>
												<!-- Поле Пароль показывать только при создании нового сотрудника -->
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Пароль</label>
														</div>
														<div class="col-md-9">
															<input type="password" class="form-control"  placeholder="Пароль" value="12345">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab6">
											<div class="card-body">
												<h4 class="mb-4 font-weight-bold">Основное</h4>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">ID сотрудника</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" readonly value="#2987">
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Город</label>
														</div>
														<div class="col-md-9">
															<select name="city"  class="form-control custom-select select2">
																<option value="0">Не указан</option>
																<!-- Загружаются из таблицы Города -->
																<option value="1" selected>Белгород</option>
																<option value="2">Краснодар</option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Должность</label>
														</div>
														<div class="col-md-9">
															<select name="city"  class="form-control custom-select select2">
																<option value="0">Не указана</option>
																<!-- Загружаются из таблицы Должности -->
																<option value="1" selected>Фотограф</option>
																<option value="2">Продавец</option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Статус</label>
														</div>
														<div class="col-md-9">
															<select name="city"  class="form-control custom-select select2">
																<option value="0">Не указан</option>
																<option value="1">Испытательный срок</option>
																<option value="2" selected>Принят на работу</option>
																<option value="3">В отпуске</option>
																<option value="4">Уволен</option>
															</select>
														</div>
													</div>
												</div>												
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Дата приема на работу</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY" value="05.05.2017">
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label class="form-label mb-0 mt-2">Дата увольнения</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center">
													<h4 class="mb-5 mt-7 font-weight-bold">Заработная плата</h4>
													<a href="" data-target="#salary-edit" data-toggle="modal" class="btn btn-primary btn-sm ml-auto">Добавить оклад</a>
												</div>
												<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
													<thead>
														<tr>
															<th class="border-bottom-0 w-10">Дата</th>
															<th class="border-bottom-0">Оклад, руб./час</th>
															<th class="border-bottom-0">Действия</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>05.05.2017</td>
															<td>5000</td>
															<td>
																<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#salary-edit" data-toggle="modal">
																	<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																</a>
																<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
															</td>															
														</tr>
														<tr>
															<td>05.05.2020</td>
															<td>10000</td>
															<td>
																<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#salary-edit" data-toggle="modal">
																	<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																</a>
																<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
															</td>															
														</tr>																											
													</tbody>
												</table>												

											</div>
										</div>

										<div class="card-footer text-right">
											<a href="#" class="btn btn-primary">Сохранить изменения</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')

			<!--Change salary Modal -->
			<div class="modal fade"  id="salary-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Зарплата</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Дата начала дейстия оклада</label>
								<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Оклад</label>
								<input type="number" class="form-control" placeholder="Сумма оклада" value="">
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

		<!-- INTERNAl Rating js-->
		<script src="{{URL::asset('assets/plugins/rating/js/jquery.barrating.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/rating/js/custom-ratings.js')}}"></script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/employee.js')}}"></script>

@endsection
