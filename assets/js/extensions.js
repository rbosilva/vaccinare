/**
 * Retorna os campos e valores do formulário
 * @returns {Json|Boolean}
 */
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

/**
 * Retorna todas as informações passadas no atributo "data" da tr
 * @param string id O nome do atributo que se deseja retornar
 * @returns {Object|Boolean}
 */
$.fn.get_tr_data = function (id) {
    if (typeof $(this) === 'object') {
        if ($(this).closest('tr').is('.child')) {
            return $(this).closest('tr.child').prev('tr.parent').data(id);
        }
        return $(this).closest('tr').data(id);
    }
    return false;
};

/**
 * Retorna o html "externo" do elemento, ou seja, todo o seu conteúdo mais suas tags externas
 * @returns {Boolean|String}
 */
$.fn.outerHtml = function () {
    if (typeof this === 'object') {
        return this.clone().wrap('<div>').parent().html();
    }
    return false;
};
