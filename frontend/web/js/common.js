jQuery(document).ready(function ($) {
    $('.js__sendSearchForm').click(function (e) {
        e.preventDefault();
        $(this).parents('form').submit();
    });

    $('.js__searchForm').submit(function (e) {
        e.preventDefault();
        var q = $('#field-search').val();
        var action = $(this).attr('action');
        if (q && q.length > 1) {
            location = action + '?q=' + q;
        }
    });

    $('.js__searchButton').click(function (e) {
        e.preventDefault();
        var q = $(this).parents('.search__control').find('.js__searchInput').val();
        var action = $('.js__searchForm').attr('action');
        if (q && q.length > 1) {
            location = action + '?q=' + q;
        }
    });

    $('.js__searchInput').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $(this).parents('.search__control').find('.js__searchButton').trigger('click');
        }
    });

    $('.js__changeProductCount').click(function (e) {
        e.preventDefault();
        var key = $(this).attr('data-key');
        $(this).parents('.js__dropdownContainer').find('.js__productCount').attr('data-value', key);
        var val = $(this).attr('data-value');
        $('.js__productCount_view').html(val);
        $(this).parents('ul').removeClass('is-show');
        $(this).parents('.js__dropdownContainer').find('.dropdown-main__header--js-click').removeClass('is-show');
    });

    $('.js__customDropDown').find('input').attr('autocomplete','off');

    $('.js__changeCountry').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        $(this).parents('ul').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('.dropdown-main__header--js-click').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('.js_input_field').val(value);
    });

    $('.js__userLogout').click(function (e) {
        e.preventDefault();
        var request = $.ajax({
            data: {'logout': 1},
            url: '/actions/logout',
            type: 'post',
            dataType: 'html',
        });
        request.done(function () {
            location = '/';
        });
    });
    var url = $('#js__location').val();
    var searh_identy = $('#js__search_identy').val();

    if (searh_identy) {
        url += '&';
    } else {
        url += '?';
    }

    $('.js__changeOrderBy').click(function (e) {
        e.preventDefault();
        var min_price = Math.ceil($('.js__priceContainer input[name="min_price"]').val());
        var max_price = Math.ceil($('.js__priceContainer input[name="max_price"]').val());
        var order_by = $(this).attr('data-key');
        var cats = '';
        $.each($('.js__filtersCats:checked'), function () {
            cats += ',' + $(this).val();
        });

        if (cats && !min_price && !max_price) {
            url += 'cats=' + escape(cats.slice(1)) + '&order_by=' + order_by;
        }
        else if (cats && min_price && max_price) {
            url += 'cats=' + escape(cats.slice(1)) + '&min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && max_price && (min_price < max_price)) {
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && max_price && min_price > max_price) {
            max_price = maximum;
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && !max_price) {
            max_price = maximum;
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else {
            url += 'order_by=' + order_by;
        }
        window.location = url;
    });

    $('.js__applyPriceFilter').click(function (e) {
        e.preventDefault();
        var min_price = Math.ceil($('.js__priceContainer input[name="min_price"]').val());
        var max_price = Math.ceil($('.js__priceContainer input[name="max_price"]').val());
        var order_by = $('#js__getFilter').attr('data-key');
        var maximum = $('#js__max_price').val();
        var cats = '';
        $.each($('.js__filtersCats:checked'), function () {
            cats += ',' + $(this).val();
        });

        if (cats && min_price && max_price) {
            url += 'cats=' + escape(cats.slice(1)) + '&min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && max_price && (min_price < max_price)) {
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && max_price && min_price > max_price) {
            max_price = maximum;
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (min_price && !max_price) {
            max_price = maximum;
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else if (!min_price && max_price) {
            min_price = 0;
            url += 'min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        }
        else {
            url += 'order_by=' + order_by;
        }
        window.location = url;
    });


    $('.js__applyFilterCats').click(function (e) {
        e.preventDefault();
        var min_price = Math.ceil($('.js__priceContainer input[name="min_price"]').val());
        var max_price = Math.ceil($('.js__priceContainer input[name="max_price"]').val());
        var order_by = $('#js__getFilter').attr('data-key');
        var cats = '';
        $.each($('.js__filtersCats:checked'), function () {
            cats += ',' + $(this).val();
        });

        if (cats && min_price && max_price) {
            url += 'cats=' + escape(cats.slice(1)) + '&min_price=' + min_price + '&max_price=' + max_price + '&order_by=' + order_by;
        } else if (cats) {
            url += 'cats=' + escape(cats.slice(1)) + '&order_by=' + order_by;
        }
        window.location = url;
    });

    $('.js__priceContainer input[name="min_price"]').focusout(function (e) {
        e.preventDefault();
        var min_price = Math.ceil($('.js__priceContainer input[name="min_price"]').val());
        var max_price = Math.ceil($('.js__priceContainer input[name="max_price"]').val());
        var maximum = $('#js__max_price').val();

        if (min_price < 0) {
            $('.js__priceContainer input[name="min_price"]').val(0);
        }
        else if (max_price < 0) {
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (min_price && max_price && (min_price > max_price) && (min_price < maximum)) {
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (min_price && (min_price > maximum)) {
            $('.js__priceContainer input[name="min_price"]').val(0);
        }
        else if (!min_price && !max_price) {
            $('.js__priceContainer input[name="min_price"]').val(0);
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (!min_price && max_price) {
            $('.js__priceContainer input[name="min_price"]').val(0);
        }

    });

    $('.js__priceContainer input[name="max_price"]').focusout(function (e) {
        e.preventDefault();
        var min_price = Math.ceil($('.js__priceContainer input[name="min_price"]').val());
        var max_price = Math.ceil($('.js__priceContainer input[name="max_price"]').val());
        var maximum = $('#js__max_price').val();

        if (max_price < 0) {
            $('.js__priceContainer input[name="max_price"]').val(Math.abs(max_price));
            if (!min_price) {
                $('.js__priceContainer input[name="min_price"]').val(0);
            }
        }
        else if (min_price < 0) {
            $('.js__priceContainer input[name="min_price"]').val(0);
        }
        else if (min_price && max_price && (min_price > max_price) && (min_price < maximum)) {
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (!min_price && max_price && (max_price > maximum)) {
            $('.js__priceContainer input[name="min_price"]').val(0);
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if ((max_price > maximum)) {
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (!min_price && !max_price) {
            $('.js__priceContainer input[name="min_price"]').val(0);
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
        else if (!min_price && max_price) {
            $('.js__priceContainer input[name="min_price"]').val(0);
        }
        else if (min_price && !max_price && (min_price > -1)) {
            $('.js__priceContainer input[name="max_price"]').val(maximum);
        }
    })

    $('.js__changeDeliveryMethod').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        $('#field-delivery').attr('data-value', value);
        var text = $(this).attr('data-text');
        $('.js__deliveryField').removeClass('form-fields');
        $('.js__deliveryField').removeClass('required');
        $('.js__deliveryField').parents('.order__tab-item').hide();
        $('.js__changePaymentMethod').parent().show();
        if (value == 'nova_poshta') {
            $('input[name="city"]').addClass('form-fields');
            $('input[name="city"]').addClass('required');
            $('input[name="city"]').parents('.order__tab-item').show();
            $('input[name="np_detachment"]').addClass('form-fields');
            $('input[name="np_detachment"]').addClass('required');
            $('input[name="np_detachment"]').parents('.order__tab-item').show();
        } else if (value == 'nova_poshta_courier') {
            $('input[name="city"]').addClass('form-fields');
            $('input[name="city"]').addClass('required');
            $('input[name="city"]').parents('.order__tab-item').show();
            $('input[name="address"]').addClass('form-fields');
            $('input[name="address"]').addClass('required');
            $('input[name="address"]').parents('.order__tab-item').show();
        } else {
            $('.js__changePaymentMethod:first').parent().hide();
            var p_method_text = $('.js__changePaymentMethod[data-value="card_transfer"]').text();
            var p_method_value = $('.js__changePaymentMethod[data-value="card_transfer"]').attr('data-value');
            $('#field-payment').attr('value', p_method_text);
            $('#field-payment').val(p_method_text);
            $('#field-payment').attr('data-value', p_method_value);
        }

        $('.js__deliveryText').text(text);
    });

    $('.js__changePaymentMethod').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        $('#field-payment').attr('data-value', value);
    });

    $('.js__tagClose').click(function (e) {
        e.preventDefault();
        $(this).parents('.count_category').remove();
        $('.js__filtersCats').prop('checked', false);
        $('.js__applyFilterCats').trigger('click');
    });

    $('.js__setCurrency').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        moduleAjax.send({'id': id}, {
            "url": '/actions/set-currency',
            "type": 'post',
            "dataType": 'html',
            "callback": 'location_reload',
            "callback_params": false,
        });
    });

    $('.js__addProductToWishlist').click(function () {
        var action = 'add';
        var product_id = $(this).parents('.product').attr('data-id');
        var element = $(this);
        if ($(this).hasClass('active')) {
            action = 'remove';
        }
        var request = $.ajax({
            data: {
                'action': action,
                'product_id': product_id,
            },
            url: '/actions/products-to-wishlist',
            type: 'post',
            dataType: 'json',
        });
        request.done(function (response) {
            if (response['error'] == 1) {
                if (response['action'] == 'remove') {
                    element.removeClass('active')
                    $('#js__wishlistCount').html(response['user_wishlist_count'])
                } else if (response['action'] == 'add') {
                    $('#js__wishlistCount').html(response['user_wishlist_count'])
                    element.addClass('active')
                }
            }
        });
    });

    $('.js__removeProductFromWishlist').click(function () {
        var action = 'remove';
        var product = $(this).parents('.items-line__item')
        var product_id = product.attr('data-id');
        var request = $.ajax({
            data: {
                'action': action,
                'product_id': product_id,
            },
            url: '/actions/products-to-wishlist',
            type: 'post',
            dataType: 'json',
        });
        request.done(function (response) {
            $('#js__wishlistCount').html(response['user_wishlist_count']);
            product.empty();
            if(parseInt(response['user_wishlist_count']) == 0){
                $('.js__notFound').show();
            }
        });
    });
    $('.js__addProductToBasket').click(function () {
        var product_id = $(this).parents('.product').attr('data-id');
        var request = $.ajax({
            data: {
                'product_id': product_id,
            },
            url: '/actions/add-product-to-basket',
            type: 'post',
            dataType: 'json',
        });
        request.done(function (response) {
            $('#js__basketCount').html(response['user_basket_count']);
        });
    });
});

$('.js_promo_button').click(function () {
    var errorArea = $(this).next();
    var promoCode = $(this).prev().val();
    var request = $.ajax({
        data: {
            'promoCode': promoCode,
        },
        url: '/actions/check-promo-code',
        type: 'post',
        dataType: 'json',
    });
    request.done(function (response) {
        var currency = $('#js__sopping_total').attr('data-currency');
        if(response.error == 1){
            $('#js__sopping_total').text($('#js__sopping_total').attr('data-price') + currency);
            errorArea.html(response.text);
        }else {
            var total_price = parseFloat($('#js__sopping_total').attr('data-price'), 1);
            total_price = (total_price - (total_price/100 * parseInt(response.value)));
            $('#js__sopping_total').html( '<s>'+ $('#js__sopping_total').attr('data-price') + currency + '</s> ' + total_price + currency);
            errorArea.hide();
        }

    });
})

