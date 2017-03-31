function isDateBR(date) {
    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
        return false;
    }
    var bits = date.split('/'),
        d = new Date(Date.UTC(bits[2] + '', (bits[1] - 1) + '', bits[0] + '', '24'));
    return (d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
}

function isDateUS(date) {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) {
        return false;
    }
    var bits = date.split('-'),
        d = new Date(Date.UTC(bits[0] + '', (bits[1] - 1) + '', bits[2] + '', '24'));
    return (d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]));
}

function toDateBR(dateUS) {
    if (!isDateUS(dateUS)) {
        return false;
    }
    var bits = dateUS.split('-');
    return bits[0] + '/' + bits[1] + '/' + bits[2];
}

function toDateUS(dateBR) {
    if (!isDateBR(dateBR)) {
        return false;
    }
    var bits = dateBR.split('/');
    return bits[2] + '-' + bits[1] + '-' + bits[0];
}

function isTime24h(time) {
    return /^([0-1]\d|2[0-3]):[0-5]\d$/.test(time);
}
