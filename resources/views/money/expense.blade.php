@extends('layouts.app')

@section('styles')
		<!-- INTERNAL Fancy File Upload css -->
		<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
		<!-- INTERNAL File Uploads css-->
        <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    @isset($expense)
        @livewire('money.expense.edit', compact('expense'))
    @else
        @livewire('money.expense.create')
    @endif
@endsection('content')

@section('modals')

@endsection('modals')

@section('scripts')
		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
		<!-- INTERNAL File-Uploads Js-->
		<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

		<!-- INTERNAL File uploads js -->
        <script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
		<script src="{{URL::asset('assets/js/filupload.js')}}"></script>
		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/expense.js')}}"></script>

@endsection
