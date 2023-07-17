@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Виды расходов<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<button  data-target="#expenses-type-add" data-toggle="modal" class="btn btn-primary mr-3">Добавить вид расходов</button>
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
										<h4 class="card-title">Виды расходов</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expenses-types">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Право создания</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                @foreach($list as $item)
                                                    <tr>
                                                        <td>{{ $item->{ \App\Contracts\Money\ExpensesTypeContract::FIELD_NAME } }}</td>
                                                        <td>-</td>
                                                        <td><span class="badge {{ \App\Contracts\Money\ExpensesTypeContract::STATUS_CLASS_LIST[ $item->{ \App\Contracts\Money\ExpensesTypeContract::FIELD_STATUS } ] ?? 'badge-secondary' }}">{{ \App\Contracts\Money\ExpensesTypeContract::STATUS_LIST[$item->{ \App\Contracts\Money\ExpensesTypeContract::FIELD_STATUS }] }}</span></td>
                                                        <td>
                                                            <button class="btn btn-primary btn-icon btn-sm" onclick="document.editExpensesType({{ '\'' . route('admin.money.expenses_types.update', ['id' => $item->{ \App\Contracts\Money\SalesTypeContract::FIELD_ID }]) . '\', \'' . $item->{ \App\Contracts\Money\SalesTypeContract::FIELD_NAME } . '\', ' . $item->{ \App\Contracts\Money\SalesTypeContract::FIELD_STATUS } . ', \'' . json_encode($item->roles()->pluck( \App\Contracts\UserRoleContract::TABLE . '.' . \App\Contracts\UserRoleContract::FIELD_ID)) . '\'' }})">
                                                                <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                            </button>
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

			<div class="modal fade"  id="expenses-type-add">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Вид поступлений</h5>
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
								<label class="form-label">Право создания расхода</label>
								<select multiple="multiple" name="role_list" class="select1">
									<!--Список задается жестко, value проставь сам, как удобнее - ID роли пользователя -->
								   @foreach(\App\Models\Role::all() as $key => $item)
                                        <option value="{{ $item->{ \App\Contracts\UserRoleContract::FIELD_ID } }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $item->{ \App\Contracts\UserRoleContract::FIELD_NAME } }}</option>
								   @endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">Статус</label>
								<select class="form-control custom-select select2" name="status">
									<!--Список задается жестко -->
                                    @foreach(\App\Contracts\Money\ExpensesTypeContract::STATUS_LIST as $key => $item)
                                        <option value="{{ $key }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<button id="addExpensesType" class="btn btn-primary">Сохранить</button>
						</div>
					</div>
				</div>
			</div>
            <div class="modal fade"  id="expenses-type-edit">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Вид поступлений</h5>
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
                                <label class="form-label">Право создания расхода</label>
                                <select multiple="multiple" name="role_list" class="select1">
                                    <!--Список задается жестко, value проставь сам, как удобнее - ID роли пользователя -->
                                    @foreach(\App\Models\Role::all() as $key => $item)
                                        <option value="{{ $item->{ \App\Contracts\UserRoleContract::FIELD_ID } }}">{{ $item->{ \App\Contracts\UserRoleContract::FIELD_NAME } }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <select class="form-control custom-select select2" name="status">
                                    <!--Список задается жестко -->
                                    @foreach(\App\Contracts\Money\ExpensesTypeContract::STATUS_LIST as $key => $item)
                                        <option value="{{ $key }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
                            <button id="updateExpensesType" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>


@endsection('modals')

@section('scripts')
    <script>
        var createUrl = '{{ route('admin.money.expenses_types.store') }}';
    </script>

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/expenses-types.js?v=1')}}"></script>

@endsection
