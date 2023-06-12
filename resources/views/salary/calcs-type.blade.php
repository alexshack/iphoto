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
								<h4 class="page-title">Проценты 17/13<a href="{{url('salary/calcs-types')}}" class="font-weight-normal text-muted ml-2">Виды начислений</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Настройки начисления</h4>
									</div>
									<div class="card-body">
										<form class="form-horizontal">
											<div class="form-group row">
												<label class="form-label col-md-3">Название</label>
												<input type="text" class="form-control col-md-9" placeholder="Введите название">
											</div>									
											<div class="card-pay">
												<label class="form-label">Выберите тип начисления</label>
												<ul class="tabs-menu nav">
													<li class=""><a href="#tab20" class="active" data-toggle="tab">Процент от кассы</a></li>
													<li><a href="#tab21" data-toggle="tab" class="">Процент от товара</a></li>
													<li><a href="#tab22" data-toggle="tab" class="">Оклад</a></li>
													<li><a href="#tab23" data-toggle="tab" class="">Фиксированная смена</a></li>
													<li><a href="#tab24" data-toggle="tab" class="">Ввод вручную</a></li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane active show" id="tab20">
														<form class="form-horizontal">
															<div class="form-group row">
																<label class="form-label col-md-3">Процент, если один сотрудник</label>
																<input type="number" class="form-control col-md-9" placeholder="Введите значение процента">
															</div>
															<div class="form-group row">
																<label class="form-label col-md-3">Процент, если больше одного сотрудника</label>
																<input type="number" class="form-control col-md-9" placeholder="Введите значение процента">
															</div>															
															<div class="form-group row">
																<label class="form-label col-md-3">Процент, если больше одного сотрудника</label>
																<input type="number" class="form-control col-md-9" placeholder="Введите значение процента">
															</div>	
															<button class="btn btn-lg btn-primary" type="submit">Сохранить</button>
														</form>
													</div>
													<div class="tab-pane" id="tab21">
														<p>Paypal is easiest way to pay online</p>
														<p><a href="#" class="btn btn-primary"><i class="fa fa-paypal"></i> Log in my Paypal</a></p>
														<p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p>
													</div>
													<div class="tab-pane" id="tab22">
														<p>Bank account details</p>
														<dl class="card-text">
														  <dt>BANK: </dt>
														  <dd> THE UNION BANK 0456</dd>
														</dl>
														<dl class="card-text">
														  <dt>Accaunt number: </dt>
														  <dd> 67542897653214</dd>
														</dl>
														<dl class="card-text">
														  <dt>IBAN: </dt>
														  <dd>543218769</dd>
														</dl>
														<p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p>
													</div>
												</div>
											</div>
										</form>
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
		<script src="{{URL::asset('assets/js/salary/calcs-type.js')}}"></script>

@endsection
