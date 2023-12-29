$(function (e) {

  $('#sales-types').DataTable({
    "order": [[ 3, "asc" ]],
    "info": false,
    "paging": false,
    columnDefs: [ { orderable: false, targets: [4] } ],
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

  $('#addSalesType').click(function() {
      var name = $('#sale-type-add input[name=\'name\']').val()
      var recipient = $('#sale-type-add select[name=\'recipient\']').val()
      var value = $('#sale-type-add input[name=\'value\']').val()
      var status = $('#sale-type-add select[name=\'status\']').val()

      var errorContainer = document.getElementById('errors-add');
      errorContainer.innerHTML = '';

      $.ajax({
          url: createUrl,
          type: 'POST',
          data: {
              name: name,
              recipient: recipient,
              value: value,
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

  $('#updateSalesType').click(function () {
      var name = $('#sale-type-edit input[name=\'name\']').val()
      var recipient = $('#sale-type-edit select[name=\'recipient\']').val()
      var value = $('#sale-type-edit input[name=\'value\']').val()
      var status = $('#sale-type-edit select[name=\'status\']').val()
      var url = $('#sale-type-edit input[name=\'url\']').val()

      var errorContainer = document.getElementById('errors-edit');
      errorContainer.innerHTML = '';

      $.ajax({
          url: url,
          type: 'POST',
          data: {
              name: name,
              recipient: recipient,
              value: value,
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

  document.editSalesType = function (url, name, recipient, value, status) {
      $('#sale-type-edit input[name=\'name\']').val(name);
      $('#sale-type-edit select[name=\'recipient\']').val(recipient);
      $('#sale-type-edit input[name=\'value\']').val(value);
      $('#sale-type-edit select[name=\'status\']').val(status);
      $('#sale-type-edit input[name=\'url\']').val(url);
      $('.custom-select').trigger('change.select2');
      $('#sale-type-edit').modal();
  }

});
