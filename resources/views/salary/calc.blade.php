@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')
    @isset($calc)
        @livewire('salary.calc.edit', compact('calc'))
    @else
        @livewire('salary.calc.create')
    @endif
@endsection('content')

@section('modals')


@endsection('modals')

@section('scripts')


		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<script src="{{URL::asset('assets/js/select2.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/salary/calc.js')}}"></script>

@endsection
