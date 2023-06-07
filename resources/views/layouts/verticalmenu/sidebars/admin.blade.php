				<!--aside open-->
				<aside class="app-sidebar">
					<div class="app-sidebar__logo">
						<a class="header-brand" href="{{url('index')}} ">
							<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
							<img src="{{URL::asset('assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
							<img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
							<img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
						</a>
					</div>
					<div class="app-sidebar3">
						<div class="app-sidebar__user">
							<div class="dropdown user-pro-body text-center">
								<div class="user-pic">
									<!-- фото из профиля -->
									<img src="{{URL::asset('assets/images/users/16.jpg')}}" alt="user-img" class="avatar-xxl rounded-circle mb-1">
								</div>
								<div class="user-info">
									<h5 class=" mb-2">Админ Админов</h5>
									<span class="text-muted app-sidebar__user-name text-sm">Администратор</span>
								</div>
							</div>
						</div>
						<ul class="side-menu">
							<li class="side-item side-item-category mt-4">Компания</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-home sidemenu_icon"></i>
									<span class="side-menu__label">Структура</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li class="sub-slide">
										<a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">Краснодар</span><i class="sub-angle fa fa-angle-right"></i></a>
										<ul class="sub-slide-menu">
											<li><a class="sub-slide-item" href="{{url('admin/place')}} ">ТЦ OZ Mall</a></li>
											<li><a class="sub-slide-item" href="{{url('admin/place')}} ">Галерея</a></li>
										</ul>
									</li>
									<li class="sub-slide">
										<a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">Белгород</span><i class="sub-angle fa fa-angle-right"></i></a>
										<ul class="sub-slide-menu">
											<li><a class="sub-slide-item" href="{{url('admin/place')}} ">Зоопарк</a></li>
											<li><a class="sub-slide-item" href="{{url('admin/place')}} ">Сити Молл</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-server sidemenu_icon"></i>
									<span class="side-menu__label">Справочники</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/cities')}}" class="slide-item">Города</a></li>
									<li><a href="{{url('admin/managers')}}" class="slide-item">Менеджеры</a></li>
									<li><a href="{{url('admin/places')}}" class="slide-item">Точки</a></li>
									<li><a href="{{url('admin/employees')}}" class="slide-item">Сотрудники</a></li>
									<li><a href="{{url('admin/hr')}}" class="slide-item">Рекрутеры</a></li>
								</ul>

							</li>							


							<li class="side-item side-item-category">Финансовый учет</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-layers sidemenu_icon"></i>
									<span class="side-menu__label">Документы</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/days')}} " class="slide-item"> Смены</a></li>
									<li><a href="{{url('admin/money-incomes')}} " class="slide-item"> Поступления ДС</a></li>
									<li><a href="{{url('admin/money-expenses')}} " class="slide-item"> Расходы ДС</a></li>
									<li><a href="{{url('admin/money-moves')}} " class="slide-item"> Перемещение ДС</a></li>
								</ul>
							</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-server sidemenu_icon"></i>
									<span class="side-menu__label">Справочники</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/money-sales-types')}} " class="slide-item"> Виды продаж</a></li>
									<li><a href="{{url('admin/money-incomes-types')}} " class="slide-item"> Виды поступлений</a></li>
									<li><a href="{{url('admin/money-expenses-types')}} " class="slide-item"> Виды расходов</a></li>
									<li><a href="{{url('admin/money-moves-types')}} " class="slide-item"> Виды перемещений</a></li>
								</ul>
							</li>

							<li class="side-item side-item-category">Учет зарплаты</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-layers sidemenu_icon"></i>
									<span class="side-menu__label">Документы</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/salary-calcs')}} " class="slide-item"> Начисления</a></li>
									<li><a href="{{url('admin/salary-pays')}} " class="slide-item"> Выплаты</a></li>
									<li><a href="{{url('admin/salary-bonuses')}} " class="slide-item"> Штрафы и премии</a></li>
								</ul>
							</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-server sidemenu_icon"></i>
									<span class="side-menu__label">Справочники</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/employees-statuses')}} " class="slide-item"> Статусы сотрудников</a></li>
									<li><a href="{{url('admin/employees-roles')}} " class="slide-item"> Роли сотрудников</a></li>
									<li><a href="{{url('admin/employees-salary-calcs-types')}} " class="slide-item"> Начисление ЗП сотрудников</a></li>
									<li><a href="{{url('admin/managers-salary-calcs-types')}} " class="slide-item"> Начисление ЗП менеджеров</a></li>
									<li><a href="{{url('admin/employees-salary-bonuses-types')}} " class="slide-item"> Виды штрафов и премий</a></li>
									<li><a href="{{url('admin/salary-pays-types')}} " class="slide-item"> Типы выплат</a></li>
								</ul>
							</li>							

							<li class="side-item side-item-category">Товарный учет</li>
							<li class="slide">
								<a class="side-menu__item" data-toggle="slide" href="#">
									<i class="feather feather-layers sidemenu_icon"></i>
									<span class="side-menu__label">Документы</span><i class="angle fa fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li><a href="{{url('admin/goods-incomes')}} " class="slide-item"> Поступления</a></li>
									<li><a href="{{url('admin/goods-outs')}} " class="slide-item"> Списания</a></li>
									<li><a href="{{url('admin/goods-moves')}} " class="slide-item"> Перемещения</a></li>
								</ul>
							</li>
							<li class="slide">
								<a class="side-menu__item" href="{{url('admin/goods')}}">
									<i class="feather feather-server sidemenu_icon"></i>
									<span class="side-menu__label">Товары</span>
								</a>
							</li>

						</ul>

					</div>
				</aside>
				<!--aside closed-->
