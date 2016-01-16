function showNotification(theme, title, text, sticky) {
	var settings = [];

	if(theme == 'success') {
		settings['theme'] = 'lime';
	} else if(theme == 'error') {
		settings['theme'] = 'ruby';
	} else if(theme == 'warning') {
		settings['theme'] = 'tangerine';
	} else if(theme == 'notification') {
		settings['theme'] = 'teal';
	} else {
		//Default
		settings['theme'] = 'amethyst';
	}

	if(sticky == true) {
		settings['sticky'] = true;
	} else {
		settings['sticky'] = false;
	}

	var params = {
		theme: settings['theme'],
		sticky: settings['sticky'],
		horizontalEdge: 'right',
		verticalEdge: 'top',
		life: 10000
	};

	if ($.trim(title) != '') {
		params.heading = $.trim(title);
	}

	$.notific8('zindex', 99999);
	$.notific8($.trim(text), params);
}