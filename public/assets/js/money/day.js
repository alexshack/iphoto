$(function (e) {

  let tableLanguage = {
    decimal: ",",
    thousands:" ",
    emptyTable: "Нет данных",
    zeroRecords: "Ничего не найдено",
    paginate: {
      first:      "В начало",
      last:       "В конец",
      next:       "Дальше",
      previous:   "Назад"
    },
    searchPlaceholder: 'Искать...',
    sSearch: '',
    lengthMenu:     "Показать _MENU_ записей",
    info: "Показано _START_ по _END_ из _TOTAL_",
    infoEmpty:      "Всего 0 по 0 из 0",
    infoFiltered:   "(всего _MAX_)",
    
  }

  $('#employees').DataTable({
    "order": [[ 1, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [7] } ],
    language: tableLanguage 
  });

  $('#times').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [2] } ],
    language: tableLanguage 
  });
  $('#all-goods').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [4] } ],
    language: tableLanguage 
  }); 
  $('#person-goods').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [5] } ],
    language: tableLanguage 
  });  
  $('#expences').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [3] } ],
    language: tableLanguage 
  });
  $('#moves').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [3] } ],
    language: tableLanguage 
  });
  $('#pays').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [3] } ],
    language: tableLanguage 
  });
  $('#sales').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [3] } ],
    language: tableLanguage 
  });  
  $('#devices').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [4] } ],
    language: tableLanguage 
  });
  $('#loses').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [2] } ],
    language: tableLanguage 
  }); 
  $('#trashes').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    columnDefs: [ { orderable: false, targets: [2] } ],
    language: tableLanguage 
  });
  $('#calcs').DataTable({
    "order": [[ 0, "asc" ]],
    "info": false,
    "paging": false,
    searching: false,
    language: tableLanguage 
  });       

  $('#tpStartTime').timepicker({
    timeFormat: 'H:i',
    step: 10,
  });
  $('#tpEndTime').timepicker({
    timeFormat: 'H:i',
    step: 10,
  });
  $('#tpTimeTime').timepicker({
    timeFormat: 'H:i',
    step: 10,
  });

  $('.select-good-person').SumoSelect({ 
    okCancelInMulti: true, 
    selectAll: true, 
    placeholder: 'Выберите сотрудника',
    csvDispCount: 10,
    locale: [
      'ОК',
      'Отмена',
      'Выбрать все',
      'Очистить все'
    ]
  });


  $('.dropify').dropify({
    messages: {
      'default': 'Перетащите сюда файл или кликните',
      'replace': 'Перетащите сюда файл или кликните, чтобы заменить',
      'remove': 'Удалить',
      'error': 'Упс, что-то пошло не так.'
    },
    error: {
      'fileSize': 'Размер файла слишком большой (2M max).'
    }
  });

  $.fn.bootstrapdatepicker.dates['en'] = {
      days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
      months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авг", "Сен", "Окт", "Ноя", "Дек"],
      today: "Today",
      clear: "Clear",
      format: "mm/dd/yyyy",
      titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
      weekStart: 0
  };

  $('#datepicker-month').bootstrapdatepicker({
    language: 'ru-RU',
    format: "MM yyyy",
    viewMode: "months",
    minViewMode: "months",
    autoclose: true,
    endDate: '0d'
  });


});
