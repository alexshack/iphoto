$(function (e) {

  //________ Datepicker
  $( ".fc-datepicker" ).datepicker({
    dateFormat: "dd.mm.yy",
    monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
    dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
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

    $('#addCityManager').click(function() {
        var cityId = $('#manager-add input[name=\'city_id\']').val()
        var appointmentDate = $('#manager-add input[name=\'appointment_date\']').val()
        var managerId = $('#manager-add select[name=\'manager_id\']').val()

        var errorContainer = document.getElementById('errors-add');
        errorContainer.innerHTML = '';

        $.ajax({
            url: createUrl,
            type: 'POST',
            data: {
                city_id: cityId,
                appointment_date: appointmentDate,
                manager_id: managerId,
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

    $('#updateCityManager').click(function () {
        var appointmentDate = $('#manager-edit input[name=\'appointment_date\']').val()
        var managerId = $('#manager-edit select[name=\'manager_id\']').val()
        var url = $('#manager-edit input[name=\'url\']').val()

        var errorContainer = document.getElementById('errors-edit');
        errorContainer.innerHTML = '';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                appointment_date: appointmentDate,
                manager_id: managerId,
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

    document.editCityManager = function (url, manager_id, date) {
        $('#manager-edit input[name=\'appointment_date\']').val(date);
        $('#manager-edit select[name=\'manager_id\']').val(manager_id);
        $('#manager-edit input[name=\'url\']').val(url);
        $('.custom-select').trigger('change.select2');
        $('#manager-edit').modal();
    }

});
