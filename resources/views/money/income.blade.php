@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
        @livewireStyles
@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">{{ (isset($income)) ? '#' . $income->{ \App\Contracts\Money\IncomeContract::FIELD_ID } . ' от ' . $income->{ \App\Contracts\Money\IncomeContract::FIELD_DATE }->format('d.m.Y') : '' }}<a href="{{ route('admin.money.incomes.index') }}" class="font-weight-normal text-muted ml-2">Поступления ДС</a></h4>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row calcs-type">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header  border-0">
										<h4 class="card-title">Данные поступления</h4>
									</div>
									<div class="card-body">
                                        @if(isset($income))
                                            <livewire:money.income-form :income="$income"></livewire:money.income-form>
                                        @else
                                            <livewire:money.income-form></livewire:money.income-form>
                                        @endif
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')


@endsection('modals')

@section('scripts')

        @livewireScripts
        @stack('scripts')
		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/income.js')}}"></script>

@endsection
