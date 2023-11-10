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
								<h4 class="page-title">Начисления<span class="font-weight-normal text-muted ml-2">Учет зарплаты</span></h4>
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
										<a href="{{url('salary/calcs/add')}}"  class="btn btn-primary mr-3">Добавить начисление</a>
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
										<h4 class="card-title">Начисления</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="calcs">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Вид начисления</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Точка</th>
														<th class="border-bottom-0">Сотрудник</th>
														<th class="border-bottom-0">Сумма</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @foreach($calcs as $calc)
                                                        <tr>
                                                            <td>{{ $calc->id }}</td>
                                                            <td data-order="<?php strtotime('24.06.2023') ?>">
                                                                @if($calc->type === 1)
                                                                    {{ $calc->date->format('d.m.Y') }}
                                                                @else
                                                                    <a href="/money/days/0">{{ $calc->date->format('d.m.Y') }}</a>
                                                                @endif

                                                            </td>
                                                            <!-- ссылка на смену ставится, только если вид начисления автоматический. если вид начисления вручную, то просто дата без ссылки -->
                                                            <td>{{ $calc->calcType ? $calc->calcType->name : '' }}</td>
                                                            <td data-order="{{ $calc->city ? $calc->city->name : '' }}">
                                                                <a href="admin/structure/cities/{{ $calc->city_id }}">
                                                                    {{ $calc->city ? $calc->city->name : '' }}
                                                                </a>
                                                            </td>
                                                            <td data-order="{{ $calc->place ? $calc->place->name : '' }}">
                                                                <a href="{{ route('admin.structure.places.edit', ['id' => $calc->city_id]) }}">
                                                                    {{ $calc->place ? $calc->place->name : '' }}
                                                                </a>
                                                            </td>
                                                            <td data-order="{{ $calc->user ? $calc->user->getFullName() : '' }}">
                                                                <a href="{{ route('admin.structure.employees.edit', ['id' => $calc->user_id]) }}">
                                                                    {{ $calc->user ? $calc->user->getFullName() : '' }}
                                                                </a>
                                                            </td>
                                                            <td data-order="{{ $calc->amount }}" class="text-right {{ $calc->amount < 0 ? 'text-danger' : '' }}">
                                                                {{ $calc->amount }}₽
                                                            </td>
                                                            <td>
                                                                @if($calc->isEditable)
                                                                    <div class="d-flex">
                                                                        <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.salary.calc.edit', ['id' => $calc->id]) }}">
                                                                            <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                        </a>
                                                                        <form action="" method="DELETE">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить">
                                                                                <i class="feather feather-trash-2"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                <!-- кнопки редактирования и удаления показываются только если вид начисления вручную, не автоматический. И если еще не было закрытия месяца (выдача зп за месяц) -->
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
		<script src="{{URL::asset('assets/js/salary/calcs.js')}}"></script>

@endsection
