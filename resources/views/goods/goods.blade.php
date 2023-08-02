@extends('layouts.app')

@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Bootstrap DatePicker css-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection

@section('content')

						<!--Page header-->
						<div class="page-header d-xl-flex d-block">
							<div class="page-leftheader">
								<h4 class="page-title">Товары<span class="font-weight-normal text-muted ml-2">Товарный учет</span></h4>
							</div>
							<div class="page-rightheader ml-md-auto">
								<div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">

									<div class="btn-list">
										<a href="" data-target="#category-add" data-toggle="modal" class="btn btn-primary mr-3">Добавить категорию</a>
										<a href="{{ route('admin.goods.create') }}"  class="btn btn-primary mr-3">Добавить товар</a>
									</div>
								</div>
							</div>
						</div>
						<!--End Page header-->


						<!-- Row -->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card" id="tabs-style4">
									<div class="card-header border-bottom-0">
										<div class="card-title">
											Товары
										</div>
									</div>
									<div class="card-body">
                                        @if(!empty($categories))
										<div class="row">
											<div class="col-md-3">
												<div class="panel panel-primary tabs-style-4">
													<div class="tab-menu-heading border-0">
														<div class="tabs-menu ">
															<!-- Tabs -->
															<ul class="nav panel-tabs flex-column">
                                                                @foreach($categories as $category)
                                                                    <li>
                                                                        <a href="#tab{{ $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_ID } }}" data-toggle="tab" class="{{ $loop->first ? 'active' : '' }}">{{ $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_NAME } }}</a>
                                                                    </li>
                                                                @endforeach
															</ul>
														</div>
													</div>
												</div>
											</div>
											<div class="tabs-style-4 col-md-9">
												<div class="panel-body ">
													<div class="tab-content">
                                                        @foreach($categories as $category)
                                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab{{ $category->{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_ID } }}">
                                                                <div class="table-responsive">
                                                                    <table class="table goods-table table-vcenter text-nowrap table-bordered border-bottom">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="border-bottom-0">Вид товара</th>
                                                                            <th class="border-bottom-0">Наименование</th>
                                                                            <th class="border-bottom-0">Серийный номер</th>
                                                                            <th class="border-bottom-0">Действия</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if(!empty($category->goods))
                                                                                @foreach($category->goods as $goods)
                                                                                    <tr>
                                                                                        <td>{{ $goods->getTypeName() }}</td>
                                                                                        <td>{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_NAME } }}</td>
                                                                                        <td>{{ $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_SERIAL_NUMBER } }}</td>
                                                                                        <td>
                                                                                            <a class="btn btn-primary btn-icon btn-sm"  href="{{ route('admin.goods.edit', ['id' => $goods->{ \App\Contracts\Goods\GoodsContract::FIELD_ID }]) }}" >
                                                                                                <i class="feather feather-edit" data-toggle="tooltip" data-original-title="Редактировать"></i>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @endforeach
													</div>
												</div>
											</div>
										</div>
                                        @else
                                            Нет категорий
                                        @endif
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-->

@endsection('content')

@section('modals')

			<!--add category Modal -->
			<div class="modal fade"  id="category-add">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Категория</h5>
							<button  class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
                            <div id="errors-add"></div>
							<div class="form-group">
								<label class="form-label">Название</label>
								<input type="text" name="{{ \App\Contracts\Goods\GoodsCategoryContract::FIELD_NAME }}" class="form-control" placeholder="Название категории">
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
							<button class="btn btn-primary" id="addGoodsCategory">Добавить</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End category Modal  -->

@endsection('modals')

@section('scripts')
    <script>
        var createUrl = '{{ route('admin.goods.categories.store') }}';
    </script>

		<!-- INTERNAL Data tables -->
		<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{URL::asset('assets/js/goods/goods.js')}}"></script>

@endsection
