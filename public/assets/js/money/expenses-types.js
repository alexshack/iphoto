$(function (e) {

  $('#expenses-types').DataTable({
    "order": [[ 2, "asc" ]],
    "info": false,
    "paging": false,
    columnDefs: [ { orderable: false, targets: [3] } ],
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

  $('.select1').SumoSelect({
    okCancelInMulti: true,
    selectAll: true,
    placeholder: 'Выберите тип доступа',
    csvDispCount: 10,
    locale: [
      'ОК',
      'Отмена',
      'Выбрать все',
      'Очистить все'
    ]
  });
  $('.select1')[0].sumo.unSelectAll();

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    function displayErrors(container, errors) {
        var errorContainer = document.getElementById(container);
        errorContainer.innerHTML = '';

        var div = document.createElement('div');
        div.classList.add('alert', 'alert-danger');
        var ul = document.createElement('ul');

        errors.forEach(function(error) {
            var li = document.createElement('li');
            li.textContent = error;
            ul.appendChild(li);
        });

        div.appendChild(ul);
        errorContainer.appendChild(div);

    }

    $('#addExpensesType').click(function() {
        var name = $('#expenses-type-add input[name=\'name\']').val()
        var status = $('#expenses-type-add select[name=\'status\']').val()
        var role_list = $('#expenses-type-add select[name=\'role_list\']').val()

        var errorContainer = document.getElementById('errors-add');
        errorContainer.innerHTML = '';

        $.ajax({
            url: createUrl,
            type: 'POST',
            data: {
                name: name,
                status: status,
                role_list: role_list
            },
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                var errors = JSON.parse(error.responseText);
                var error_list = [];
                Object.keys(errors.errors).map(function (key) {
                    errors.errors[key].map(function (error_message) {
                        error_list.push(error_message)
                    });
                });
                displayErrors('errors-add', error_list);
            }
        });
    });

    $('#updateExpensesType').click(function () {
        var name = $('#expenses-type-edit input[name=\'name\']').val()
        var status = $('#expenses-type-edit select[name=\'status\']').val()
        var role_list = $('#expenses-type-edit select[name=\'role_list\']').val()
        var url = $('#expenses-type-edit input[name=\'url\']').val()

        var errorContainer = document.getElementById('errors-edit');
        errorContainer.innerHTML = '';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name: name,
                status: status,
                role_list: role_list
            },
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                var errors = JSON.parse(error.responseText);
                var error_list = [];
                Object.keys(errors.errors).map(function (key) {
                    errors.errors[key].map(function (error_message) {
                        error_list.push(error_message)
                    });
                });
                displayErrors('errors-edit', error_list);
            }
        });
    });

    document.editExpensesType = function (url, name, status, role_list) {
        $('#expenses-type-edit input[name=\'name\']').val(name);
        $('#expenses-type-edit select[name=\'status\']').val(status);
        $('#expenses-type-edit input[name=\'url\']').val(url);
        //$('#expenses-type-edit select[name=\'role_list\']').val(JSON.parse(role_list));
        var selectedKeys = JSON.parse(role_list);
        var sumoSelect = $('#expenses-type-edit .select1');
        $.each(selectedKeys, function (item, key) {
            sumoSelect[0].sumo.selectItem(key-1);
        });
        $('.custom-select').trigger('change.select2');
        $('#expenses-type-edit').modal();
    }

});
