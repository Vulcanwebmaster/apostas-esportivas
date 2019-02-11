function mask(input, mascara) {

    $campo = $(input);
    $campo.attr('mask', String(mascara));

    $campo.keypress(function (event) {

        var number = '9'
        var char = 'a';
        var testNum = new RegExp(/[0-9]/);
        var testChar = new RegExp(/[a-z]/i);
        var value = String($(this).attr('value')).replace(' ', '#');
        var current = value.length + 1;
        var caracteres = keyCodes();
        var tecla = (window.event) ? event.keyCode : event.which;
        var mascara = $(this).attr('mask');
        var result = '';
        var type = 'nulo';

        if (tecla == 8 || !tecla) {
            return true;
        }

        if (value.length >= mascara.length) {
            return false;
        }

        if (tecla >= 48 && tecla <= 57) {
            type = 'number';
        } else if (tecla >= 97 && tecla <= 122) {
            type = 'char';
        } else if (tecla >= 65 && tecla <= 90) {
            type = 'char';
        } else {
            return false;
        }

        for (i = 0; i < current; i++) {
            maskAt = mascara.charAt(i);
            valueAt = value.charAt(i);
            if (maskAt == number) {
                if (testNum.exec(valueAt)) {
                    result += valueAt;
                }
            } else if (maskAt == char) {
                if (testChar.exec(valueAt)) {
                    result += valueAt;
                }
            } else {
                result += maskAt;
            }
        }

        maskAt = mascara.charAt(result.length);

        if (type == 'number' && maskAt != number) {
            return false;
        } else if (type == 'char' && maskAt != char) {
            return false;
        }

        if (caracteres[tecla] != undefined) {
            result += caracteres[tecla];
        }

        while (mascara.charAt(result.length) != char && mascara.charAt(result.length) != number && result.length < mascara.length) {
            result += mascara.charAt(result.length);
        }

        $(this).val(result);

        return false;

    });

    $campo.blur(function (e) {
        var value = $(this).val().length;
        var mascara = $(this).attr('mask').length;
        if (value >= mascara) {
            testExpMask(this);
        }
    });

    $campo.focus(function (e) {
        var value = $(this).val().length;
        var mascara = $(this).attr('mask').length;
        if (value >= mascara) {
            testExpMask(this);
        }
    });

}

function moeda(value) {
    return MaskMonetario(value);
}

function MaskMonetario(v) {
    v = parseFloat(v).toFixed(2).toString().replace(/\D/g, ""); /* Remove tudo o que não é dígito */
    v = v.replace(/(\d{2})$/, ",$1"); /* Coloca a virgula */
    v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1.$2"); /* Coloca o primeiro ponto */
    var qtdLoop = (v.length - 3) / 3;
    var count = 0;
    while (qtdLoop > count)
    {
        count++;
        v = v.replace(/(\d+)(\d{3}.*)/, "$1.$2"); /* Coloca o resto dos pontos */
    }
    v = v.replace(/^(0)(\d)/g, "$2"); /* Coloca hífen entre o quarto e o quinto dígitos */
    return v;
}

function testExpMask(obj) {

    var campo = $(obj);
    var value = campo.attr('value');
    var expTest = getExpMask(campo.attr('mask'));

    if (value != '') {
        if (!expTest.exec(value)) {
            campo.attr('value', '');
        }
    }
}

function getExpMask(mascara) {
    var value = mascara.replace(/([^a9])/gi, '\\$1');
    value = value.replace(/[a]/gi, '[a-z]');
    value = value.replace(/[9]/g, '[0-9]');
    return new RegExp(value, 'i');
}

function keyCodes(keyCode) {
    var chars = {'48': '0', '49': '1', '50': '2', '51': '3', '52': '4', '53': '5', '54': '6', '55': '7', '56': '8', '57': '9', '65': 'a', '66': 'b', '67': 'c', '68': 'd', '69': 'e', '70': 'f', '71': 'g', '72': 'h', '73': 'i', '74': 'j', '75': 'k', '76': 'l', '77': 'm', '78': 'n', '79': 'o', '80': 'p', '81': 'q', '82': 'r', '83': 's', '84': 't', '85': 'u', '86': 'v', '87': 'w', '88': 'x', '89': 'y', '90': 'z'};
    for (i = 65; i <= 90; i++) {
        value1 = String(i);
        value2 = String(i + 32);
        chars[value2] = chars[value1];
        chars[value1] = String(chars[value1]).toUpperCase();
    }
    return chars;
}

function removeEspacos(valor) {
    var valorSemEspacos = "";
    if (valor != undefined) {
        var tamanho = valor.length;
        for (i = 0; i < 30; i++) {
            if (valor.substr(i, 1) == " ") {
            } else {
                valorSemEspacos = valorSemEspacos + valor.substr(i, 1);
            }
        }
    }
    return valorSemEspacos;
}

function mask2(seletor, mascara) {
    $(seletor).each(function () {
        $(this).attr('mask', mascara.toString().replace(/9/gi, '#'));
        $(this).keyup(function (e) {
            $(this).val(mask_full($(this).val(), $(this).attr('mask')));
        });
    });
}

function mask_full(valor, mascara) {
    if (mascara == '###.###.###-##|##.###.###/####-##') {
        if (valor.length > 14) {
            return mascara_global('##.###.###/####-##', valor);
        } else {
            return mascara_global('###.###.###-##', valor);
        }
    }

    tvalor = "";
    ret = "";
    caracter = "#";
    separador = "|";
    mascara_utilizar = "";
    valor = removeEspacos(valor);
    if (valor == "") {
        return valor;
    }
    temp = mascara.split(separador);
    dif = 1000;

    valorm = valor;
    /* tirando mascara do valor já existente */
    for (i = 0; i < valor.length; i++) {
        if (!isNaN(valor.substr(i, 1))) {
            tvalor = tvalor + valor.substr(i, 1);
        }
    }

    valor = tvalor;

    /* formatar mascara dinamica */
    for (i = 0; i < temp.length; i++) {
        mult = "";
        validar = 0;
        for (j = 0; j < temp[i].length; j++) {
            if (temp[i].substr(j, 1) == "]") {
                temp[i] = temp[i].substr(j + 1);
                break;
            }
            if (validar == 1)
                mult = mult + temp[i].substr(j, 1);
            if (temp[i].substr(j, 1) == "[")
                validar = 1;
        }
        for (j = 0; j < valor.length; j++) {
            temp[i] = mult + temp[i];
        }
    }

    /* verificar qual mascara utilizar */
    if (temp.length == 1) {
        mascara_utilizar = temp[0];
        mascara_limpa = "";
        for (j = 0; j < mascara_utilizar.length; j++) {
            if (mascara_utilizar.substr(j, 1) == caracter) {
                mascara_limpa = mascara_limpa + caracter;
            }
        }
        tam = mascara_limpa.length;
    } else {
        /* limpar caracteres diferente do caracter da máscara */
        for (i = 0; i < temp.length; i++) {
            mascara_limpa = "";
            for (j = 0; j < temp[i].length; j++) {
                if (temp[i].substr(j, 1) == caracter) {
                    mascara_limpa = mascara_limpa + caracter;
                }
            }
            if (valor.length > mascara_limpa.length) {
                if (dif > (valor.length - mascara_limpa.length)) {
                    dif = valor.length - mascara_limpa.length;
                    mascara_utilizar = temp[i];
                    tam = mascara_limpa.length;
                }
            } else if (valor.length < mascara_limpa.length) {
                if (dif > (mascara_limpa.length - valor.length)) {
                    dif = mascara_limpa.length - valor.length;
                    mascara_utilizar = temp[i];
                    tam = mascara_limpa.length;
                }
            } else {
                mascara_utilizar = temp[i];
                tam = mascara_limpa.length;
                break;
            }
        }
    }

    /* validar tamanho da mascara de acordo com o tamanho do valor */
    if (valor.length > tam) {
        valor = valor.substr(0, tam);
    } else if (valor.length < tam) {
        masct = "";
        j = valor.length;
        for (i = mascara_utilizar.length - 1; i >= 0; i--) {
            if (j == 0)
                break;
            if (mascara_utilizar.substr(i, 1) == caracter) {
                j--;
            }
            masct = mascara_utilizar.substr(i, 1) + masct;
        }
        mascara_utilizar = masct;
    }

    /* mascarar */
    j = mascara_utilizar.length - 1;
    for (i = valor.length - 1; i >= 0; i--) {
        if (mascara_utilizar.substr(j, 1) != caracter) {
            ret = mascara_utilizar.substr(j, 1) + ret;
            j--;
        }
        ret = valor.substr(i, 1) + ret;
        j--;
    }
    return ret;
}