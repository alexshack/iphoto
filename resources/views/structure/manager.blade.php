@extends('layouts.app')

@section('styles')
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

    <!-- INTERNAL Bootstrap DatePicker css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection

@section('content')
                        @php
                            use App\Contracts\UserContract;
                            use App\Contracts\UserPersonalDataContract;
                            use App\Contracts\UserWorkDataContract;
                        @endphp

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ (isset($user)) ? $user->getFullName() : '' }}<a href="{{ route('admin.structure.'.$text['role'].'.index') }}" class="font-weight-normal text-muted ml-2">{{ $text['title'] }}</a></h4>
							</div>
						</div>
						<!--End Page header-->

						<!-- Row -->
						<div class="row">
							<div class="col-xl-3 col-md-12 col-lg-12">
								<div class="card box-widget widget-user">
									<div class="card-body text-center">
                                        @if(Route::currentRouteName() == 'admin.structure.'.$text['role'].'.edit')
										<div class="widget-user-image mx-auto text-center">
											<img  class="avatar avatar-xxl brround rounded-circle" alt="img" src="{{ $user->{ \App\Contracts\UserContract::FIELD_PHOTO } ?? URL::asset('assets/images/users/1.jpg')}}">
										</div>
										<div class="pro-user mt-3">
											<h5 class="pro-user-username text-dark mb-1 fs-16">{{ $user->getFullName() ?? null }}</h5>
											<h6 class="pro-user-desc text-muted fs-14">{{ $user->role->{ \App\Contracts\UserRoleContract::FIELD_NAME } }}</h6>
											<h6 class="pro-user-desc fs-14"><a href="{{url('structure/cities/0')}}">{{ $work->city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</a></h6>
                                            @php
                                                $status = $work->{ \App\Contracts\UserWorkDataContract::FIELD_STATUS };
                                            @endphp
											<span class="badge {{ \App\Contracts\UserWorkDataContract::STATUS_CLASS_LIST[ $status ] ?? 'badge-success' }}">{{ \App\Contracts\UserWorkDataContract::STATUS_LIST[ $status ] ?? null }}</span>
										</div>
                                        @endif
									</div>

								</div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif

							</div>
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="tab-menu-heading hremp-tabs p-0 ">
									<div class="tabs-menu1">
										<!-- Tabs -->
										<ul class="nav panel-tabs">
											<li class="ml-4"><a href="#tab1" class="active"  data-toggle="tab">Личные данные</a></li>
											<li><a href="#tab2"  data-toggle="tab">Рабочие данные</a></li>
                                            @if(isset($user) && $user)
                                            <li>
                                                <a href="#calcs" data-toggle="tab">Начисления</a>
                                            </li>
                                            <li>
                                                <a href="#pays" data-toggle="tab">Выплаты</a>
                                            </li>
                                            @endif
										</ul>
									</div>
								</div>
                                @if(Route::currentRouteName() == 'admin.structure.'.$text['role'].'.edit')
                                    <form action="{{ route('admin.structure.'.$text['role'].'.update', ['id' => $user->{ \App\Contracts\UserContract::FIELD_ID }]) }}" method="post" enctype="multipart/form-data">
                                @else
                                    <form action="{{ route('admin.structure.'.$text['role'].'.store') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="user[role_id]" value="{{ $role_id ?? 1 }}">
                                @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="card-body">
                                                    <h4 class="mb-4 font-weight-bold">Основное</h4>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">ФИО</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="text" class="form-control mb-md-0 mb-5" name="personal[last_name]" placeholder="Фамилия" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_LAST_NAME } ?? old('personal.last_name') }}">
                                                                        <span class="text-muted"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text" class="form-control" name="personal[first_name]"  placeholder="Имя" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_FIRST_NAME } ?? old('personal.first_name') }}">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text" class="form-control" name="personal[middle_name]"  placeholder="Отчество" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_MIDDLE_NAME } ?? old('personal.middle_name') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Номер телефона</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="personal[phone]"  placeholder="Phone Number" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_PHONE } ?? old('personal.phone') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Дополнительный номер телефона</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="personal[phone_additional]"  placeholder="Contact Number" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_PHONE_ADDITIONAL } ?? old('personal.phone_additional') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Дата рождения</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control fc-datepicker" name="personal[birthday]" placeholder="DD.MM.YYYY" value="{{ (isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_BIRTHDAY }) ? $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_BIRTHDAY }->format('d.m.Y') : old('personal.birthday')) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Пол</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="custom-controls-stacked d-md-flex">
                                                                    @foreach(\App\Contracts\UserPersonalDataContract::GENDER_LIST as $key => $item)
                                                                        <label class="custom-control custom-radio mr-4">
                                                                            <input type="radio" class="custom-control-input" name="personal[gender]" value="{{ $key }}" @if( (isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_GENDER }) && $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_GENDER } == $key) || (!isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_GENDER }) && $key == 1) ) checked @endif >
                                                                            <span class="custom-control-label">{{ $item }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Семейное положение</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="personal[marital_status]"  class="form-control custom-select select2">
                                                                    @foreach(\App\Contracts\UserPersonalDataContract::MARITAL_STATUS_LIST as $key => $item)
                                                                        <option value="{{ $key }}" @if( (isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_MARITAL_STATUS }) && $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_MARITAL_STATUS } == $key) || (!isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_MARITAL_STATUS }) && $key == 1) ) selected @endif>{{ $item }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Образование</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="personal[education]"  class="form-control custom-select select2">
                                                                    @foreach(\App\Contracts\UserPersonalDataContract::EDUCATION_LIST as $key => $item)
                                                                        <option value="{{ $key }}" @if( (isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_EDUCATION }) && $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_EDUCATION } == $key) || (!isset($personal->{ \App\Contracts\UserPersonalDataContract::FIELD_EDUCATION }) && $key == 1) ) selected @endif>{{ $item }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Email</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"  placeholder="email" name="personal[email]" value="{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_EMAIL } ?? old('personal.email') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Адрес регистрации</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea rows="3" class="form-control" name="personal[registered_address]" placeholder="">{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_REGISTERED_ADDRESS } ?? old('personal.registered_address') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Адрес проживания</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea rows="3" class="form-control" name="personal[address]" placeholder="">{{ $personal->{ \App\Contracts\UserPersonalDataContract::FIELD_ADDRESS } ?? old('personal.address') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-label mb-0 mt-2">Фото сотрудника</div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group file-browser">
                                                                    <input type="text" class="form-control border-right-0 browse-file" placeholder="Загрузите фотографию" readonly>
                                                                    <label class="input-group-append mb-0">
																	<span class="btn ripple btn-primary">
																		Загрузить <input type="file" name="user[photo]" class="file-browserinput"  style="display: none;">
																	</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="mb-5 mt-7 font-weight-bold">Данные аккаунта</h4>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Email</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="user[email]"  placeholder="Email" value="{{ $user->{ \App\Contracts\UserContract::FIELD_EMAIL } ?? old('user.address') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(Route::currentRouteName() == 'admin.structure.'.$text['role'].'.create')
                                                    <!-- Поле Пароль показывать только при создании нового сотрудника -->
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Пароль</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="password" name="user[password]" class="form-control"  placeholder="Пароль" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(isset($user) && $user)
                                            <div id="calcs" class="tab-pane">
                                                @livewire('user.calcs', compact('user'))
                                            </div>
                                            <div id="pays" class="tab-pane">
                                                @livewire('user.pays', compact('user'))
                                            </div>
                                            @endif
                                            <div class="tab-pane" id="tab2">
                                                <div class="card-body">
                                                    <h4 class="mb-4 font-weight-bold">Основное</h4>
                                                    @if(Route::currentRouteName() == 'admin.structure.'.$text['role'].'.edit')
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">ID сотрудника</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" readonly value="#{{ $user->{ \App\Contracts\UserContract::FIELD_ID ?? null } }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Город</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="work[city_id]"  class="form-control custom-select select2">
                                                                    <option value="">Не указан</option>
                                                                    @foreach(\App\Models\City::all() as $city)
                                                                        <option value="{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_ID } }}" @if(isset($work->{ \App\Contracts\UserWorkDataContract::FIELD_CITY_ID }) && $work->{ \App\Contracts\UserWorkDataContract::FIELD_CITY_ID } == $city->{ \App\Contracts\Structure\CityContract::FIELD_ID }) selected @endif>{{ $city->{ \App\Contracts\Structure\CityContract::FIELD_NAME } }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(isset($user) && $user->role->{ \App\Contracts\UserRoleContract::FIELD_SLUG } == 'employee')
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label mb-0 mt-2">Должность</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <select name="work[position_id]"  class="form-control custom-select select2">
                                                                        <option value="">Не указана</option>
                                                                        <!-- Загружаются из таблицы Должности -->
                                                                        @foreach(\App\Models\Salary\Position::all() as $position)
                                                                            <option value="{{ $position->{ \App\Contracts\PositionContract::FIELD_ID } }}" {{ ($position->{ \App\Contracts\PositionContract::FIELD_STATUS } == 2) ? 'disabled' : '' }} {{ ($work->{ \App\Contracts\UserWorkDataContract::FIELD_POSITION_ID } == $position->{ \App\Contracts\PositionContract::FIELD_ID }) ? 'selected' : '' }}>{{ $position->{ \App\Contracts\PositionContract::FIELD_NAME } }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Статус</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="work[status]" class="form-control custom-select select2">
                                                                    @foreach(\App\Contracts\UserWorkDataContract::STATUS_LIST as $key => $item)
                                                                        <option value="{{ $key }}"  @if( (isset($work->{ \App\Contracts\UserWorkDataContract::FIELD_STATUS }) && $work->{ \App\Contracts\UserWorkDataContract::FIELD_STATUS } == $key) || (!isset($work->{ \App\Contracts\UserWorkDataContract::FIELD_STATUS }) && $key == 1) ) selected @endif>{{ $item }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Дата приема на работу</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control fc-datepicker" name="work[date_of_employment]"  placeholder="DD.MM.YYYY" value="{{ (isset($work->{ \App\Contracts\UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT })) ? $work->{ \App\Contracts\UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT }->format('d.m.Y') : old('work.date_of_employment') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Дата увольнения</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control fc-datepicker" name="work[date_of_termination]" placeholder="DD.MM.YYYY" value="{{ (isset($work->{ \App\Contracts\UserWorkDataContract::FIELD_DATE_OF_TERMINATION })) ? $work->{ \App\Contracts\UserWorkDataContract::FIELD_DATE_OF_TERMINATION }->format('d.m.Y') : old('work.date_of_termination') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(isset($user) && $user)
                                                        @livewire('user.salary-data.index', compact('user'))
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="card-footer text-right">
                                                <button class="btn btn-primary">Сохранить изменения</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')

			<!--Change salary Modal -->
			<div class="modal fade"  id="salary-edit">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Зарплата</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="form-label">Дата начала действия расчета</label>
								<input type="text" class="form-control fc-datepicker"  placeholder="ДД.MM.ГГГ">
							</div>
							<div class="form-group">
								<label class="form-label">Процент</label>
								<input type="number" class="form-control" placeholder="Значение процента" value="">
							</div>
							<div class="form-group">
								<label class="form-label">Расходы точки</label>
								<select multiple="multiple" class="select1">
									<!--Список из таблицы Виды расходов -->
								   <option selected value="122">Аренда</option>
								   <option selected value="135">Такси</option>
								   <option value="150">Мороженое</option>
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
			<!-- End Change salary Modal  -->

@endsection('modals')

@section('scripts')


		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/structure/manager.js')}}"></script>

@endsection
