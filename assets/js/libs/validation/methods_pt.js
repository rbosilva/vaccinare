/*
 * Localized default methods for the jQuery validation plugin.
 * Locale: PT_BR
 */
$.extend($.validator.methods, {
    date: function (value, element) {
        return this.optional(element) || /^\d\d?\/\d\d?\/\d\d\d?\d?$/.test(value);
    }
});

$.validator.addMethod('dateBR', function (value, element) {
    return this.optional(element) || isDateBR(value);
});

$.validator.addMethod('time24h', function (value, element) {
    return this.optional(element) || isTime24h(value);
});
