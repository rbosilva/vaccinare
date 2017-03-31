$.validator.setDefaults({
    invalidHandler: function (e, validator) {
        e.preventDefault();
        var message = '',
            name = '';
        $('input, select, textarea').removeClass($.validator.defaults.errorClass);// Default "error", se mudá-la, troque também no CSS
        $.each(validator.errorList, function (key, value) {
            $(value.element).addClass($.validator.defaults.errorClass);
            name = $('.control-label[for=' + $(value.element).attr('id') + ']').text();
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
