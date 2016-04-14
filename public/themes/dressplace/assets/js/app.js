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

	productEqualHeight();

	//Sticky footer
	stickyFooter();
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

function productEqualHeight() {
	setTimeout(function () {
		var max_height = 0,
			max_img_height = 0,
			title = $('.product-title');
// 			img = $('.mid-pop .pro-img');

		if (title.length > 0) {
			title.each(function () {
				if (max_height < $(this).height()) {
					max_height = $(this).height();
				}
			});

			title.each(function () {
				$(this).css('min-height', max_height);
			});
		}

// 		if (img.length > 0) {
// 			img.each(function () {
// 				if (max_img_height < $(this).height()) {
// 					max_img_height = $(this).height();
// 				}
// 			});
//
// 			img.each(function () {
// 				$(this).css('min-height', max_img_height);
// 			});
// 		}
	}, 500);
}

function stickyFooter() {
	setTimeout(function () {
		var w_height = $(window).height(),
			b_height = $('body').height();
// 		console.log(w_height);

		if (b_height < w_height) {
			$('div.footer').addClass('sticky');
		} else {
			$('div.footer').removeClass('sticky');
		}
	}, 1000);
}

$(window).on("orientationchange", function () {
	stickyFooter();
});

$(window).on('resize', function () {
	stickyFooter();
});