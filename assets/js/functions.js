/**
 * Checa se <b>date</b> é uma data no formato brasileiro (ponto para milhares e vírgula para decimais)
 * @param {String} date
 * @returns {Boolean}
 */
function isDateBR(date) {
    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
        return false;
    }
    var bits = date.split('/'),
        d = new Date(Date.UTC(bits[2] + '', (bits[1] - 1) + '', bits[0] + '', '24'));
    return (d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
}

/**
 * Checa se <b>date</b> é uma data no formato americano (sem separador de milhares e ponto para decimais)
 * @param {type} date
 * @returns {Boolean}
 */
function isDateUS(date) {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) {
        return false;
    }
    var bits = date.split('-'),
        d = new Date(Date.UTC(bits[0] + '', (bits[1] - 1) + '', bits[2] + '', '24'));
    return (d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]));
}

/**
 * Checa se <b>time</b> é um horário no formato 24h
 * @param {String} time
 * @returns {Boolean}
 */
function isTime24h(time) {
    return /^([0-1]\d|2[0-3]):[0-5]\d$/.test(time);
}

/**
 * Checa se <b>float</b> é um número no formato brasileiro (ponto para milhares e vírgula para decimais)
 * @param {String} float
 * @returns {Boolean}
 */
function isNumberBR(float) {
    return /^(-)?(\d{1,3})(\.\d{3})*(\,\d{2,})?$/.test(float);
}

/**
 * Converte <b>dateUS</b> para uma data no formato brasileiro
 * @param {String} dateUS Uma data no formato americano
 * @returns {String}
 */
function toDateBR(dateUS) {
    if (!isDateUS(dateUS)) {
        return false;
    }
    var bits = dateUS.split('-');
    return bits[0] + '/' + bits[1] + '/' + bits[2];
}

/**
 * Converte <b>dateBR</b> para uma data no formato americano
 * @param {String} dateBR Uma data no formato brasileiro
 * @returns {String}
 */
function toDateUS(dateBR) {
    if (!isDateBR(dateBR)) {
        return false;
    }
    var bits = dateBR.split('/');
    return bits[2] + '-' + bits[1] + '-' + bits[0];
}

/**
 * Converte <b>numberBR</b> para um número no formato americano (sem separador de milhares e ponto para decimais)
 * @param {String} numberBR Um número no formato brasileiro
 * @returns {String|Boolean}
 */
function toNumberUS(numberBR) {
    if (isNumberBR(numberBR)) {
        var replace1 = numberBR.replace(".", ""),
            replace2 = replace1.replace(",", ".");
        if ($.isNumeric(replace2)) {
            return replace2;
        }
    }
    return false;
}
