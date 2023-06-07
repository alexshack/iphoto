						<!--app header-->
						<div class="app-header header">
							<div class="container-fluid">
								<div class="d-flex">
									<a class="header-brand" href="{{url('index')}} ">
										<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
										<img src="{{URL::asset('assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
										<img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
										<img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
									</a>
									<div class="app-sidebar__toggle" data-toggle="sidebar">
										<a class="open-toggle" href="#">
											<i class="feather feather-menu"></i>
										</a>
										<a class="close-toggle" href="#">
											<i class="feather feather-x"></i>
										</a>
									</div>

									<div class="d-flex order-lg-2 my-auto ml-auto">

										<div class="dropdown header-fullscreen">
											<a class="nav-link icon full-screen-link">
												<i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
												<i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
											</a>
										</div>

										<div class="dropdown profile-dropdown">
											<a href="#" class="nav-link pr-1 pl-0 leading-none" data-toggle="dropdown">
												<span>
													<img src="{{URL::asset('assets/images/users/16.jpg')}}" alt="img" class="avatar avatar-md bradius">
												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
												<a class="dropdown-item d-flex" href="#">
													<i class="feather feather-user mr-3 fs-16 my-auto"></i>
													<div class="mt-1">Профиль</div>
												</a>
												<a class="dropdown-item d-flex" href="{{url('change-password')}}">
													<i class="feather feather-edit-2 mr-3 fs-16 my-auto"></i>
													<div class="mt-1">Сменить пароль</div>
												</a>
												<a class="dropdown-item d-flex" href="{{url('lock')}}">
													<i class="feather feather-power mr-3 fs-16 my-auto"></i>
													<div class="mt-1">Заблокировать</div>
												</a>												
												<a class="dropdown-item d-flex" href="{{url('login')}}">
													<i class="feather feather-power mr-3 fs-16 my-auto"></i>
													<div class="mt-1">Выйти</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/app header-->
