function sidebar_collapse_remember() {
	if (Cookies.get('sidebar-collapsed') == 'true') {
		$('.sidebar-toggler').trigger('click');
	}
}

$(document).load( function () {
	sidebar_collapse_remember();
});

/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Loop through the classes of the element, find all col- classes and remove them
 */

function clearElementSizing(element) {
	var cl = $(element).attr("class").split(" ");
	var newClass =[];
	for(var i=0;i<cl.length;i++){
		remove = cl[i].search(/col-/);
		if(remove)newClass[newClass.length] = cl[i];
	}
	$(element).removeClass().addClass(newClass.join(" "));
}

function setNavigationActive() {
	var url = window.location.pathname,
		urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
	// now grab every link from the navigation

	$('.page-sidebar-menu ul li a').each( function () {
		var url = $(this).attr('href');
		console.log('URL: '+url);

		// and test its normalized href against the url pathname regexp
		if(urlRegExp.test(this.href.replace(/\/$/,''))){
			$(this).closest('li').addClass('active');
		} else {
			$(this).closest('li').removeClass('active');
		}
	});
}

$(document).ready(function () {
	$('.sidebar-toggler').click(function () {
		if(Cookies.get('sidebar-collapsed') == 'true') {
			Cookies.set('sidebar-collapsed', 'false');
		} else {
			Cookies.set('sidebar-collapsed', 'true');
		}
	});

//	setNavigationActive();
});