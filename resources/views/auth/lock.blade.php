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
								<div class="card-body">
									<div class="text-center mb-4">
										<span class="avatar avatar-xxl brround" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></span>
									</div>
									<div class="m-4 d-none d-lg-block text-center">
										<h4>Админ Админов</h4>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
									</div>
									<a href="{{url('admin')}}" class="btn btn-primary btn-block"><i class="fe fe-arrow-right"></i>Разблокировать</a>
									<div class="text-center mt-4">
										<p class="text-dark mb-0"><a class="text-primary ml-1" href="{{url('login')}}">Выйти из аккаунта</a></p>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection('content')

@section('scripts')



@endsection
