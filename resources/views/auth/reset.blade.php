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
									</a>
								</div>
								<div class="p-5 pt-0">
									<h1 class="mb-2">Восстановление пароля</h1>
									<p class="text-muted">Укажите новый пароль</p>
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
								<form class="card-body pt-3" id="reset" name="reset" action="{{ route('auth.update') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
									<div class="form-group">
										<label class="form-label">Пароль</label>
										<input class="form-control" placeholder="Введите пароль" name="password" type="password">
									</div>
									<div class="form-group">
										<label class="form-label">Подтверждение пароля</label>
										<input class="form-control" placeholder="Введите пароль еще раз" name="password_confirmation" type="password">
									</div>
									<div class="submit">
										<button class="btn btn-primary btn-block">Сохранить новый пароль</button>
									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0">Вспомнили свой старый пароль?<a class="text-primary ml-1" href="{{route('auth.show_login_form')}}">Войдите</a></p>
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
