$(function(e){

	//________ Datepicker
	$( ".fc-datepicker" ).datepicker({
		dateFormat: "dd.mm.yy",
		monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
		dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ]
	});

	$('.select1').SumoSelect({ 
		okCancelInMulti: true, 
		selectAll: true, 
		placeholder: 'Выберите расходы',
		csvDispCount: 10,
		locale: [
			'ОК',
			'Отмена',
			'Выбрать все',
			'Очистить все'
		]
	});

	//Input file-browser
	$(document).on('change', '.file-browserinput', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
	});// We can watch for our custom `fileselect` event like this
	$(document).ready( function() {
		$('.file-browserinput').on('fileselect', function(event, numFiles, label) {
		var input = $(this).parents('.input-group').find(':text'),
		log = numFiles > 1 ? numFiles + ' files selected' : label;
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
	  });
	});


 });