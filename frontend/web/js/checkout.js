jQuery(document).ready(function ($) {
    $('.js__changeCheckoutCountry').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        $(this).parents('ul').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('.dropdown-main__header--js-click').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('p').text(value);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').val(value);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').attr('value', value);
    });

    $('.js__changeDeliveryMethod').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        var p_text = $(this).attr('data-p_text');
        $(this).parents('ul').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('.dropdown-main__header--js-click').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('p').text(p_text);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').val(value);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').attr('value', value);

        var text = $(this).attr('data-text');
        $('.js__deliveryField').removeClass('form-fields');
        $('.js__deliveryField').removeClass('required');
        $('.js__deliveryField').parents('.cabinet__tab-item').hide();
        $('.js__changePaymentMethod').parent().show();
        if (value == 'nova_poshta') {
            $('.js__deliveryAddressContainer').show();
            $('#checkout_field-country').addClass('form-fields');
            $('#checkout_field-country').addClass('required');
            $('#checkout_field-country').parents('.cabinet__tab-item').show();
            $('#checkout_field-city').addClass('form-fields');
            $('#checkout_field-city').addClass('required');
            $('#checkout_field-city').parents('.cabinet__tab-item').show();
            $('#checkout_field-np_detachment').addClass('form-fields');
            $('#checkout_field-np_detachment').addClass('required');
            $('#checkout_field-np_detachment').parents('.cabinet__tab-item').show();
        } else if (value == 'nova_poshta_courier') {
            $('.js__deliveryAddressContainer').show();
            $('#checkout_field-country').addClass('form-fields');
            $('#checkout_field-country').addClass('required');
            $('#checkout_field-country').parents('.cabinet__tab-item').show();
            $('#checkout_field-city').addClass('form-fields');
            $('#checkout_field-city').addClass('required');
            $('#checkout_field-city').parents('.cabinet__tab-item').show();
            $('#checkout_field-address').addClass('form-fields');
            $('#checkout_field-address').addClass('required');
            $('#checkout_field-address').parents('.cabinet__tab-item').show();
        } else {
            $('.js__deliveryAddressContainer').hide();
            $('.js__changePaymentMethod:first').parent().hide();
            var p_method_text = $('.js__changePaymentMethod[data-value="card_transfer"]').text();
            var p_method_value = $('.js__changePaymentMethod[data-value="card_transfer"]').attr('data-value');
            $('#field-payment-p').text(p_method_text);
            $('#field-payment').val(p_method_value);
            $('#field-payment').attr('value', p_method_value);
        }

        $('.js__deliveryText').text(text);
    });
    
    $('.js__changePaymentMethod').click(function (e) {
        e.preventDefault();
        var value = $(this).attr('data-value');
        var text = $(this).attr('data-text');
        $(this).parents('ul').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('.dropdown-main__header--js-click').removeClass('is-show');
        $(this).parents('.js__customDropDown').find('p').text(text);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').val(value);
        $(this).parents('.js__customDropDown').find('input[type=hidden]').attr('value', value);
    });
});