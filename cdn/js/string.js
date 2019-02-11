/**
 * Remove todos os acentros em UTF-8 de uma string.
 * @param {String} espaco Caracter que irá substituir o espaço na string
 * @returns {String}
 */
String.prototype.rmAcentos = function (espaco) {

    var varString = new String(this);
    var stringAcentos = new String('àâêôûãõáéíóúçüÀÂÊÔÛÃÕÁÉÍÓÚÇÜ');
    var stringSemAcento = new String('aaeouaoaeioucuAAEOUAOAEIOUCU');

    var i = new Number();
    var j = new Number();
    var cString = new String();
    var varRes = '';

    for (i = 0; i < varString.length; i++) {
        cString = varString.substring(i, i + 1);
        for (j = 0; j < stringAcentos.length; j++) {
            if (stringAcentos.substring(j, j + 1) == cString) {
                cString = stringSemAcento.substring(j, j + 1);
            }
        }
        varRes += cString;
    }

    if (typeof espaco != 'undefined') {
        varRes = varRes.split(" ").join(espaco.toString())
    }

    return varRes;

}

/**
 * Formata e retorna o número float de uma string
 * @returns {float}
 */
String.prototype.toFloat = function () {

    var test = /.*?\,[0-9]+$/gi;
    var value = this.replace(/[^0-9\-\.,]/gi, '');

    if (value == '') {
        value = 0;
    } else if (test.test(value)) {
        value = value.replace(/\./gi, '').replace(/,/gi, '.');
    } else {
        value = value.replace(/,/gi, '');
    }

    return parseFloat(value.toString().replace('/[^0-9\.]/gi'));

}

/**
 * Retorna a string formatada em Real (R$)
 * @returns {string} 1.500,00
 */
String.prototype.toReal = function () {
    return this.number_format(2, ',', '.');
}

/**
 * Formata um número float
 * @param {type} decimals Número de decimals após a virgula
 * @param {type} dec_point Caracter separador de unidades (centenas, milhares ...)
 * @param {type} thousands_sep Caracter separador dos decimais
 * @returns {Number|String.prototype.number_format.s}
 */
String.prototype.number_format = function (decimals, dec_point, thousands_sep) {

    var n = this.toFloat(), prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? '.' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? ',' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0, i + (n < 0)) +
                _[0].slice(i).replace(/(\d{3})/g, sep + '$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

/**
 * Preencha uma String com o char especificado
 * @param {type} length Tamanho que a string deve ter
 * @param {type} char Caracter que será adicionado
 * @param {type} dir left|right|boot
 * @returns {String.prototype.strpad.string|@var;char|String}
 */
String.prototype.strpad = function (length, char, dir) {

    var string = new String(this);
    dir = typeof dir == 'undefined' ? 'right' : dir;
    length = typeof length == 'undefined' ? 2 : parseInt(length);
    char = typeof char == 'undefined' ? '0' : char;

    while (string.length < length) {
        if (dir == 'left') {
            string = char + string;
        } else if (dir == 'right') {
            string = string + char;
        } else {
            string = char + string + char;
        }
    }

    return string;
}