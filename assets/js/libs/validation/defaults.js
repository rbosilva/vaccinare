$.validator.setDefaults({
    invalidHandler: function (e, validator) {
        e.preventDefault();
        var message = '',
            name = '';
        $('input, select, textarea, span.select2 .select2-selection').removeClass($.validator.defaults.errorClass);
        $.each(validator.errorList, function (key, value) {
            $(value.element).addClass($.validator.defaults.errorClass);
            $(value.element).next('span.select2').find('.select2-selection').addClass($.validator.defaults.errorClass);
            name = $(value.element).closest('.form-group').find('.control-label[for=' + $(value.element).attr('id') + ']').text();
            message += '<b>' + name + '</b> - ' + value.message + '<br>';
        });
        System.alert({
            msg_type: 'error',
            msg: message,
            callback: function () {
                $(validator.errorList[0].element).focus();
            }
        });
    },
    errorPlacement: function () {
        return false;
    }
    
    
//    focusInvalid
    
    
});
