$(function (e) {

  $('#employee-positions').DataTable({
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

    $('#addEmployeePosition').click(function() {
        var name = $('#employee-position-add input[name=\'name\']').val()
        var status = $('#employee-position-add select[name=\'status\']').val()

        var errorContainer = document.getElementById('errors-add');
        errorContainer.innerHTML = '';

        $.ajax({
            url: createUrl,
            type: 'POST',
            data: {
                name: name,
                status: status
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

    $('#updateEmployeePosition').click(function () {
        var name = $('#employee-position-edit input[name=\'name\']').val()
        var status = $('#employee-position-edit select[name=\'status\']').val()
        var url = $('#employee-position-edit input[name=\'url\']').val()

        var errorContainer = document.getElementById('errors-edit');
        errorContainer.innerHTML = '';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name: name,
                status: status
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

    document.editEmployeePosition = function (url, name, status) {
        $('#employee-position-edit input[name=\'name\']').val(name);
        $('#employee-position-edit select[name=\'status\']').val(status);
        $('#employee-position-edit input[name=\'url\']').val(url);
        $('.custom-select').trigger('change.select2');
        $('#employee-position-edit').modal();
    }

});
