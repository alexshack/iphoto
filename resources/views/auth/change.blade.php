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
									<a class="header-brand" href="{{url('admin')}}">
										<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img custom-logo" alt="Dayonelogo">
									</a>
								</div>
								<div class="p-5 pt-0">
									<h1 class="mb-2">Изменение пароля</h1>
									<p class="text-muted">Укажите свой текущий пароль и введите новый</p>
								</div>
								<form class="card-body pt-3" id="reset" name="reset">
									<div class="form-group">
										<label class="form-label">Текущий пароль</label>
										<input class="form-control" placeholder="Введите текущий пароль" type="password">
									</div>
									<div class="form-group">
										<label class="form-label">Новый пароль</label>
										<input class="form-control" placeholder="Введите новый пароль" type="password">
									</div>
									<div class="form-group">
										<label class="form-label">Подтверждение пароля</label>
										<input class="form-control" placeholder="Введите новый пароль еще раз" type="password">
									</div>
									<div class="submit">
										<a class="btn btn-primary btn-block" href="{{url('login')}}">Сменить пароль</a>
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
