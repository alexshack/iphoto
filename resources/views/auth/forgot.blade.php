@extends('layouts.auth')

@section('styles')

@endsection

@section('content')

		<div class="page login-bg1">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-md-5 p-md-0">
							<div class="card p-5">
								<div class="pl-4 pt-4 pb-2">
									<a class="header-brand" href="{{url('login')}}">
										<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img custom-logo" alt="Dayonelogo">
										<img src="{{URL::asset('assets/images/brand/logo-white.png')}}" class="header-brand-img custom-logo-dark" alt="Dayonelogo">
									</a>
								</div>
								<div class="p-5 pt-0">
									<h1 class="mb-2">Сброс пароля</h1>
									<p class="text-muted">Укажите email, на который зарегистрирован ваш аккаунт</p>
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
								<form class="card-body pt-3" id="forgot" name="forgot" method="post" action="{{ route('auth.send') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="form-label">Введите E-Mail</label>
										<input class="form-control" placeholder="Email" name="email" type="email">
									</div>
									<div class="submit">
										<button class="btn btn-primary btn-block">Восстановить</button>
									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0">Забыли свой email? Пишите администратору</p>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection('content')

@section('scripts')

@endsection
