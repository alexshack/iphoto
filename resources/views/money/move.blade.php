@extends('layouts.app')

@section('styles')
    <!-- INTERNAL Bootstrap DatePicker css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('content')
    @isset($move)
    @livewire('money.moves.edit', ['moveData' => $move])
    @else
        {{--<x-money.move.single/>--}}
        @livewire('money.moves.create')
    @endif
@endsection('content')

@section('scripts')
    <!-- INTERNAL  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
    <!-- INTERNAL Index js-->
    <script src="{{URL::asset('assets/js/money/move.js')}}"></script>
@endsection
