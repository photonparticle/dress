var quick_buy_modal = $('#quick_buy_modal');
var item_to_cart = $('#item_to_cart');
var cart_modal = $('#cart');
var my_profile_modal = $('#my-profile');
var my_orders_modal = $('#my-orders');
var my_order = $('#my-order');

$(document).ready(function () {
	//Init all tooltips
	$('[data-toggle="tooltip"]').tooltip();
	cart_drop();

// 	$('.lazy').Lazy({
// 		                scrollDirection: 'vertical',
// 		                threshold: 1000,
// 		                effect: "fadeIn",
// 		                effectTime: 1500,
// 		                visibleOnly: true,
// 		                placeholder: '/themes/dressplace/assets/images/loading.gif',
// 		                onError: function (element) {
// 			                console.log('error loading ' + element.data('src'));
// 		                }
// 	                });

	$('#search').on('click', function () {
		var needable = $('#header_search').val();

		if (needable) {
			window.location.href = "/search/" + needable;
		}
	});

	//Modals

	$('a.quick_buy_trigger').on('click', function (e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		var target = $(this).attr('href') + '?frame=true';
		quick_buy_modal.attr('target', target);
		quick_buy_modal.modal('toggle');
	});

	$('a.cart-preview').on('click', function (e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		var target = $(this).attr('href');
		cart_modal.attr('target', target);
		cart_modal.modal('toggle');
	});

	quick_buy_modal.on('show.bs.modal', function () {
		quick_buy_modal.find('.modal-content').load(quick_buy_modal.attr('target'));
		quick_buy_modal.modal('handleUpdate');
	});

	item_to_cart.on('show.bs.modal', function () {
		item_to_cart.find('.modal-content').load(item_to_cart.attr('target'));
		item_to_cart.modal('handleUpdate');
	});

	quick_buy_modal.on('shown.bs.modal', function () {
		var modal = quick_buy_modal;
		setTimeout(function () {
			var slider = $('.products-flexslider-box');
			var holder = modal;
			initProductSlider(slider);
			validateAddToCart(holder);
			//Init all tooltips
			$('[data-toggle="tooltip"]').tooltip();
			modal.modal('handleUpdate');
		}, 500);
	});

	quick_buy_modal.on('hidden.bs.modal', function () {
		var modal = quick_buy_modal;
		modal.find('.modal-content').html('');
		modal.children().off('click');
		modal.children().unbind('click');
	});

	item_to_cart.on('shown.bs.modal', function () {
		var modal = item_to_cart;
		setTimeout(function () {
			//Init all tooltips
			$('[data-toggle="tooltip"]').tooltip();
			modal.modal('handleUpdate');
		}, 500);
	});

	item_to_cart.on('hidden.bs.modal', function () {
		var modal = item_to_cart;
		modal.find('.modal-content').html('');
		modal.children().off('click');
		modal.children().unbind('click');
	});

	cart_modal.on('show.bs.modal', function () {
		cart_modal.find('.modal-body').load(cart_modal.attr('target'));
		cart_modal.modal('handleUpdate');
	});

	cart_modal.on('shown.bs.modal', function () {
		var modal = cart_modal;
		setTimeout(function () {
			var holder = modal;
			checkout(holder);
			modal.modal('handleUpdate');
			//Init all tooltips
			$('[data-toggle="tooltip"]').tooltip();
		}, 500);
	});

	cart_modal.on('hidden.bs.modal', function () {
		var modal = cart_modal;
		modal.find('.modal-body').html('');
		modal.children().off('click');
		modal.children().unbind('click');
	});

	/* Modals */

	// CENTERED MODALS
	// phase one - store every dialog's height
// 	$('.modal').each(function () {
// 		var t = $(this),
// 			d = t.find('.modal-dialog'),
// 			fadeClass = (t.is('.fade') ? 'fade' : '');
// 		// render dialog
// 		t.removeClass('fade')
// 			.addClass('invisible')
// 			.css('display', 'block');
// 		// hide dialog again
// 		t.css('display', '')
// 			.removeClass('invisible')
// 			.addClass(fadeClass);
// 	});

	// phase two - set margin-top on every dialog show
	$('.modal').on('shown.bs.modal', function () {
		var t = $(this);
		setTimeout(function () {
			var d = t.find('.modal-dialog'),
				dh = d.height(),
				w = $(window).width(),
				h = $(window).height();
			// read and store dialog height
			d.data('height', d.height());
			// if it is desktop & dialog is lower than viewport
			// (set your own values)
			if (w >= 320 && dh < h && dh > 50) {
				d.css('margin-top', Math.round(h - dh) / 2);
			} else {
				d.css('margin-top', '');
			}
		}, 500);
	});

	//After page is rendered

	productEqualHeight();

	//Sticky footer
	stickyHeader();
	stickyFooter();
});
var resizeEnd;

//Window orientation change
$(window).on("orientationchange", function () {
	stickyFooter();

	if (typeof product_slider !== typeof undefined && product_slider.length > 0) {
		productsSliderResize(product_slider);
	}
	if (typeof product_box_slider !== typeof undefined && product_box_slider.length > 0) {
		productsSliderResize(product_box_slider);
	}
});

//Windows resize
$(window).resize(function () {
	clearTimeout(resizeEnd);
	resizeEnd = setTimeout(function () {
		stickyFooter();

		if (typeof product_slider !== typeof undefined && product_slider.length > 0) {
			productsSliderResize(product_slider);
		}

		if (typeof product_box_slider !== typeof undefined && product_box_slider.length > 0) {
			productsSliderResize(product_box_slider);
		}

		clearTimeout(resizeEnd);
	}, 500);
});

function stickyHeader() {
	var $header = $("header");

	if ($header.length > 0) {
		var y_pos = $header.offset().top,
			height = $header.outerHeight();

		$(document).scroll(function () {
			var scrollTop = $(this).scrollTop();

			if (scrollTop > 1) {
				$header.addClass("header-fixed").animate({
					                                         top: 0,
					                                         left: 0,
					                                         right: 0,
				                                         });
			} else if (scrollTop < 1) {
				$header.removeClass("header-fixed").addClass('no-animate').clearQueue().animate({
					                                                                                top: 0
				                                                                                }, 0);
			}
		});
	}
}

function initProductSlider(slider) {
	if (slider.length > 0) {
		slider.flexslider({
			                  animation: "slide",
			                  controlNav: "thumbnails",
			                  easing: 'swing',
			                  animationSpeed: 1000,
			                  touch: true,
			                  arrows: false,
			                  keyboard: false,
			                  animationLoop: false,
			                  slideshow: false,
			                  initDelay: 0,
			                  mousewheel: false,
			                  smoothHeight: true,
			                  start: function () {
				                  slider.find('.flex-direction-nav').css({visibility: 'hidden'});
				                  var width = slider.find('.thumb-image').width();
				                  slider.find('.product-image').eq(0).addClass('zoom').css('width', width).css('height', 'auto');
				                  colorbox(0, slider);

				                  setTimeout(function () {
					                  createImageZoom(slider);
				                  }, 500);
			                  },
			                  after: function (slides) {
				                  var width = $('.thumb-image').width();
				                  slider.find('.product-image').removeClass('zoom');
				                  slider.find('.product-image').eq(slides.animatingTo).addClass('zoom').css('width', width).css('height', 'auto');
				                  colorbox(slides.animatingTo, slider);

				                  setTimeout(function () {
					                  createImageZoom(slider);
				                  }, 500);
			                  }
		                  });
	}
}

//Zoom
function createImageZoom(slider) {
	var window_width = $(window).width();
	var slider_class = slider.attr('class');

	if (window_width >= 768 && slider_class != ' products-flexslider-box ') {
		$('.zoomContainer').each(function () {
			$(this).remove();
		});

		slider.find('.zoom').elevateZoom({
			                                 zoomType: "inner",
			                                 cursor: 'crosshair',
			                                 imageCrossfade: true,
			                                 easing: true,
			                                 easingDuration: 500,
			                                 responsive: true
		                                 });
	}
}

//Full screen zoom - Colorbox
function colorbox(el, slider) {
	if (!el) {
		el = 0;
	}

	slider.find(".product-image-zoom").eq(el).colorbox({
		                                                   transition: 'elastic',
		                                                   speed: 1000,
		                                                   scrolling: false,
		                                                   opacity: 0.9,
		                                                   fadeOut: 500,
		                                                   maxWidth: '100%',
		                                                   maxHeight: '100%'
	                                                   });
}

function productsSliderResize(target) {
	if (target.length > 0) {
		target.data('flexslider').resize();
	}
}

function productEqualHeight() {
	setTimeout(function () {
		var max_height = 0,
			title = $('.single-product .product-info');

		if (title.length > 0) {
			title.each(function () {
				if (max_height < $(this).outerHeight()) {
					max_height = $(this).outerHeight();
				}
			});

			title.css('min-height', max_height);
		}
	}, 500);
}

function validateAddToCart(product_holder) {
	var price = 0;
	var main_price = product_holder.find('.single').attr('data-price');
	var quantity = 0;
	var size = '';
	var main_discounted_price = product_holder.find('.single').attr('data-discount-price');
	var main_discount = product_holder.find('.single').attr('data-discount-percentage');
	var discounted_price = 0;
	var discount = 0;
	var active_discount = product_holder.find('.single').attr('data-active-discount');
	var form_discount_price_item = '.price_single .item_old_price span',
		form_discount_item = '.price_single .item_discount span span',
		form_price_item = '.price_single .item_price span',
		form_sizes_btn = '.sizes button',
		form_sizes_active = '.sizes button.active',
		form_sizes_btn_disabled = '.sizes button.disabled',
		form_confirm = 'a.add-to-cart',
		form_q_rem = '.quantity div.rem',
		form_q_add = '.quantity div.add',
		form_q_val = '.quantity div.val span',
		form_title_disabled = $(form_confirm).attr('data-title-disabled');
	//Form

	var form_disabled = function () {
		product_holder.find(form_confirm).addClass('disabled').attr('title', form_title_disabled);
		product_holder.find(form_q_rem).addClass('disabled').attr('title', form_title_disabled);
		product_holder.find(form_q_add).addClass('disabled').attr('title', form_title_disabled);
	};
	var form_enabled = function () {
		product_holder.find(form_confirm).removeClass('disabled').attr('title', '').attr('data-original-title', '');
		product_holder.find(form_q_rem).removeClass('disabled').attr('title', '').attr('data-original-title', '');
		product_holder.find(form_q_add).removeClass('disabled').attr('title', '').attr('data-original-title', '');
	};

	product_holder.find(form_sizes_btn).click(function () {
		if ($(this).hasClass('active')) {
			product_holder.find(form_sizes_btn).addClass('disabled').removeClass('active');
			$(this).removeClass('active').addClass('disabled').blur();
		} else {
			product_holder.find(form_sizes_btn).addClass('disabled').removeClass('active');
			$(this).removeClass('disabled').addClass('active');
		}

		//If no size
		if (product_holder.find(form_sizes_btn_disabled).length == product_holder.find(form_sizes_btn).length) {
			product_holder.find(form_sizes_btn).removeClass('disabled');
			discount = main_discount;
			price = main_price;
			discounted_price = main_discounted_price;
			var disabled = true;

			form_disabled();
		} else {
			//If size
			size = product_holder.find(form_sizes_active).attr('value');
			price = product_holder.find(form_sizes_active).attr('data-price');
			quantity = product_holder.find(form_sizes_active).attr('data-quantity');

			if (active_discount == 'true' || active_discount == 1) {
				discounted_price = product_holder.find(form_sizes_active).attr('data-discount');
			}
			if (parseFloat(price) > 0) {
				if (isInt(price)) {
					price = parseInt(price);
				} else {
					price = parseFloat(price).toFixed(2);
				}
			} else {
				price = main_price;
			}

			if (active_discount == 'true' || active_discount == 1) {
				if (parseFloat(discounted_price) > 0) {
					if (isInt(discounted_price)) {
						discounted_price = parseInt(discounted_price);
					} else {
						discounted_price = parseFloat(discounted_price).toFixed(2);
					}
				} else {
					discounted_price = main_discounted_price;
				}

				if (parseFloat(price) > 0 && parseFloat(discounted_price) > 0) {
					discount = parseFloat((price - discounted_price) / price * 100).toFixed();
				} else {
					discount = main_discount;
				}
			}

			form_enabled();
		}

		//Visual
		product_holder.find(form_price_item).html(price);

		if (active_discount == 'true' || active_discount == 1 && parseFloat(discounted_price) > 0) {
			product_holder.find(form_price_item).html(discounted_price);
			product_holder.find(form_discount_price_item).html(price);
			product_holder.find(form_discount_item).html(discount);
			product_holder.find(form_discount_price_item).closest('em').removeClass('hidden');
			product_holder.find(form_discount_item).closest('em').removeClass('hidden');
		} else {
			product_holder.find(form_discount_price_item).closest('em').addClass('hidden');
			product_holder.find(form_discount_item).closest('em').addClass('hidden');
		}

	});

	//Quantity remove
	product_holder.find(form_q_rem).on('click', function () {
		if (!$(this).hasClass('disabled')) {
			var divUpd = product_holder.find(form_q_val),
				newVal = parseInt(divUpd.text(), 10) - 1;
			if (newVal >= 1) divUpd.text(newVal);
		}
	});

	//Quantity add
	product_holder.find(form_q_add).on('click', function () {
		if (!$(this).hasClass('disabled')) {
			var divUpd = product_holder.find(form_q_val),
				newVal = parseInt(divUpd.text(), 10) + 1;
			if (quantity > 0) {
				if (newVal <= quantity) divUpd.text(newVal);
			} else {
				if (newVal = 0) divUpd.text(newVal);
			}
		}
	});

	//Add to cart button
	product_holder.find(form_confirm).on('click', function () {
		if (!$(this).hasClass('disabled')) {
			var data = {};
			data['product_id'] = product_holder.find('.single').attr('data-product-id');
			data['size'] = size;
			data['price'] = price;
			data['quantity'] = product_holder.find(form_q_val).text();

			if (active_discount == 'true' || active_discount == 1) {
				data['active_discount'] = 'true';
				data['discount_price'] = discounted_price;
				data['discount'] = discount;
			}

			if (data) {
				$.ajax({
					       type: 'post',
					       url: '/cart/add',
					       data: data,
					       success: function (response) {
						       if (typeof response == typeof {} && response['success'] == true) {

							       if (response['cart_items']) {
								       $('.cart-toggler .count span').html(response['cart_items']);
							       }
							       if (response['cart_total']) {
								       $('.cart-toggler .cart_data span').html(response['cart_total']);
							       }

							       quick_buy_modal.modal('hide');
							       var target = '/cart/added/' + data['product_id'] + '-' + data['size'];
							       item_to_cart.attr('target', target);
							       item_to_cart.modal('toggle');
							       cart_drop();
						       }
					       }
				       });
			}
		}
	});

	//Disable form on load
	form_disabled();
}

function cart_drop() {
	$.ajax({
		       type: 'get',
		       url: '/cart/drop',
		       success: function (response) {
			       if (response) {
				       $('ul.cart-items-drop').html(response);
			       }
		       }
	       });
}

function initBreadCrumbs() {
	$('ol.breadcrumb li').removeClass('active');

	if ($('ol.breadcrumb').length > 0) {
		$('ol.breadcrumb').each(function () {
			$('ol.breadcrumb li:last-child').addClass('active');
		});
	}
}

function stickyFooter() {
// 	setTimeout(function () {
// 		var w_height = $(window).height(),
// 			b_height = $('body').height(),
// 			f_offset = $('footer').outer;
//
// 		if ($('footer').hasClass('sticky')) {
// 			b_height = parseFloat(b_height) + parseFloat($('footer').outerHeight());
// 		}
//
// 		if (w_height > (b_height - f_offset)) {
// 			$('footer').addClass('sticky');
// 		} else {
// 			$('footer').removeClass('sticky');
// 		}
// 	}, 500);
}

function isInt(n) {
	return n % 1 === 0;
}

//Notification
function showNotification(theme, title, text, sticky) {
	var settings = [];

	if (theme == 'success') {
		settings['theme'] = 'lime';
	} else if (theme == 'error') {
		settings['theme'] = 'ruby';
	} else if (theme == 'warning') {
		settings['theme'] = 'tangerine';
	} else if (theme == 'notification') {
		settings['theme'] = 'teal';
	} else {
		//Default
		settings['theme'] = 'amethyst';
	}

	if (sticky == true) {
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

//AJAX prefiller
$.ajaxPrefilter(function (options) {
	if (!options.beforeSend) {
		options.beforeSend = function (xhr) {
			xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		}
	}
});