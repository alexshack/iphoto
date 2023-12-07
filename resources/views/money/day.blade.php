@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL File Uploads css-->
        <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />

		<!-- INTERNAL Time picker css -->
		<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

		<!-- INTERNAL Sumoselect css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

@section('content')
    <div id="workshift">
        <WorkShift/>
    </div>
@endsection('content')

@section('scripts')
		<!-- INTERNAL Data tables -->
		{{--<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>--}}
		{{--<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>--}}


		<!-- INTERNAL File uploads js -->
        <script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>

		<!-- INTERNAL Timepicker js -->
		<script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

		<!-- INTERNAL  Datepicker js -->
		<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Sumoselect js-->
		<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/money/day.js')}}"></script>

        <script>
            window.agenda = @js($agenda);
            window.workshiftData = @js($workshift);
            {{--window.workshiftData = @js($workshift);--}}
            window.workshiftTitle = '{{ $workshift->title }}';
            window.workshiftUrls = {
                actions: {
                    close: '{{ route("workshift.close") }}',
                    preview: '{{ route("workshift.preview") }}',
                    reopen: '{{ route("workshift.reopen") }}',
                },
                calcs: {
                    all: '{{ route("workshift.calc.index") }}',
                },
                update: '{{ route("money.days.update", ["id" => $workshift->id]) }}',
                employee: {
                    all: '{{ route("workshift.employee.index") }}',
                    delete: '{{ route("workshift.employee.destroy", ["employee" => "%s"]) }}',
                    positions: '{{ route("workshift.employee.position") }}',
                    show: '{{ route("workshift.employee.show", ["employee" => "%s"]) }}',
                    statuses: '{{ route("workshift.employee.status") }}',
                    store: '{{ route("workshift.employee.store") }}',
                    update: '{{ route("workshift.employee.update", ["employee" => "%s"]) }}',
                },
                expenses: {
                    all: '{{ route("workshift.expense.index") }}',
                    delete: '{{ route("workshift.expense.destroy", ["expense" => "%s"]) }}',
                    show: '{{ route("workshift.expense.show", ["expense" => "%s"]) }}',
                    store: '{{ route("workshift.expense.store") }}',
                    update: '{{ route("workshift.expense.update", ["expense" => "%s"]) }}',
                },
                expenseTypes: '{{ route("workshift.expenseTypes") }}',
                fcds: {
                    all: '{{ route("workshift.fcd.index") }}',
                    delete: '{{ route("workshift.fcd.destroy", ["fcd" => "%s"]) }}',
                    show: '{{ route("workshift.fcd.show", ["fcd" => "%s"]) }}',
                    store: '{{ route("workshift.fcd.store") }}',
                    update: '{{ route("workshift.fcd.update", ["fcd" => "%s"]) }}',
                },
                file: {
                    upload: '{{ route("workshift.file.upload") }}',
                    delete: '{{ route("workshift.file.destroy", ["fileName" => "."]) }}'
                },
                goods: {
                    all: '{{ route("workshift.goods.index") }}',
                    show: '{{ route("workshift.goods.show", ["good" => "%s"]) }}',
                    store: '{{ route("workshift.goods.store") }}',
                    update: '{{ route("workshift.goods.update", ["good" => "%s"]) }}',
                    delete: '{{ route("workshift.goods.destroy", ["good" => "%s"]) }}',
                },
                goodsList: '{{ route("workshift.goods_list") }}',
                moves: {
                    all: '{{ route("workshift.move.index") }}',
                    delete: '{{ route("workshift.move.destroy", ["move" => "%s"]) }}',
                    show: '{{ route("workshift.move.show", ["move" => "%s"]) }}',
                    store: '{{ route("workshift.move.store") }}',
                    update: '{{ route("workshift.move.update", ["move" => "%s"]) }}',
                },
                pays: {
                    all: '{{ route("workshift.pay.index") }}',
                    delete: '{{ route("workshift.pay.destroy", ["pay" => "%s"]) }}',
                    show: '{{ route("workshift.pay.show", ["pay" => "%s"]) }}',
                    store: '{{ route("workshift.pay.store") }}',
                    update: '{{ route("workshift.pay.update", ["pay" => "%s"]) }}',
                },
                ping: '{{ route("workshift.ping") }}',
                placesList: '{{ route("workshift.places_list") }}',
                salesTypes: '{{ route("workshift.salesTypes") }}',
                users: {
                    activeManagers: '{{ route("workshift.users.active_managers") }}',
                    city: '{{ route("workshift.users.city", ["cityID" => $workshift->city_id]) }}',
                },
                visitors: {
                    all: '{{ route("workshift.visitors.all") }}',
                    update: '{{ route("workshift.visitors.update") }}',
                },
                withdraw: {
                    all: '{{ route("workshift.withdraw.index") }}',
                    store: '{{ route("workshift.withdraw.store") }}',
                    update: '{{ route("workshift.withdraw.update", ["withdraw" => "%s"]) }}',
                    delete: '{{ route("workshift.withdraw.destroy", ["withdraw" => "%s"]) }}',
                },
            };
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.4.456/pdf.min.js"></script>
        @vite(['resources/js/workshift.js'])

@endsection
