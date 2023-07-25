@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Белгород<a href="{{url('structure/cities')}}" class="font-weight-normal text-muted ml-2">Города</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные города</h4>
									</div>
									<div class="card-body">
										<form class="form-horizontal">
											<div class="form-group row">
												<label class="form-label col-md-3">Дата открытия</label>
												<div class="col-md-9">
													<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
												</div>												
											</div>
											<div class="form-group row">
												<div class="form-label col-md-3">Менеджер <a href="" data-target="#manager-edit" data-toggle="modal" class="badge badge-primary">Добавить</a></div>
												<div class="col-md-9">
													<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
														<thead>
															<tr>
																<th class="border-bottom-0 w-10">Дата</th>
																<th class="border-bottom-0">Менеджер</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>05.05.2017</td>
																<td>Менеджеров Менеджер</td>
																<td>
																	<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#manager-edit" data-toggle="modal">
																		<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																	</a>
																	<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
																</td>															
															</tr>
															<tr>
																<td>09.12.2017</td>
																<td>Иванов Иван</td>
																<td>
																	<a class="btn btn-primary btn-icon btn-sm" href="" data-target="#manager-edit" data-toggle="modal">
																		<i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
																	</a>
																	<a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></a>
																</td>															
															</tr>																											
														</tbody>
													</table>
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
			<div class="modal fade"  id="manager-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Дата</label>
								<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Менеджер</label>
								<select class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
									<option label="Выберите менеджера"></option>
									<option value="1">Менеджеров Менеджер</option>
									<option value="2">Иванов Иван</option>
									<option value="3">Петров Сергей</option>
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
		<script src="{{URL::asset('assets/js/structure/city.js')}}"></script>

@endsection
