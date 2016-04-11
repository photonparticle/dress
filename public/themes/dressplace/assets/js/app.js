$(document).ready(function () {
	//Init all tooltips
	$('[data-toggle="tooltip"]').tooltip();

	$('.lazy').Lazy({
		                scrollDirection: 'vertical',
		                threshold: 1000,
		                effect: "fadeIn",
		                effectTime: 1000,
		                visibleOnly: true,
		                placeholder: '/themes/dressplace/assets/images/loading.gif',
		                onError: function (element) {
			                console.log('error loading ' + element.data('src'));
		                }
	                });

	//Hide loader
	$('body').removeClass('loading');
	$("div.loadingOverlayInit").remove();
});

$(document).ajaxStart(function () {
	$.LoadingOverlay("show");
});
$(document).ajaxStop(function () {
	$.LoadingOverlay("hide");
});

var $header = $(".header"),
	y_pos = $header.offset().top,
	height = $header.outerHeight();

$(document).scroll(function () {
	var scrollTop = $(this).scrollTop();

	if (scrollTop > y_pos + height) {
		$header.addClass("header-fixed").animate({
			                                         top: 0,
			                                         left: 0,
			                                         right: 0,
		                                         });
	} else if (scrollTop <= y_pos) {
		$header.removeClass("header-fixed").clearQueue().animate({
			                                                         top: "-48px"
		                                                         }, 0);
	}
});