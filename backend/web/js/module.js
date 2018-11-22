jQuery(document).ready(function ($) {
    $('.item-data').focusout(function (e) {
        e.preventDefault();
        var val = $(this).val();
        if($(this).hasClass('required') && val == ''){
            $(this).addClass('has-error');
        }else if ($(this).hasClass('has-error')){
            $(this).removeClass('has-error');
        }
    });

    (function () {
        var action = $('body').attr('data-userTime');
        if (action == 'notSet') {
            var d = new Date();
            var dtz = -(d.getTimezoneOffset()) / 60;
            var request = $.ajax({
                data: {
                    'dtz': dtz
                },
                url: '/manager/ajax/set-user-offset-time',
                type: 'post',
                dataType: 'html',
            });

            request.done(function () {
                location.reload();
            });
        }
    }());
});

var moduleAjax = {
    // Main function
    "send" : function (data, params) {
        var request = $.ajax({
            data: data,
            url: params['url'],
            type: params['type'],
            dataType: params['dataType']
        });

        request.done(function (response) {
            moduleAjax[params['callback']](response, params['callback_params']);
        });
    },
    // Response functions
    "default" : function (response, params) {
        alert(response);
    },
    "reload" : function (response, params) {
        location.reload();
    },
    "label_success" : function (response, params) {
        if(response == 'fail'){
            alert('Не удалось сохранить данные!');
        }else{
            $(params).show();
            setTimeout(function () {
                $(params).hide();
            }, 2000);
        }
    },
};

var moduleItemData = {
    'return_data' : function (objects) {
        var action = true;
        var data = {};
        $.each(objects, function () {
            if($(this).val() == ''){
                if($(this).hasClass('required')){
                    $(this).addClass('has-error');
                    action = false;
                }
            }
            data[$(this).attr('name')] = $(this).val();
        });

        if(action)
            return data;
        else
            return false;
    }
}
