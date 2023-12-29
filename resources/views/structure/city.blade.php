@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ (isset($city)) ? $city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } : '' }}<a href="{{ route('admin.structure.cities.index') }}" class="font-weight-normal text-muted ml-2">Города</a></h4>
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
                                        @if(session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif

                                        @if(Route::currentRouteName() == 'admin.structure.cities.edit')
										<form class="form-horizontal" action="{{ route('admin.structure.cities.update', ['id' => $city->{ \App\Contracts\Structure\CityContract::FIELD_ID }]) }}" method="post">
                                        @else
                                        <form class="form-horizontal" action="{{ route('admin.structure.cities.store') }}" method="post">
                                        @endif
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group row">
                                                <label class="form-label col-md-3">Название города</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" class="form-control"  placeholder="Название города" value="{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } ?? old(\App\Contracts\Structure\CityContract::FIELD_NAME) }}">
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="form-label col-md-3">Дата открытия</label>
												<div class="col-md-9">
													<input type="text" name="opening_date" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY" value="{{ (isset($city)) ? $city->{ \App\Contracts\Structure\CityContract::FIELD_OPENING_DATE }->format('d.m.Y') : old(\App\Contracts\Structure\CityContract::FIELD_OPENING_DATE) }}">
												</div>
											</div>
                                            @if(Route::currentRouteName() == 'admin.structure.cities.edit')
											<div class="form-group row">
												<div class="form-label col-md-3">Менеджер <a href="" data-target="#manager-add" data-toggle="modal" class="badge badge-primary">Добавить</a></div>
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
                                                        @if(isset($managerHistory) && !empty($managerHistory))
                                                            @foreach($managerHistory as $item)
                                                                <tr>
                                                                    <td>{{ $item->{ \App\Contracts\Structure\CityManagerContract::FIELD_APPOINTMENT_DATE }->format('d.m.Y') }}</td>
                                                                    <td>{{ $item->user()->first()->getFullName() }}</td>
                                                                    <td>
                                                                        <div class="btn btn-primary btn-icon btn-sm" onclick="document.editCityManager({{ '\'' . route('admin.structure.city_manager.update', ['id' => $item->{ \App\Contracts\Structure\CityManagerContract::FIELD_ID }]) . '\', \'' . $item->{ \App\Contracts\Structure\CityManagerContract::FIELD_MANAGER_ID } . '\', \'' . $item->{ \App\Contracts\Structure\CityManagerContract::FIELD_APPOINTMENT_DATE } .'\'' }})">
                                                                            <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                        </div>
                                                                        <form style="display: inline-block" method="post" action="{{ route('admin.structure.city_manager.destroy', ['id' => $item->{ \App\Contracts\Structure\CityManagerContract::FIELD_ID }]) }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button  class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
														</tbody>
													</table>
												</div>
											</div>
                                            @endif

                                            @if ($errors->any())
											<div class="alert alert-danger" role="alert">
												<button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li><i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}</li>
                                                    @endforeach
                                                </ul>
											</div>
                                            @endif
											<button class="btn btn-lg btn-primary" type="submit">Сохранить</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection

@section('modals')
        @if(Route::currentRouteName() == 'admin.structure.cities.edit')
			<!--Change place Modal -->
			<div class="modal fade"  id="manager-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
                            <div id="errors-edit"></div>
                            <input type="hidden" name="url" value="">
							<div class="form-group">
								<label class="form-label">Дата</label>
								<input type="text" name="appointment_date" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Менеджер</label>
								<select class="form-control select2-show-search custom-select" name="manager_id" data-placeholder="Выберите менеджера">
									<option label="Выберите менеджера"></option>
                                    @if(isset($managers) && !empty($managers))
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->{ \App\Contracts\UserContract::FIELD_ID } }}">{{ $manager->getFullName() }}</option>
                                        @endforeach
                                    @endif
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<button id="updateCityManager" class="btn btn-primary">Сохранить</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Change place Modal  -->
            <div class="modal fade"  id="manager-add">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="errors-add"></div>
                            <input type="hidden" name="city_id" value="{{ request()->route('id') }}">
                            <div class="form-group">
                                <label class="form-label">Дата</label>
                                <input type="text" name="appointment_date" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Менеджер</label>
                                <select class="form-control select2-show-search custom-select" name="manager_id" data-placeholder="Выберите менеджера">
                                    <option label="Выберите менеджера"></option>
                                    @if(isset($managers) && !empty($managers))
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->{ \App\Contracts\UserContract::FIELD_ID } }}">{{ $manager->getFullName() }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
                            <button id="addCityManager" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
@endsection

@section('scripts')
    <script>
        var createUrl = '{{ route('admin.structure.city_manager.store') }}';
    </script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/city.js')}}"></script>

@endsection
