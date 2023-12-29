$(function (e) {

  //________ Datepicker
  $( ".fc-datepicker" ).datepicker({
    dateFormat: "dd.mm.yy",
    monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
    dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
  });

    $('.tabs-menu li a').click(function () {
        $('input[name=\'type\']').val($(this).attr('data-type'));
    });
});
