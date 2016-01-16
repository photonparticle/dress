$(document).ready(function () {
	$('.sidebar-toggler').click(function () {
		if(Cookies.get('sidebar-collapsed') == 'true') {
			Cookies.set('sidebar-collapsed', 'false');
		} else {
			Cookies.set('sidebar-collapsed', 'true');
		}
	});
});



function sidebar_collapse_remember() {
	if(Cookies.get('sidebar-collapsed') == 'true') {
		$('body').addClass('page-sidebar-closed');

		$('.page-sidebar-menu-hover-submenu').each(function () {
			$(this).addClass('page-sidebar-menu-closed');
		});
	} else {
		$('body').removeClass('page-sidebar-closed');

		$('.page-sidebar-menu-hover-submenu').each(function () {
			$(this).removeClass('page-sidebar-menu-closed');
		});
	}
}

sidebar_collapse_remember();

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