jQuery(document).ready(function ($) {
    $('.generate-slug').click(function (e) {
        e.preventDefault();
        var data_name = $(this).attr('data-name');
        var data_target = $(this).attr('data-target');
        var name = $(data_name).val();
        if (name) {
            var request = $.ajax({
                data: {
                    'name': name
                },
                url: '/manager/ajax/generate-slug',
                type: 'post',
                dataType: 'html',
            });

            request.done(function (response) {
                $(data_target).val(response);
                $(data_target).attr('value', response);
            });
        } else
            alert($(this).attr('data-error'));
    });

    // Загрузка изображений Backend
    $("body").delegate('.imageUploader', 'change', function () {
        var action = $(this).attr('data-action');
        var target = $(this).attr('data-target');
        var path = $(this).attr('data-path');
        var file = this.files[0];
        if ((/^image\/(png|jpeg|gif)$/i).test(file.type)) {
            var formData = new FormData();
            formData.append('path', path);
            formData.append('file', file);
            var request = $.ajax({
                data: formData,
                url: '/manager/ajax/upload-image',
                type: 'post',
                dataType: 'html',
                contentType: false,
                processData: false
            });

            request.done(function (response) {
                if (action == 'avatar') {
                    $('#changeAvatar').attr('data-img', response);
                    $('#changeAvatar').attr('style', 'background-image: url(/manager/uploads/avatar/' + response + ');');
                    $(target).attr('value', response);
                    $(target).trigger('change');
                }
            });
        } else {
            alert('Select image!');
        }

    });

    $('#js__addProductImg').click(function (e) {
        e.preventDefault();
        $('.imgContainer').append('<div class="col-md-4 col-lg-4 col-sm-4"><a href="#" class="js__removeImg">X</a><div class="dropZone"><div class="imageBlock">Выбрать</div><input type="file" accept="image/png,image/jpeg" data-path="products/" data-target="#products-images" data-action="multi-image"></div></div>');
    });

    $("body").delegate('.js__removeImg', 'click', function (e) {
        e.preventDefault();
        $(this).parent().remove();
        setImgToTarget();
    });

    // Загрузка изображений Storage
    $("body").delegate('.dropZone [type=file]', 'change', function () {
        var drop = $(this).parent();
        var action = $(this).attr('data-action');
        var container = $(this).parents('.imgContainer');
        var target = $(this).attr('data-target');
        var path = $(this).attr('data-path');
        var file = this.files[0];
        if ((/^image\/(png|jpeg|gif|svg\+xml)$/i).test(file.type)) {
            var formData = new FormData();
            formData.append('path', path);
            formData.append('file', file);
            var request = $.ajax({
                data: formData,
                url: '/manager/ajax/upload-image',
                type: 'post',
                dataType: 'html',
                contentType: false,
                processData: false
            });

            request.done(function (response) {
                if (response == 'fail') {
                    alert('Не удалось загрузить изображение!');
                } else {
                    if (path) {
                        path = '/manager/uploads/' + path;
                    } else {
                        path = '/manager/uploads/';
                    }

                    if (!action) {
                        drop.find('.imageBlock').html('<img class="newImage" src="' + path + response + '" style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">');
                        drop.find('[type=hidden]').attr('value', response);
                        $(target).attr('value', response);
                        $(target).trigger('change');
                    } else {
                        if (action == 'multi-image') {
                            drop.find('.imageBlock').html('<img class="newImage" src="' + path + response + '" style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;" data-img="' + response + '">');
                            var src = getImgSrc(container);
                            $(target).attr('value', src);
                            $(target).trigger('change');
                        } else {
                            drop.find('.imageBlock').html('<img class="newImage" src="' + path + response + '" style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">');
                            $(target).attr('value', response);
                            $(target).trigger('change');
                        }
                    }
                }
            });
        } else {
            alert('Выберите изображение!');
        }

    });


    $('.saveOptions').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            obj = $(this).parents('tr').find('.item-data'),
            label = $(this).parents('tr').find('.badge');
        var data = moduleItemData.return_data(obj);
        if (data) {
            data["id"] = id;
            moduleAjax.send(data, {
                "url": '/manager/ajax/save-option',
                "type": 'post',
                "dataType": 'html',
                "callback": 'label_success',
                "callback_params": label,
            });
        }
    });

    $('.saveThemeVariables').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            obj = $(this).parents('tr').find('.item-data'),
            label = $(this).parents('tr').find('.badge');
        var data = moduleItemData.return_data(obj);
        if (data) {
            data["id"] = id;
            moduleAjax.send(data, {
                "url": '/manager/pages-content/save-theme-variable',
                "type": 'post',
                "dataType": 'html',
                "callback": 'label_success',
                "callback_params": label,
            });
        }
    });

    $("body").delegate('.delDropZone', 'click', function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    $('.addDropZone').click(function (e) {
        e.preventDefault();
        $(this).parent().append('<div style="float: left; display: inline-block;"><a href="#" class="delDropZone" title="Удалить">X</a><div class="dropZone"><div class="imageBlock">Выберите изображение</div><input type="file" accept="image/png,image/jpeg" data-path="" data-target="" data-action=""><input type="hidden" class="data-control item-data required" name="value" value="item1.jpg"></div></div>');
    });

    $('.saveThemeImages').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            label = $(this).parents('tr').find('.badge');
        var data = {};
        var img = '';
        $.each($(this).parents('tr').find('.item-data'), function () {
            img += $(this).val() + ',';
        });
        data["value"] = img.slice(0, -1);
        if (data) {
            data["id"] = id;
            moduleAjax.send(data, {
                "url": '/manager/pages-content/save-theme-variable',
                "type": 'post',
                "dataType": 'html',
                "callback": 'label_success',
                "callback_params": label,
            });
        }
    });

    // Удаление менеджера
    $('.deleteManager').click(function (e) {
        e.preventDefault();
        var search = location.search;
        if (!search) {
            var action = confirm('Вы уверены?')
            if (action === true) {
                var parent = $(this).parents('tr');

                moduleAjax.send({
                    'id': $(this).attr('data-id')
                }, {
                    "url": '/manager/ajax/remove-manager',
                    "type": 'post',
                    "dataType": 'html',
                    "callback": 'remove-product-attribute',
                    "callback_params": parent,
                });
            }
        } else
            alert("You can't delete it!");
    });

    $('.clearDropZone').click(function (e) {
        e.preventDefault();
        var target = $(this).parent().find('[type=file]').attr('data-target');
        ;
        $(this).parent().find('.imageBlock').html('Выберите изображение');
        var src = getImgSrc($(this).parents('.imgContainer'));
        $(target).attr('value', src);
        $(target).trigger('change');
    });

    $("body").delegate('.js__saveProductToCategory', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var product_id = $(this).attr('data-product_id');
        var data = moduleItemData.return_data($(this).parents('tr').find('.item-data'))
        if (data) {
            var request = $.ajax({
                data: {
                    'id': id,
                    'product_id': product_id,
                    'item': data,
                },
                url: '/manager/products/save-product-to-category',
                type: 'post',
                dataType: 'html'
            });

            request.done(function () {
                if (id == 0) {
                    location.reload();
                } else {
                    alert('Данные успешно сохранены');
                }
            });
        }
    });

    $("body").delegate('.js__removeProductToCategory', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var parent = $(this).parents('tr');
        var action = confirm('Вы уверены?')
        if (action === true) {
            var request = $.ajax({
                data: {
                    'id': id
                },
                url: '/manager/products/remove-product-to-category',
                type: 'post',
                dataType: 'html'
            });

            request.done(function (response) {
                if (response == 'done') {
                    parent.remove();
                }
            });
        }
    });

    $("body").delegate('.js__saveAttributeValue', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var attributes_id = $(this).attr('data-attributes_id');
        var data = moduleItemData.return_data($(this).parents('tr').find('.item-data'))
        if (data) {
            var request = $.ajax({
                data: {
                    'id': id,
                    'attributes_id': attributes_id,
                    'item': data,
                },
                url: '/manager/products-attributes/save-value-to-attribute',
                type: 'post',
                dataType: 'html'
            });

            request.done(function () {
                if (id == 0) {
                    location.reload();
                } else {
                    alert('Данные успешно сохранены');
                }
            });
        }
    });

    $("body").delegate('.js__removeAttributeValue', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var parent = $(this).parents('tr');
        var action = confirm('Вы уверены?')
        if (action === true) {
            var request = $.ajax({
                data: {
                    'id': id
                },
                url: '/manager/products-attributes/remove-value-to-attribute',
                type: 'post',
                dataType: 'html'
            });

            request.done(function (response) {
                if (response == 'done') {
                    parent.remove();
                }
            });
        }
    });

    $("body").delegate('.js__saveProductToAttribute', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var product_id = $(this).attr('data-product_id');
        var data = moduleItemData.return_data($(this).parents('tr').find('.item-data'))
        if (data) {
            var request = $.ajax({
                data: {
                    'id': id,
                    'product_id': product_id,
                    'item': data,
                },
                url: '/manager/products/save-product-to-attribute',
                type: 'post',
                dataType: 'html'
            });

            request.done(function () {
                if (id == 0) {
                    location.reload();
                } else {
                    alert('Данные успешно сохранены');
                }
            });
        }
    });

    $("body").delegate('.js__removeProductToAttribute', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var parent = $(this).parents('tr');
        var action = confirm('Вы уверены?')
        if (action === true) {
            var request = $.ajax({
                data: {
                    'id': id
                },
                url: '/manager/products/remove-product-to-attribute',
                type: 'post',
                dataType: 'html'
            });

            request.done(function (response) {
                if (response == 'done') {
                    parent.remove();
                }
            });
        }
    });

    $('.table-productAttributes [name=attribute_id]').change(function (e) {
        e.preventDefault();
        var val = parseInt($(this).val());
        var target = $(this).parents('tr').find('[name=attribute_value_id]');
        if (val > 0) {
            var request = $.ajax({
                data: {
                    'val': val
                },
                url: '/manager/products/get-attribute-values',
                type: 'post',
                dataType: 'html'
            });

            request.done(function (response) {
                target.html(response);
            });
        }
    });

    $('#js__changeOrderStatus').click(function (e) {
        e.preventDefault();
        var order_id = $('#orderID').val();
        var data = moduleItemData.return_data($(this).parents('tr').find('.item-data'));
        var action = confirm('Вы уверены?')
        if (action === true) {
            moduleAjax.send({
                'order_id': order_id,
                'items': data,
            }, {
                "url": '/manager/orders/change-status',
                "type": 'post',
                "dataType": 'html',
                "callback": 'reload',
                "callback_params": false,
            });
        }
    });

    $('.js__sendOrderStatus').click(function (e) {
        e.preventDefault();
        var history_id = $(this).attr('data-id');
        var email = $('#js__userEmail').val();
        var lang = $('#js__userLang').val();
        var action = confirm('Вы уверены?')
        if (action === true) {
            moduleAjax.send({
                'history_id': history_id,
                'email': email,
                'lang': lang
            }, {
                "url": '/manager/orders/send-status-mail',
                "type": 'post',
                "dataType": 'html',
                "callback": 'reload',
                "callback_params": false,
            });
        }
    });

    $('.js__getOrderBy').click(function (e) {
        e.preventDefault();
        var data = moduleItemData.return_data($(this).parents('tr').find('.item-data'))
        if (data) {
            location = '/manager/orders/index?value=' + data['value'] + '&type=' + data['type'];
        }
    });

    $('.dateform').find('input').attr('autocomplete','off');

});

function getImgSrc(container) {
    var src = '';
    $.each(container.find('img'), function () {
        if ($(this).attr('data-img') != '')
            src += '|' + $(this).attr('data-img');
    });

    return src.slice(1);
}