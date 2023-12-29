<div class="row">
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Города</span>
                            <h3 class="mb-0 mt-1 mb-2">{{ $citiesCount }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon1 my-auto float-right">
                            <a href="{{url('admin/structure/cities')}}">
                                <i class="feather feather-map-pin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Точки</span>
                            <h3 class="mb-0 mt-1 mb-2">{{ $placesCount }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon1 my-auto  float-right">
                            <a href="{{url('admin/structure/place')}}">
                                <i class="feather feather-shopping-cart"></i> </div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Сотрудники</span>
                            <h3 class="mb-0 mt-1 mb-2">{{ $employeesCount }}</h3><!-- количество сотрудников -->
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon1 my-auto  float-right">
                            <a href="{{url('admin/structure/employees')}}">
                                <i class="feather feather-users"></i> </div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи сегодня</span>
                            <h3 class="mb-0 mt-1  mb-2">{{ $salesTotalToday }}₽</h3> </div><!-- сумма данных по кассам за текущий день -->
                    </div>
                    <div class="col-3">
                        <div class="icon1 brround my-auto  float-right">
                            <a href="{{url('money/days')}}">
                                <i class="feather feather-dollar-sign"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи вчера</span>
                            <h3 class="mb-0 mt-1 mb-2">{{ $salesTotalYesterday }}₽</h3> </div><!-- сумма данных по кассам за вчерашний день -->
                    </div>
                    <div class="col-3">
                        <div class="icon1 brround my-auto  float-right">
                            <a href="{{url('money/days')}}">
                                <i class="feather feather-dollar-sign"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Продажи за месяц</span>
                            <h3 class="mb-0 mt-1  mb-2">{{ $salesTotalMonth }}₽</h3> </div><!-- сумма продаж за месяц -->
                    </div>
                    <div class="col-3">
                        <div class="icon1 brround my-auto  float-right">
                            <a href="{{url('money/days')}}">
                                <i class="feather feather-dollar-sign"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
