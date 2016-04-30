/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Provides array with translations between english and bulgarian languages,
 *		this array here is just storage place, the translate function is located in global.js file
 */

/* Translations provider */

/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Provides multi language support in javascript
 */


/* Translations data */

var translateData = {
	'request_not_completed': 'Невалидна заявка',
	'contact_support': 'Свържете се с нас на office@dressplace.net',
	'title_required': 'Заглавието е задължително',
	'dataTable': {
		"sProcessing":   "Обработка на резултатите...",
		"sLengthMenu":   "Показване на _MENU_ резултата",
		"sZeroRecords":  "Няма намерени резултати",
		"sInfo":         "Показване на резултати от _START_ до _END_ от общо _TOTAL_",
		"sInfoEmpty":    "Показване на резултати от 0 до 0 от общо 0",
		"sInfoFiltered": "(филтрирани от общо _MAX_ резултата)",
		"sInfoPostFix":  "",
		"sSearch":       "Търсене:",
		"sUrl":          "",
		"oPaginate": {
			"sFirst":    "Първа",
			"sPrevious": "Предишна",
			"sNext":     "Следваща",
			"sLast":     "Последна"
		}
	}
};

function translate(key) {
	if(translateData[key] && translateData[key].length > 0) {
		return translateData[key];
	} else {
		return key;
	}
}