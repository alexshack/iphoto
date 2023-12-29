@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Должности сотрудников<span class="font-weight-normal text-muted ml-2">Учет зарплаты</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<button  data-target="#employee-position-add" data-toggle="modal" class="btn btn-primary mr-3">Добавить должность</button>
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
										<h4 class="card-title">Должности сотрудников</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="employee-positions">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                @foreach($list as $item)
                                                    <tr>
                                                        <td>{{ $item->{ \App\Contracts\PositionContract::FIELD_NAME } }}</td>
                                                        <td><span class="badge {{ \App\Contracts\PositionContract::STATUS_CLASS_LIST[ $item->{ \App\Contracts\PositionContract::FIELD_STATUS } ] ?? 'badge-secondary' }}">{{ \App\Contracts\PositionContract::STATUS_LIST[$item->{ \App\Contracts\PositionContract::FIELD_STATUS }] }}</span></td>
                                                        <td>
                                                            <a class="btn btn-primary btn-icon btn-sm" onclick="document.editEmployeePosition({{ '\'' . route('admin.salary.employee_positions.update', ['id' => $item->{ \App\Contracts\PositionContract::FIELD_ID }]) . '\', \'' . $item->{ \App\Contracts\PositionContract::FIELD_NAME } . '\', ' . $item->{ \App\Contracts\PositionContract::FIELD_STATUS } }})">
                                                                <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                            </a>
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

			<!--Change salary Modal -->
			<div class="modal fade"  id="employee-position-add">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Должность сотрудника</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
                            <div id="errors-add"></div>
							<div class="form-group">
								<label class="form-label">Название</label>
								<input type="text" class="form-control" name="name" placeholder="Введите название">
							</div>
							<div class="form-group">
								<label class="form-label">Статус</label>
								<select class="form-control custom-select select2" name="status">
									<!--Список задается жестко -->
                                    @foreach(\App\Contracts\PositionContract::STATUS_LIST as $key => $item)
                                        <option value="{{ $key }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<button id="addEmployeePosition" class="btn btn-primary">Добавить</button>
						</div>
					</div>
				</div>
			</div>
            <div class="modal fade"  id="employee-position-edit">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Должность сотрудника</h5>
                            <button  class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="errors-edit"></div>
                            <input type="hidden" name="url" value="">
                            <div class="form-group">
                                <label class="form-label">Название</label>
                                <input type="text" class="form-control" name="name" placeholder="Введите название">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <select class="form-control custom-select select2" name="status">
                                    <!--Список задается жестко -->
                                    @foreach(\App\Contracts\PositionContract::STATUS_LIST as $key => $item)
                                        <option value="{{ $key }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
                            <button id="updateEmployeePosition" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
			<!-- End Change salary Modal  -->

@endsection('modals')

@section('scripts')
    <script>
        var createUrl = '{{ route('admin.salary.employee_positions.store') }}';
    </script>

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/employee-positions.js?v=1')}}"></script>

@endsection
