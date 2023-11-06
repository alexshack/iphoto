<div>
    @php
        use App\Contracts\Salary\CalcsTypeContract;
        use App\Contracts\UserSalaryDataContract;
    @endphp
    <button type="button" wire:click.prevent="modalOpen" class="btn btn-primary btn-sm ml-auto">Добавить расчет</button>
    <!--Change salary Modal -->
    <div class="modal fade {{ $modalShow ? 'show' : '' }}"  id="salary-create" tabindex="-1" aria-hidden="{{ $modalShow ? 'false' : 'true' }}" style="{{ $modalShow ? 'display:block;' : '' }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Зарплата</h5>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="calct_type">
                            Тип расчета
                        </label>
                        <select id="calc_type" class="form-control" name="calc_type" wire:model="salaryData.{{ UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE }}">
                            <option value=""></option>
                            @foreach($typesList as $typeKey => $typeItem)
                                <option value="{{ $typeKey }}">{{ $typeItem['label'] }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="form-label">Дата начала действия расчета</label>
                        <input type="text" class="form-control fc-datepicker"  placeholder="ДД.MM.ГГГ"  wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_START_DATE }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ $amountLabel }}</label>
                        <input type="number" class="form-control" placeholder="Значение процента"   wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_AMOUNT }}" step="0.01">
                    </div>
                    @if((int)$salaryData[UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE] === 1)
                    <div class="form-group">
                        <label class="form-label">Расходы точки</label>
                        <select multiple="multiple" class="form-control" wire:model.defer="salaryData.{{ UserSalaryDataContract::FIELD_CUSTOM_DATA }}">
                            @foreach($expenseTypes as $expenseType)
                                <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if($errors->any())
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert">
                                <button  class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                                Необходимо заполнить поля:
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-primary" data-dismiss="modal">Отмена</a>
                    <button type="button" wire:loading.attr="disabled" wire:click.prevent="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Change salary Modal  -->
    <script>
        document.addEventListener('showCreateModal', () => {
            $('#salary-create').modal('show');
        });
        document.addEventListener('hideCreateModal', () => {
            $('#salary-create').modal('hide');
        });
    </script>
</div>
