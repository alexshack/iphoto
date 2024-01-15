@extends('layouts.app')

@php
    use App\Contracts\Structure\CityContract;
@endphp

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
                                <h4 class="page-title">{{ $city->{ CityContract::FIELD_NAME  }  }}<span class="font-weight-normal text-muted ml-2">{{ $total  }}₽</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
								</div>
							</div>
						</div>
						<!--End Page header-->

						<!--Row-->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
                               <!-- x-dashboard.general-statistic -->
							</div>
						</div>

						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Список точек</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="places-list">
												<thead>
													<tr>
														<th class="border-bottom-0">Точка</th>
														<th class="border-bottom-0">Остаток наличных</th>
														<th class="border-bottom-0">Продажи текущая неделя</th>
														<th class="border-bottom-0">Продажи прошлая неделя</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                @if(isset($list) && !empty($list))
                                                    @foreach($list as $item)
                                                        <tr>
                                                            <td>{{ $item->{ \App\Contracts\Structure\PlaceContract::FIELD_NAME } }}</td>
                                                            <td>
                                                                {{ $item->{ \App\Contracts\Structure\PlaceContract::FIELD_CURRENT_BALANCE  }  }}
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><span class="badge {{ \App\Contracts\Structure\PlaceContract::STATUS_CLASS_LIST[ $item->{ \App\Contracts\Structure\PlaceContract::FIELD_STATUS } ] ?? 'badge-secondary' }}">{{ \App\Contracts\Structure\PlaceContract::STATUS_LIST[$item->{ \App\Contracts\Structure\PlaceContract::FIELD_STATUS }] }}</span></td>
                                                            <td>
                                                                <a class="btn btn-primary btn-icon btn-sm" href="{{ route('admin.structure.places.edit', ['id' => $item->{ \App\Contracts\Structure\PlaceContract::FIELD_ID }]) }}">
                                                                    <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-icon btn-sm" href="{{url('structure/places/dashboard/' . $item->{ \App\Contracts\Structure\PlaceContract::FIELD_ID  })}}">
                                                                    <i class="feather feather-eye" data-toggle="tooltip" data-original-title="Дашборд"></i>
                                                                </a>
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

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/places.js')}}"></script>

@endsection