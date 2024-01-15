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
								<h4 class="page-title">Города<span class="font-weight-normal text-muted ml-2">Структура</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href="{{ route('admin.structure.cities.create') }}" class="btn btn-primary mr-3">Добавить город</a>
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
										<h4 class="card-title">Список городов</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="cities-list">
												<thead>
													<tr>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Менеджер</th>
														<th class="border-bottom-0">Кол-во точек</th>
														<th class="border-bottom-0">Кол-во сотрудников</th>
														<th class="border-bottom-0">Дата начала работы</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @foreach($list as $item)
                                                        <tr>
                                                            <td>{{ $item->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</td>
                                                            <td data-search="Менеджеров Менеджер" data-order="Сотрудников"><!-- Имя фамилия --><!-- Фамилия -->
                                                                @if(!empty($item->{ \App\Contracts\Structure\CityContract::FIELD_MANAGER_ID }))
                                                                    <div class="d-flex">
                                                                        <span class="avatar avatar-md brround mr-3" style="background-image: url({{ (!empty($item->getManager()->{ \App\Contracts\UserContract::FIELD_PHOTO })) ? $item->getManager()->{ \App\Contracts\UserContract::FIELD_PHOTO } : URL::asset('assets/images/users/1.jpg')}})"></span>
                                                                        <div class="mr-3 mt-0 mt-sm-1 d-block">
                                                                            <h6 class="mb-1 fs-14">
                                                                                <a href="{{ route('admin.structure.managers.edit', ['id' => $item->{ \App\Contracts\Structure\CityContract::FIELD_MANAGER_ID }]) }}">{{ $item->getManager()->getFullName() }}</a>
                                                                            </h6>
                                                                            <p class="text-muted mb-0 fs-12"><a href="tel:+{{ str_replace(['+', '-', '.', ' ', '(', ')'], ['', '', '', '', '', ''], $item->getManager()->getPersonalData()->{ \App\Contracts\UserPersonalDataContract::FIELD_PHONE }) }}">{{ $item->getManager()->getPersonalData()->{ \App\Contracts\UserPersonalDataContract::FIELD_PHONE } }}</a></p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->places->count() }}</td>
                                                            <td>-</td>
                                                            <td data-order="{{ strtotime($item->{\App\Contracts\Structure\CityContract::FIELD_OPENING_DATE}) }}">{{ $item->{ \App\Contracts\Structure\CityContract::FIELD_OPENING_DATE }->format('d.m.Y') }}</td>
                                                            <td>
                                                                <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.structure.cities.edit', ['id' => $item->{ \App\Contracts\Structure\CityContract::FIELD_ID }]) }}">
                                                                    <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-icon btn-sm"  href="{{url('structure/cities/dashboard/' . $item->{ \App\Contracts\Structure\CityContract::FIELD_ID  })}}">

                                                                    <i class="feather feather-eye" data-toggle="tooltip" data-original-title="Дашборд"></i>
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


@endsection('modals')

@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/cities.js')}}"></script>

@endsection
