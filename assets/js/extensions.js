$.fn.getFormData = function () {
    if (typeof $(this) === 'object' && $(this).is('form')) {
        var result = {},
            numberUS = false,
            dateUS = false;
        $(this).find('input, select, textarea').filter('[name]').each(function () {
            if ($(this).is('input:not(:checkbox), select')) {
                if (numberUS = toNumberUS($(this).val())) {
                    result[$(this).attr('name')] = numberUS;
                } else if (dateUS = toDateUS($(this).val())) {
                    result[$(this).attr('name')] = dateUS;
                } else {
                    result[$(this).attr('name')] = $(this).val();
                }
            } else if ($(this).is('input:checkbox')) {
                result[$(this).attr('name')] = $(this).is(':checked') ? 1 : 0;
            } else {
                result[$(this).attr('name')] = $(this).text();
            }
        });
        return result;
    }
    return false;
};

$.fn.get_tr_data = function (id) {
    if (typeof $(this) === 'object') {
        if ($(this).closest('tr').is('.child')) {
            return $(this).closest('tr.child').prev('tr.parent').data(id);
        }
        return $(this).closest('tr').data(id);
    }
    return false;
};

$.fn.outerHtml = function () {
    if (typeof this === 'object') {
        return this.clone().wrap('<div>').parent().html();
    }
    return false;
};

(function ($) {
    $.fn.load = function (url, params, callback) {
        var self = this,
            split = url.split(' '),
            url = split.shift(),
            selector = split.join(' '),
            data = null,
            complete = null;
        if ($.isFunction(params)) {
            complete = params;
        } else {
            data = params;
            if ($.isFunction(callback)) {
                complete = callback;
            }
        }
        $.get(url, data, function (html) {
            if (html === 'session_expired') {
                document.location.replace(System.base_url());
            } else {
                if (selector !== '') {
                    html = $('<div>' + html + '</div>').find(selector).outerHtml();
                }
                self.html(html);
                complete(html);
            }
        }, 'html');
        return this;
    };
})(jQuery);
