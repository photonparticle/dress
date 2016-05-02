(function ($) {
	"use strict";

	/*----------------------------
	 jQuery MeanMenu
	 ------------------------------ */
	jQuery('nav#dropdown').meanmenu();

	/*----------------------------
	 wow js active
	 ------------------------------ */
	new WOW().init();

	/*----------------------------
	 product-curosel active
	 ------------------------------ */
	$(".product-curosel").owlCarousel({
		                                  autoPlay: false,
		                                  slideSpeed: 2000,
		                                  pagination: false,
		                                  navigation: true,
		                                  items: 4,
		                                  /* transitionStyle : "fade", */    /* [This code for animation ] */
		                                  navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                                  itemsDesktop: [1199, 4],
		                                  itemsDesktopSmall: [980, 3],
		                                  itemsTablet: [768, 2],
		                                  itemsMobile: [479, 1],
	                                  });

	/*----------------------------
	 latest-blog-curosel active
	 ------------------------------ */
	$(".latest-blog-curosel").owlCarousel({
		                                      autoPlay: false,
		                                      slideSpeed: 2000,
		                                      pagination: false,
		                                      navigation: true,
		                                      items: 3,
		                                      /* transitionStyle : "fade", */    /* [This code for animation ] */
		                                      navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                                      itemsDesktop: [1199, 3],
		                                      itemsDesktopSmall: [980, 2],
		                                      itemsTablet: [768, 1],
		                                      itemsMobile: [479, 1],
	                                      });

	/*----------------------------
	 brand-carousel active
	 ------------------------------ */
	$(".brand-carousel").owlCarousel({
		                                 autoPlay: false,
		                                 slideSpeed: 2000,
		                                 pagination: false,
		                                 navigation: true,
		                                 items: 6,
		                                 /* transitionStyle : "fade", */    /* [This code for animation ] */
		                                 navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                                 itemsDesktop: [1199, 5],
		                                 itemsDesktopSmall: [980, 4],
		                                 itemsTablet: [768, 2],
		                                 itemsMobile: [479, 1],
	                                 });

	/*----------------------------
	 related-curosel active
	 ------------------------------ */
	$(".related-curosel").owlCarousel({
		                                  autoPlay: false,
		                                  slideSpeed: 2000,
		                                  pagination: false,
		                                  navigation: true,
		                                  items: 4,
		                                  /* transitionStyle : "fade", */    /* [This code for animation ] */
		                                  navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                                  itemsDesktop: [1199, 3],
		                                  itemsDesktopSmall: [980, 3],
		                                  itemsTablet: [768, 2],
		                                  itemsMobile: [479, 1],
	                                  });

	/*----------------------------
	 banner-curosel active
	 ------------------------------ */
	$(".banner-curosel").owlCarousel({
		                                 autoPlay: false,
		                                 slideSpeed: 2000,
		                                 pagination: false,
		                                 navigation: false,
		                                 items: 1,
		                                 itemsDesktop: [1199, 1],
		                                 itemsDesktopSmall: [980, 1],
		                                 itemsTablet: [768, 1],
		                                 itemsMobile: [479, 1],
	                                 });

	/*----------------------------
	 category-curosel active
	 ------------------------------ */
	$(".category-curosel").owlCarousel({
		                                   autoPlay: false,
		                                   slideSpeed: 2000,
		                                   pagination: false,
		                                   navigation: true,
		                                   items: 1,
		                                   navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                                   itemsDesktop: [1199, 1],
		                                   itemsDesktopSmall: [980, 1],
		                                   itemsTablet: [768, 1],
		                                   itemsMobile: [479, 1],
	                                   });

	/*----------------------------
	 category-curosel active
	 ------------------------------ */
	$(".blog-gallery").owlCarousel({
		                               autoPlay: false,
		                               slideSpeed: 2000,
		                               pagination: false,
		                               navigation: true,
		                               items: 1,
		                               navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		                               itemsDesktop: [1199, 1],
		                               itemsDesktopSmall: [980, 1],
		                               itemsTablet: [768, 1],
		                               itemsMobile: [479, 1],
	                               });

	/*---------------------
	 countdown
	 --------------------- */
	$('[data-countdown]').each(function () {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function (event) {
			$this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Дни</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Часа</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>минути</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>секунди</p></span>'));
		});
	});

	/*----------------------------
	 price-slider active
	 ------------------------------ */
	if ($("#slider-range").attr('data-current-min')) {
		var current_min = parseFloat($("#slider-range").attr('data-current-min'));
	} else {
		var current_min = parseFloat($("#slider-range").attr('data-min'));
	}
	if ($("#slider-range").attr('data-current-max')) {
		var current_max = parseFloat($("#slider-range").attr('data-current-max'));
	} else {
		var current_max = parseFloat($("#slider-range").attr('data-max'));
	}
	$("#slider-range").slider({
		                          range: true,
		                          min: parseFloat($("#slider-range").attr('data-min')),
		                          max: parseFloat($("#slider-range").attr('data-max')),
		                          values: [current_min, current_max],
		                          slide: function (event, ui) {
			                          $('.price_slider_amount .min-price').val(ui.values[0]);
			                          $('.price_slider_amount .max-price').val(ui.values[1]);
		                          }
	                          });
	if (current_min) {
		$('.price_slider_amount .min-price').val(parseFloat(current_min));
	} else {
		$('.price_slider_amount .min-price').val(parseFloat($("#slider-range").attr('data-min')));
	}
	if (current_max) {
		$('.price_slider_amount .max-price').val(parseFloat(current_max));
	} else {
		$('.price_slider_amount .max-price').val(parseFloat($("#slider-range").attr('data-max')));
	}

	/*----- cart-plus-minus-button -----*/
	$(".cart-plus-minus").append('<div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>');
	$(".qtybutton").on("click", function () {
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find("input").val(newVal);
	});

	/*-------------------------
	 showlogin toggle function
	 --------------------------*/
	$('#showlogin').on('click', function () {
		$('#checkout-login').slideToggle(900);
	});

	/*-------------------------
	 showcoupon toggle function
	 --------------------------*/
	$('#showcoupon').on('click', function () {
		$('#checkout_coupon').slideToggle(900);
	});

	/*-------------------------
	 Create an account toggle function
	 --------------------------*/
	$('#cbox').on('click', function () {
		$('#cbox_info').slideToggle(900);
	});

	/*-------------------------
	 Create an account toggle function
	 --------------------------*/
	$('#ship-box').on('click', function () {
		$('#ship-box-info').slideToggle(1000);
	});

	/*--------------------------
	 scrollUp active
	 ---------------------------- */
	$.scrollUp({
		           scrollText: '<i class="fa fa-angle-up"></i>',
		           scrollSpeed: 900,
		           animation: 'fade'
	           });

	/*---------------------
	 about-counter
	 --------------------- */
	$('.about-counter').counterUp({
		                              delay: 50,
		                              time: 3000
	                              });

})(jQuery); 