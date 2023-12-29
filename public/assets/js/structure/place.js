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

    $('#addPlaceCalc').click(function() {
        var place_id = $('#calc-add input[name=\'place_id\']').val();
        var start_date = $('#calc-add input[name=\'start_date\']').val();
        var end_date = $('#calc-add input[name=\'end_date\']').val();
        var calcs_type_id = $('#calc-add select[name=\'calcs_type_id\']').val();

        var errorContainer = document.getElementById('errors-add');
        errorContainer.innerHTML = '';

        $.ajax({
            url: createUrl,
            type: 'POST',
            data: {
                place_id: place_id,
                start_date: start_date,
                end_date: end_date,
                calcs_type_id: calcs_type_id,
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

    $('#updatePlaceCalc').click(function () {
        var place_id = $('#calc-edit input[name=\'place_id\']').val();
        var start_date = $('#calc-edit input[name=\'start_date\']').val();
        var end_date = $('#calc-edit input[name=\'end_date\']').val();
        var calcs_type_id = $('#calc-edit select[name=\'calcs_type_id\']').val();
        var url = $('#calc-edit input[name=\'url\']').val()

        var errorContainer = document.getElementById('errors-edit');
        errorContainer.innerHTML = '';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                place_id: place_id,
                start_date: start_date,
                end_date: end_date,
                calcs_type_id: calcs_type_id,
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

    document.editPlaceCalc = function (url, place_id, start_date, end_date, calcs_type_id) {
        $('#calc-edit input[name=\'place_id\']').val(place_id);
        $('#calc-edit input[name=\'start_date\']').val(start_date);
        $('#calc-edit input[name=\'end_date\']').val(end_date);
        $('#calc-edit select[name=\'calcs_type_id\']').val(calcs_type_id);
        $('#calc-edit input[name=\'url\']').val(url);
        $('.custom-select').trigger('change.select2');
        $('#calc-edit').modal();
    }

});
