$(function (e) {

	$('.select-position').SumoSelect({ 
		okCancelInMulti: true, 
		selectAll: true, 
		placeholder: 'Выберите должность',
		csvDispCount: 10,
		locale: [
			'ОК',
			'Отмена',
			'Выбрать все',
			'Очистить все'
		]
	});

});
