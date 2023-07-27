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
								<h4 class="page-title">{{ $text['title'] ?? null }}<span class="font-weight-normal text-muted ml-2">Структура</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
									<div class="btn-list">
										<a href="{{ route('admin.structure.'.$text['role'].'.create') }}" class="btn btn-primary mr-3">{{ $text['add_button'] ?? null }}</a>
									</div>
								</div>
							</div>
						</div>
						<!--End Page header-->

						<!-- Row-->
						<div class="row">
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-7">
												<div class="mt-0 text-left"> <span class="font-weight-semibold">{{ $text['count'] ?? null }}</span>
													<h3 class="mb-0 mt-1 text-success">{{ $counts['all'] }}</h3>
												</div>
											</div>
											<div class="col-5">
												<div class="icon1 bg-success-transparent my-auto  float-right"> <i class="las la-users"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-7">
												<div class="mt-0 text-left"> <span class="font-weight-semibold">Мужчины</span>
													<h3 class="mb-0 mt-1 text-primary">{{ $counts['male'] }}</h3>
												</div>
											</div>
											<div class="col-5">
												<div class="icon1 bg-primary-transparent my-auto  float-right"> <i class="las la-male"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-7">
												<div class="mt-0 text-left"> <span class="font-weight-semibold">Женщины</span>
												<h3 class="mb-0 mt-1 text-secondary">{{ $counts['female'] }}</h3> </div>
											</div>
											<div class="col-5">
												<div class="icon1 bg-secondary-transparent my-auto  float-right"> <i class="las la-female"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-7">
												<div class="mt-0 text-left"> <span class="font-weight-semibold">{{ $text['count_new'] ?? null }}</span>
												<h3 class="mb-0 mt-1 text-danger">15</h3> </div>
											</div>
											<div class="col-5">
												<div class="icon1 bg-danger-transparent my-auto  float-right"> <i class="las la-user-friends"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->

						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">{{ $text['list_title'] ?? null }}</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="managers-list">
												<thead>
													<tr>
														<th class="border-bottom-0 w-5">ID</th>
														<th class="border-bottom-0">{{ $text['role_column'] ?? null }}</th>
														<th class="border-bottom-0">Город</th>
														<th class="border-bottom-0">Возраст</th>
														<th class="border-bottom-0">Email</th>
														<th class="border-bottom-0">Дата приема</th>
														<th class="border-bottom-0">Статус</th>
														<th class="border-bottom-0">Действия</th>
													</tr>
												</thead>
												<tbody>
                                                    @php
                                                        /**
                                                         * @var \App\Models\User $item
                                                         * @
                                                         */
                                                        use App\Contracts\UserContract;
                                                        use App\Contracts\UserPersonalDataContract;
                                                        use App\Contracts\UserWorkDataContract;
                                                        use App\Contracts\Structure\CityContract;
                                                    @endphp
                                                    @foreach($list as $item)
                                                        <tr>
                                                            <td>#{{ $item->{ \App\Contracts\UserContract::FIELD_ID } }}</td>
                                                            <td data-search="{{ $item->getFullName() }} {{ $item->getPersonalData()->{ UserPersonalDataContract::FIELD_PHONE } }}" data-order="Сотрудников"><!-- Имя фамилия, телефон --><!-- Фамилия -->
                                                                <div class="d-flex">
                                                                    <span class="avatar avatar-md brround mr-3" style="background-image: url({{$item->{ UserContract::FIELD_PHOTO }  ?? URL::asset('assets/images/users/1.jpg')}})"></span>
                                                                    <div class="mr-3 mt-0 mt-sm-1 d-block">
                                                                        <h6 class="mb-1 fs-14">
                                                                            <a href="{{ route('admin.structure.'.$text['role'].'.edit', ['id' => $item->{ UserContract::FIELD_ID } ]) }}">{{ $item->getFullName() }}</a>
                                                                        </h6>
                                                                        <p class="text-muted mb-0 fs-12"><a href="tel:+{{ $item->getPersonalData()->{ UserPersonalDataContract::FIELD_PHONE } }}">{{ $item->getPersonalData()->{ UserPersonalDataContract::FIELD_PHONE } }}</a></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td data-order="{{ $item->getWorkData()->city->{ CityContract::FIELD_NAME } }}"><a href="{{url('structure/cities/0')}}">{{ $item->getWorkData()->city->{ CityContract::FIELD_NAME } }}</a></td>

                                                            <td>{{ $item->age }}</td>
                                                            <td>{{ $item->getPersonalData()->{ UserPersonalDataContract::FIELD_EMAIL } ?? '-' }}</td>
                                                            <td>{{ $item->getWorkData()->{ UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT } ?? '-' }}</td>
                                                            <td>
                                                                @php
                                                                    $status = $item->getWorkData()->{ UserWorkDataContract::FIELD_STATUS };
                                                                @endphp
                                                                <span class="badge {{ UserWorkDataContract::STATUS_CLASS_LIST[ $status ] ?? 'badge-success' }}">{{ UserWorkDataContract::STATUS_LIST[$status] ?? null }}</span>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.structure.'.$text['role'].'.edit', ['id' => $item->{ UserContract::FIELD_ID } ]) }}">
                                                                    <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
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
		<script src="{{URL::asset('assets/js/structure/managers.js')}}"></script>

@endsection
