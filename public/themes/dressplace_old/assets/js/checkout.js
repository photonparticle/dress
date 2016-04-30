/*
 *  Provides cart support for all pages based cart-holder container
 * */

function checkout(cart_holder) {
	var form_q_rem = cart_holder.find('.quantity-select .rem');
	var form_q_add = cart_holder.find('.quantity-select .add');
	var update_quantity = cart_holder.find('.update_quantity');
	var remove_item = cart_holder.find('.remove_item');
	var delivery_type = cart_holder.find('button.delivery_type');
	var delivery_type_active = cart_holder.find('button.delivery_type_active');
	var delivery_free_delivery = parseFloat(cart_holder.attr('data-delivery-free-delivery')).toFixed(2);
	var delivery_to_address = parseFloat(cart_holder.attr('data-delivery-to-address')).toFixed(2);
	var delivery_to_office = parseFloat(cart_holder.attr('data-delivery-to-office')).toFixed(2);
	var create_order = cart_holder.find('.create-order');
	var sub_total = parseFloat(cart_holder.find('span.subtotal').text()).toFixed(2);
	var delivery_price = parseFloat(cart_holder.find('span.delivery_price').text()).toFixed(2);
	var total = parseFloat(cart_holder.find('span.total').text()).toFixed(2);
	var delivery_price_holder_obj = cart_holder.find('div.delivery_price');
	var delivery_price_obj = cart_holder.find('span.delivery_price');
	var delivery_price_free_obj = cart_holder.find('.delivery_price_free');
	var total_holder_obj = cart_holder.find('span.total');

	function calculateTotals(cart_holder) {

		if (parseFloat(sub_total) >= parseFloat(delivery_free_delivery)) {
			delivery_price_holder_obj.addClass('hidden');
			delivery_price_free_obj.removeClass('hidden');
		} else {
			delivery_price_holder_obj.removeClass('hidden');
			delivery_price_free_obj.addClass('hidden');

			var val = cart_holder.find('button.delivery_type_active').val();

			if (val == 'to_office') {
				delivery_price = parseFloat(delivery_to_office).toFixed(2);
			} else if (val == 'to_address') {
				delivery_price = parseFloat(delivery_to_address).toFixed(2);
			}

			if (parseFloat(delivery_price) > 0) {
				delivery_price_obj.html(delivery_price);
				var new_total = parseFloat(parseFloat(total) + parseFloat(delivery_price)).toFixed(2);
				total_holder_obj.html(new_total);
			}
		}
	}

	calculateTotals(cart_holder);

	if (delivery_type_active.length > 0) {
		create_order.addClass('active').removeClass('disabled');
		create_order.attr('title', '').attr('data-original-title', '');
	}

	//Delivery type change
	delivery_type.on('click', function (e) {
		if ($(this).hasClass('locked')) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			$(this).blur();

			return;
		}

		var val = $(this).val();
		var btn = $(this);

		if ($(this).val()) {
			$.ajax({
				       type: 'post',
				       url: '/cart/delivery_type',
				       data: {
					       delivery_type: val
				       },
				       success: function (response) {
					       if (typeof response == typeof {} && response['success'] == true) {
						       delivery_type.removeClass('delivery_type_active active').addClass('disabled');
						       btn.removeClass('disabled').addClass('delivery_type_active active').blur();
						       create_order.addClass('active').removeClass('disabled');
						       create_order.attr('title', '').attr('data-original-title', '');
						       calculateTotals(cart_holder);
					       } else {
						       btn.blur();
					       }
				       },
				       error: function () {
					       btn.blur();
				       }
			       });
		}
	});

	create_order.on('click', function (e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		if ($(this).hasClass('disabled')) {
			return;
		} else {
			ajaxStart();
			if ($(this).hasClass('submit')) {
				var val = cart_holder.find('button.delivery_type_active').val();

				$.ajax({
					       type: 'post',
					       url: '/checkout/create',
					       data: {
						       'delivery_type': val,
						       'name': $('#name').val(),
						       'last_name': $('#last_name').val(),
						       'email': $('#email').val(),
						       'phone': $('#phone').val(),
						       'address': $('#address').val(),
						       'city': $('#city').val(),
						       'state': $('#state').val(),
						       'post_code': $('#postcode').val(),
						       'comment': $('#comment').val()
					       },
					       success: function (response) {
						       if (typeof response == typeof {} && response['status'] && response['message']) {
							       if (response['status'] == 'success' && response['id']) {
								       setTimeout(function () {
									       window.location.href = "/checkout/completed";
								       }, 2000);
							       } else {
								       showNotification(response['status'], response['message']);
							       }
						       } else {
							       ajaxStop();
							       showNotification('error', translate('request_not_completed'), translate('contact_support'));
						       }
					       },
					       error: function () {
						       ajaxStop();
						       showNotification('error', translate('request_not_completed'), translate('contact_support'));
					       }
				       });
			} else {
				window.location.href = "/checkout";
			}
		}
	});

	//Quantity remove
	form_q_rem.on('click', function () {
		var form_q_val = $(this).closest('tr').find('.quantity-select .val span');
		var quantity = $(this).attr('data-quantity');
		if (!$(this).hasClass('disabled')) {
			var divUpd = $(form_q_val),
				newVal = parseInt(divUpd.text(), 10) - 1;
			if (newVal >= 1) divUpd.text(newVal);
		}
	});

	//Quantity add
	form_q_add.on('click', function () {
		var form_q_val = $(this).closest('tr').find('.quantity-select .val span');
		var quantity = $(this).attr('data-quantity');
		if (!$(this).hasClass('disabled')) {
			var divUpd = $(form_q_val),
				newVal = parseInt(divUpd.text(), 10) + 1;
			if (quantity > 0) {
				if (newVal <= quantity) divUpd.text(newVal);
			} else {
				if (newVal = 0) divUpd.text(newVal);
			}
		}
	});

	update_quantity.on('click', function () {
		var key = $(this).attr('data-key');
		var quantity = $(this).closest('tr').find('.quantity-select .val span').text();

		if (key && quantity) {
			ajaxStart();
			$.ajax({
				       type: 'post',
				       url: '/cart/update',
				       data: {
					       key: key,
					       quantity: quantity
				       },
				       success: function (response) {
					       if (typeof response == typeof {} && response['success'] == true) {
						       location.reload();
					       }
					       ajaxStop();
				       },
				       error: function () {
					       ajaxStop();
				       }
			       });
		}
	});

	remove_item.on('click', function () {
		var key = $(this).attr('data-key');
		var this_btn = $(this);

		if (key) {
			ajaxStart();
			$.ajax({
				       type: 'post',
				       url: '/cart/remove',
				       data: {
					       key: key
				       },
				       success: function (response) {
					       if (typeof response == typeof {} && response['success'] == true) {
						       this_btn.closest('tr').remove();
						       location.reload();
					       }
					       ajaxStop();
				       },
				       error: function () {
					       ajaxStop();
				       }
			       });
		}
	});
}