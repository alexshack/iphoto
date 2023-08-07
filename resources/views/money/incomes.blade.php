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
								<h4 class="page-title">Поступления ДС<span class="font-weight-normal text-muted ml-2">Финансовый учет</span></h4>
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
                                                <input class="form-control" id="datepicker-month" name="filter" onchange="document.getElementById('filterForm').submit()" placeholder="Выберите период" value="{{ (request()->query('filter')) ? request()->query('filter') : 'Июнь 2023' }}" type="text">
                                            </form>
										</div>
									</div>
									<div class="btn-list">
										<a href="{{ route('admin.money.incomes.create') }}"  class="btn btn-primary mr-3">Добавить поступление</a>
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
										<h4 class="card-title">Поступления</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="incomes">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Дата</th>
														<th class="border-bottom-0">Вид поступления</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Получатель</th>
														<th class="border-bottom-0">Сумма</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                @if(!empty($list))
                                                    @foreach($list as $item)
                                                        <tr>
                                                            <td>#{{ $item->{ \App\Contracts\Money\IncomeContract::FIELD_ID } }}</td>
                                                            <td data-order="{{ strtotime($item->{ \App\Contracts\Money\IncomeContract::FIELD_DATE }) }}">{{ $item->{ \App\Contracts\Money\IncomeContract::FIELD_DATE }->format('d.m.Y') }}</td>
                                                            <td>{{ $item->incomeType->{ \App\Contracts\Money\IncomesTypeContract::FIELD_NAME } }}</td>
                                                            <td data-order="{{ $item->city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}"><a href="{{ route('admin.structure.cities.edit', ['id' => $item->city->{ \App\Contracts\Structure\CityContract::FIELD_ID }]) }}">{{ $item->city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</a></td>
                                                            @if($item->{ \App\Contracts\Money\IncomeContract::FIELD_TYPE } == 1)
                                                                <td data-order="{{ $item->place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } }}">
                                                                    <a href="{{ route('admin.structure.places.edit', ['id' => $item->place->{ \App\Contracts\Structure\PlaceContract::FIELD_ID }]) }}">{{ $item->place->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } }}</a>
                                                                </td>
                                                            @else
                                                                <td data-order="{{ $item->manager->getFullName() }}">
                                                                    <a href="{{ route('admin.structure.managers.edit', ['id' => $item->manager->{ \App\Contracts\UserContract::FIELD_ID }]) }}">{{ $item->manager->getFullName() }}</a>
                                                                </td>
                                                            @endif
                                                            <td data-order="{{ $item->{ \App\Contracts\Money\IncomeContract::FIELD_AMOUNT } }}" class="text-right">{{ $item->{ \App\Contracts\Money\IncomeContract::FIELD_AMOUNT } }}₽</td>
                                                            <td>
                                                                <!-- кнопки редактирования и удаления показываются только если дата поступления в текущем месяце -->
                                                                @if($item->{ \App\Contracts\Money\IncomeContract::FIELD_DATE }->format('Y') == date('Y') && $item->{ \App\Contracts\Money\IncomeContract::FIELD_DATE }->format('m') == date('m'))
                                                                    <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.money.incomes.edit', ['id' => $item->{ \App\Contracts\Money\IncomeContract::FIELD_ID }]) }}" >
                                                                        <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                    </a>
                                                                    <form style="display: inline-block" action="{{ route('admin.money.incomes.destroy', ['id' => $item->{ \App\Contracts\Money\IncomeContract::FIELD_ID }]) }}" method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip" data-original-title="Удалить">
                                                                            <i class="feather feather-trash-2"></i>
                                                                        </button>
                                                                    </form>

                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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
		<script src="{{URL::asset('assets/js/money/incomes.js')}}"></script>

@endsection
