@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Перемещения ДС<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
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
										</div>
									</div>
									<div class="btn-list">
										<a href="{{url('money/moves/add')}}"  class="btn btn-primary mr-3">Добавить перемещение</a>
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
										<h4 class="card-title">Перемещения за период</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="incomes">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Плательщик</th>
														<th class="border-bottom-0">Получатель</th>
														<th class="border-bottom-0">Сумма</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @foreach($moves as $move)
													<tr>
                                                        <td>{{ $move->id }}</td>
                                                        <td data-order="<?php strtotime( $move->date->format('d.m.Y') ) ?>">
                                                            {{ $move->date->format('d.m.Y') }}
                                                        </td>
                                                        <td data-order="{{ $move->city ? $move->city->name : '' }}">
                                                            <a href="/structure/cities/{{ $move->city_id }}">
                                                                {{ $move->city ? $move->city->name : '' }}
                                                            </a>
                                                        </td>

                                                        {{--payer type--}}
                                                        <td data-order="{{ $move->payer ? $move->payer->name : ''}}">
                                                            <a href="{{ Helper::getEntityEditRoute($move->payer) }}">
                                                                {{ $move->payer ? $move->payer->name : ''}}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $move->recipient ? $move->recipient->name : ''}}">
                                                            <a href="{{ Helper::getEntityEditRoute($move->recipient) }}">
                                                                {{ $move->recipient ? $move->recipient->name : ''}}
                                                            </a>
                                                        </td>
                                                        <td data-order="{{ $move->amount }}" class="text-right">
                                                            {{ $move->amount }}₽
                                                        </td>
                                                        <td>
                                                            @if($move->is_editable)
                                                                <div class="d-flex">
                                                                    <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.money.moves.edit', ['id' => $move->id]) }}" >
                                                                        <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                    </a>
                                                                    <form action="">
                                                                        <a class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить">
                                                                            <i class="feather feather-trash-2"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @endif
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


@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/moves.js')}}"></script>

@endsection
