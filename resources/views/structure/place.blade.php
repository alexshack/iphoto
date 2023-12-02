@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ $place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } ?? null }}<a href="{{ route('admin.structure.places.index') }}" class="font-weight-normal text-muted ml-2">Точки</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-types">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные точки</h4>
									</div>
									<div class="card-body">
                                        @if(session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif

                                        @if(Route::currentRouteName() == 'admin.structure.places.edit')
										<form class="form-horizontal" action="{{ route('admin.structure.places.update', ['id' => $place->{ \App\Contracts\Structure\PlaceContract::FIELD_ID }]) }}" method="post">
                                        @else
                                        <form class="form-horizontal" action="{{ route('admin.structure.places.store') }}" method="post">
                                        @endif
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group row">
                                                <label class="form-label col-md-3">Название точки</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="{{ \App\Contracts\Structure\PlaceContract::FIELD_NAME }}" class="form-control"  placeholder="Название точки" value="{{ $place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } ?? old(\App\Contracts\Structure\PlaceContract::FIELD_NAME) }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="form-label  col-md-3">Статус</label>
                                                <div class="col-md-9">
                                                    <select name="{{ \App\Contracts\Structure\PlaceContract::FIELD_STATUS }}" class="form-control custom-select select2">
                                                        @foreach(\App\Contracts\Structure\PlaceContract::STATUS_LIST as $key => $status)
                                                            <option value="{{ $key }}" {{ (isset($place) && $place->{ \App\Contracts\Structure\PlaceContract::FIELD_STATUS } == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="form-label col-md-3">Город</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" name="{{ \App\Contracts\Structure\PlaceContract::FIELD_CITY_ID }}" data-placeholder="Выберите город">
														@foreach($cities as $city)
                                                            <option value="{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_ID } }}" {{ (isset($place) && $place->{ \App\Contracts\Structure\PlaceContract::FIELD_CITY_ID } == $city->{ \App\Contracts\Structure\CityContract::FIELD_ID }) ? 'selected' : '' }}>{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label col-md-3">Дата открытия</label>
												<div class="col-md-9">
													<input type="text" name="{{ \App\Contracts\Structure\PlaceContract::FIELD_OPENING_DATE }}" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY" value="{{ (isset($place)) ? $place->{ \App\Contracts\Structure\PlaceContract::FIELD_OPENING_DATE }->format('d.m.Y') : old(\App\Contracts\Structure\PlaceContract::FIELD_OPENING_DATE) }}">
												</div>
											</div>
                                            @if(Route::currentRouteName() == 'admin.structure.places.edit')
											<div class="form-group row">
												<div class="form-label col-md-3">Начисления <a href="" data-target="#calc-add" data-toggle="modal" class="badge badge-primary">Добавить</a></div>
												<div class="col-md-9">
													<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
														<thead>
															<tr>
																<th class="border-bottom-0 w-10">Дата начала</th>
																<th class="border-bottom-0 w-10">Дата окончания</th>
																<th class="border-bottom-0">Тип начисления</th>
																<th class="border-bottom-0">Начисление</th>
																<th class="border-bottom-0">Действия</th>
															</tr>
														</thead>
														<tbody>
                                                            @if(!empty($placeCalcs))
                                                                @foreach($placeCalcs as $calc)
                                                                    @php
                                                                        $end_date = (!empty($calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE })) ? $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE }->format('d.m.Y') : ''
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_START_DATE }->format('d.m.Y') }}</td>
                                                                        <td>{{ !empty($calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE }) ? $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE }->format('d.m.Y') : '-' }}</td>
                                                                        <td>{{ $calc->calcsType->getTypeName() }}</td>
                                                                        <td>{{ $calc->calcsType->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } }}</td>
                                                                        <td>
                                                                            <a class="btn btn-primary btn-icon btn-sm" onclick="document.editPlaceCalc({{ '\'' . route('admin.structure.place_calcs.update', ['id' => $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_ID }]) . '\', ' . $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_PLACE_ID } . ', \'' . $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_START_DATE }->format('d.m.Y') . '\', \'' . $end_date . '\', ' . $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_CALCS_TYPE_ID } }})">
                                                                                <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                            </a>
                                                                            <!--кнопка удаления показывается только если текущая дата равна или меньше даты начала -->
                                                                            <form style="display: inline-block" action="{{ route('admin.structure.place_calcs.destroy', ['id' => $calc->{ \App\Contracts\Structure\PlaceCalcContract::FIELD_ID }]) }}" method="post">
                                                                                @csrf
                                                                                <button class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить"><i class="feather feather-trash-2"></i></button>
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
                        @livewire('place.place-goods', compact('place'))


@endsection('content')

@section('modals')

			<!--Change place Modal -->
			<div class="modal fade"  id="calc-add">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
                            <div id="errors-add"></div>
                            <input type="hidden" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_PLACE_ID }}" value="{{ request()->route('id') }}" />
							<div class="form-group">
								<label class="form-label">Дата начала действия</label>
								<input type="text" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_START_DATE }}" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY" required>
							</div>
							<div class="form-group">
								<label class="form-label">Дата окончания действия</label>
								<input type="text" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE }}" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Начисление</label>
								<select class="form-control select2-show-search custom-select" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_CALCS_TYPE_ID }}" data-placeholder="Выберите начисление" required>
									<option label="Выберите начисление"></option>
									<!--Выводятся виды начислений, у которых Участвует в автоматическом расчете = ДА -->
                                    @if(!empty($calcTypes))
                                        @foreach($calcTypes as $type)
                                            <option value="{{ $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_ID } }}">{{ $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } }}</option>
                                        @endforeach
                                    @endif
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<button id="addPlaceCalc" class="btn btn-primary">Добавить</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Change place Modal  -->
            <div class="modal fade"  id="calc-edit">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="errors-edit"></div>
                            <input type="hidden" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_PLACE_ID }}" value="{{ request()->route('id') }}">
                            <input type="hidden" name="url" value="">
                            <div class="form-group">
                                <label class="form-label">Дата начала действия</label>
                                <input type="text" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_START_DATE }}" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Дата окончания действия</label>
                                <input type="text" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_END_DATE }}" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Начисление</label>
                                <select class="form-control select2-show-search custom-select" name="{{ \App\Contracts\Structure\PlaceCalcContract::FIELD_CALCS_TYPE_ID }}" data-placeholder="Выберите начисление" required>
                                    <option label="Выберите начисление"></option>
                                    <!--Выводятся виды начислений, у которых Участвует в автоматическом расчете = ДА -->
                                    @if(!empty($calcTypes))
                                        @foreach($calcTypes as $type)
                                            <option value="{{ $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_ID } }}">{{ $type->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
                            <button id="updatePlaceCalc" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>

@endsection('modals')

@section('scripts')
    <script>
        var createUrl = '{{ route('admin.structure.place_calcs.store') }}';
    </script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/place.js')}}"></script>

@endsection
