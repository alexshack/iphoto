$(function (e) {

  $('#incomes-types').DataTable({
    "order": [[ 1, "asc" ]],
    "info": false,
    "paging": false,
    columnDefs: [ { orderable: false, targets: [2] } ],
    language: {
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
  });

});
