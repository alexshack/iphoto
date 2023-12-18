@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ (isset($goods)) ? $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_NAME } : '' }}<a href="{{ route('admin.goods.index') }}" class="font-weight-normal text-muted ml-2">Товары</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные товара</h4>
									</div>
									<div class="card-body">
                                        @if(session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif
                                        @if(Route::currentRouteName() == 'admin.goods.edit')
                                        <form class="form-horizontal" action="{{ route('admin.goods.update', ['id' => $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_ID }]) }}" method="post">
                                        @else
                                        <form class="form-horizontal" action="{{ route('admin.goods.store') }}" method="post">
                                        @endif
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE }}" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } ?? 1 }}">
											<div class="form-group row">
												<label class="form-label  col-md-3">Категория</label>
												<div class="col-md-9">
													<select class="form-control select2-show-search custom-select" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_CATEGORY_ID }}" data-placeholder="Выберите категорию товара">
														@foreach($categories as $category)
                                                            <option value="{{ $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_ID } }}" {{ (isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_CATEGORY_ID } == $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_ID }) ? 'selected' : '' }}>{{ $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_NAME } }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="form-label col-md-3">Наименование</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_NAME }}" placeholder="" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_NAME } ?? old(\App\Contracts\Goods\GoodsContract::FIELD_NAME) }}">
												</div>
											</div>

											<div class="card-pay">
												<div class="row">
													<label class="form-label col-md-3">Выберите тип товара</label>
													<ul class="tabs-menu nav col-md-9">
														<!-- Задаются жестко -->
                                                        @if(Route::currentRouteName() == 'admin.goods.edit')
                                                            <li class=""><a href="#tab-{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } }}" data-type="1" class="active" data-toggle="tab">{{ $goods->getTypeName() }}</a></li>
                                                        @else
                                                            <li class=""><a href="#tab-1" data-type="1" class="{{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 1) || (!isset($goods))) ? 'active' : '' }}" data-toggle="tab">Продажа</a></li>
                                                            <li><a href="#tab-2" data-type="2" data-toggle="tab" class="{{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 2)) ? 'active' : '' }}">Индивидуальная продажа</a></li>
                                                            <li><a href="#tab-3" data-type="3" data-toggle="tab" class="{{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 3)) ? 'active' : '' }}">ТМЦ</a></li>
                                                            <li><a href="#tab-4" data-type="4" data-toggle="tab" class="{{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 4)) ? 'active' : '' }}">Расходные материалы</a></li>
                                                            <li><a href="#tab-5" data-type="5" data-toggle="tab" class="{{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 5)) ? 'active' : '' }}">Отработка</a></li>
                                                        @endif
													</ul>
												</div>
												<div class="tab-content">
													<div class="tab-pane show {{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 1)) ? 'active' : '' }}" id="tab-1">

													</div>
													<div class="tab-pane show {{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 2)) ? 'active' : '' }}" id="tab-2">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Сумма премии</label>
																<div class="col-md-9">
																	<input type="number" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_PRIZE_AMOUNT }}" class="form-control" placeholder="" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_PRIZE_AMOUNT } ?? old(\App\Contracts\Goods\GoodsContract::FIELD_PRIZE_AMOUNT) }}">
																</div>
															</div>
															<div class="form-group row">
																<div class="form-label col-md-3">Больше одного человека</div>
																<label class="custom-switch col-md-9">
																	<input type="checkbox" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_MORE_THAN_ONE }}" {{ (isset($goods) && !empty($goods->{ \App\Contracts\Goods\GoodsContract::FIELD_MORE_THAN_ONE })) ? 'checked' : '' }} class="custom-switch-input">
																	<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
																	<span class="custom-switch-description">Да</span>
																</label>
															</div>
														</div>
													</div>
													<div class="tab-pane show {{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 3)) ? 'active' : '' }}" id="tab-3">
														<div class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Серийный номер</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_SERIAL_NUMBER }}" placeholder="Укажите серийный номер ТМЦ" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_SERIAL_NUMBER } ?? old(\App\Contracts\Goods\GoodsContract::FIELD_SERIAL_NUMBER) }}">
																</div>
															</div>
															<div class="form-group row">
																<div class="form-label col-md-3">Вводить показания в смене</div>
																<label class="custom-switch col-md-9">
																	<input type="checkbox" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_ENTER_READINGS }}" {{ (isset($goods) && !empty($goods->{ \App\Contracts\Goods\GoodsContract::FIELD_ENTER_READINGS })) ? 'checked' : '' }} class="custom-switch-input">
																	<span class="custom-switch-indicator custom-switch-indicator-xl"></span>
																	<span class="custom-switch-description">Да</span>
																</label>
															</div>

                                                            <div class="form-group row">
                                                                <label class="form-label col-md-3">Комментарий</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_COMMENT }}" placeholder="Укажите комментарий" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_COMMENT } ?? old(\App\Contracts\Goods\GoodsContract::FIELD_COMMENT) }}">
                                                                </div>
                                                            </div>


                                                            <div class="form-group row">
                                                                <label class="form-label col-md-3">Примечания</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_NOTE }}" placeholder="Укажите примечания" value="{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_NOTE } ?? old(\App\Contracts\Goods\GoodsContract::FIELD_NOTE) }}">
                                                                    <span class="text-muted">Используется для отображения примечания в истории перемещений</span>
                                                                </div>
                                                            </div>


                                                            <div class="form-group row">
                                                                <div class="form-label col-md-3">Точка</div>
                                                                <div class="col-md-9">
                                                                    <select class="form-control select2-show-search custom-select" name="{{ \App\Contracts\Goods\GoodsContract::FIELD_PLACE_ID }}" data-placeholder="Выберите категорию товара">
                                                                        @foreach($places as $place)
                                                                            <option value="{{ $place->{ \App\Contracts\Structure\PlaceContract::FIELD_ID } }}" {{ (isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_PLACE_ID } == $place->{ \App\Contracts\Structure\PlaceContract::FIELD_ID }) ? 'selected' : '' }}>
                                                                            {{ $place->fullPath }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @if(Route::currentRouteName() == 'admin.goods.edit')
															<div class="form-group row">
																<div class="form-label col-md-3"></div>
																<div class="col-md-9">
																	<table class="table table-vcenter text-nowrap table-bordered border-bottom" id="salary-list">
																		<thead>
																			<tr>
																				<th class="border-bottom-0 w-10">Дата</th>
																				<th class="border-bottom-0">Город</th>
																				<th class="border-bottom-0">Точка</th>
                                                                                <th class="border-bottom-0">Примечания</th>
																			</tr>
																		</thead>
																		<tbody>
                                                                            @if(!empty($history))
                                                                                @foreach($history as $item)
                                                                                    <tr>
                                                                                        <td>{{ $item->created_at->format('d.m.Y') }}</td>
                                                                                        <td>{{ $item->place->city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</td>
                                                                                        <td>{{ $item->place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } }}</td>
                                                                                        <td>{{ $item->{ \App\Contracts\Goods\GoodsPlaceHistoryContract::FIELD_NOTE } }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
																		</tbody>
																	</table>
																</div>
															</div>
                                                            @endif
														</div>
													</div>
													<div class="tab-pane show {{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 4)) ? 'active' : '' }}" id="tab-4">

													</div>
													<div class="tab-pane show {{ ((isset($goods) && $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_TYPE } == 5)) ? 'active' : '' }}" id="tab-5">

													</div>
												</div>
											</div>
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

@endsection('content')

@section('modals')

			<!--Change place Modal -->
			<div class="modal fade"  id="place-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Точка</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Дата</label>
								<input type="text" class="form-control fc-datepicker"  placeholder="DD.MM.YYYY">
							</div>
							<div class="form-group">
								<label class="form-label">Город</label>
								<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
									<option label="Выберите город"></option>
									<option value="1">Белгород</option>
									<option value="2">Воронеж</option>
									<option value="3">Краснодар</option>
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">Точка</label>
								<select class="form-control select2-show-search custom-select" data-placeholder="Выберите город">
									<option label="Выберите город"></option>
									<option value="1">Аквапарк</option>
									<option value="2">Зоопарк</option>
									<option value="3">Сити-Молл</option>
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
		<script src="{{URL::asset('assets/js/goods/good.js')}}"></script>

@endsection
