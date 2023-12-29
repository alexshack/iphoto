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
								<h4 class="page-title">Виды начислений<span class="font-weight-normal text-muted ml-2">Учет зарплаты</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href="{{ route('admin.salary.calc_type.create') }}"  class="btn btn-primary mr-3">Добавить вид начисления</a>
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
										<h4 class="card-title">Виды начислений</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="calcs-types">
												<thead>
													<tr>
														<th class="border-bottom-0">Название</th>
														<th class="border-bottom-0">Тип начисления</th>
														<th class="border-bottom-0">Тип фильтра</th>
														<th class="border-bottom-0">Фильтр</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @if(isset($list) && !empty($list))
                                                        @foreach($list as $item)
                                                            <tr>
                                                                <td>{{ $item->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_NAME } }}</td>
                                                                <td>{{ $item->getTypeName() }}</td>
                                                                <td>{{ $item->getFilterType() }}</td>
                                                                <td>{{ $item->getFilter() }}</td>
                                                                <td><span class="badge {{ \App\Contracts\Salary\CalcsTypeContract::STATUS_CLASS_LIST[ $item->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_STATUS } ] ?? 'badge-secondary' }}">{{ \App\Contracts\Salary\CalcsTypeContract::STATUS_LIST[$item->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_STATUS }] }}</span></td>
                                                                <td>
                                                                    <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.salary.calc_type.edit', ['id' => $item->{ \App\Contracts\Salary\CalcsTypeContract::FIELD_ID }]) }}" >
                                                                        <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
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
		<script src="{{URL::asset('assets/js/salary/calcs-types.js')}}"></script>

@endsection
