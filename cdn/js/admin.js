var __CACHE__ = {};
var PROTOCOLO = URL_APP.search('https') == -1 ? 'http' : 'https';

/**
 * Retorna o conteúdo gravado no cache
 * @param {string|int} _key
 * @param {mixed} _default
 * @returns {mixed}
 */
function getCache(_key, _default) {
    return (typeof __CACHE__[_key] !== 'undefined') ? __CACHE__[_key] : (_default || undefined);
}

/**
 * Insere/Atualiza um registro no cache
 * @param {string|int} _key
 * @param {mixed} _value
 * @returns {undefined}
 */
function setCache(_key, _value) {
    __CACHE__[_key] = _value;
}

/**
 * Rola até o final da página
 * @param {jQuerySelector} viewport
 * @param {int} marginBottom
 * @param {int|fast|slow} timer
 * @returns {undefined}
 */
function scrollBottom(viewport, marginBottom, timer) {
    viewport = $(viewport);
    if (viewport.length == 1) {
        var space = viewport[0].scrollHeight - viewport.innerHeight();
        viewport.stop().animate({scrollTop: scrollHeight(viewport) - (marginBottom || 0)}, timer || 'fast');
    } else {
        viewport.each(function () {
            scrollEnd(this, timer);
        });
    }
}

/**
 *
 * @param {jQuerySelector} viewport
 * @returns {int|float}
 */
function scrollHeight(viewport) {
    viewport = $(viewport);
    return viewport[0].scrollHeight - viewport.innerHeight();
}

/**
 * Escreve no console window.console.log
 * @returns {undefined}
 */
function _log() {
    if (window.console && window.console.log && $.isFunction(window.console.log)) {
        $.each(arguments, function (index, value) {
            window.console.log(value);
        });
    }
}

/*
 * Colorbox
 * [data-colorbox]
 */
if (typeof $.colorbox != 'undefined' && $.isFunction($.colorbox)) {
    $(document).on('click', 'a[data-colorbox]', function () {

        var width = 650;
        var value = $(this).attr('data-colorbox');


        var scale = Math.min(width, $(window).width() - 50) / width;

        var parans = {
            title: $(this).attr('title'),
            href: $(this).attr("href"),
            maxWidth: $(window).width() - 50,
            maxHeight: $(window).height() - 50,
        };

        if (value == 'video') {
            parans.iframe = true;
            parans.innerWidth = 650 * scale;
            parans.innerHeight = 400 * scale;
        } else if (value) {
            parans.iframe = false;
            parans.rel = value;
        } else {
            parans.photo = true;
            parans.iframe = false;
        }

        $.colorbox(parans);

        return false;
    });
}

if (typeof $().chosen != 'undefined') {
    $('select.chosen').chosen();
}

/**
 *
 * <b>Configurações:</b>
 * Se deve ou não exibir a janela no modo de teatro. O padrão é não.
 * channelmode: 0
 *
 * Se deve ou não exibir o navegador em modo de tela cheia. O padrão é não. Uma janela em modo de tela cheia também deve estar no modo de teatro.
 * fullscreen: 0
 *
 * A altura da janela. Min. valor é de 100
 * height: 600
 *
 * A largura da janela. Min. valor é de 100
 * width: 400
 *
 * A posição esquerda da janela. Os valores negativos não permitidos
 * left: 0
 *
 * A posição superior da janela. Os valores negativos não permitidos
 * top: 0
 *
 * Se deve ou não exibir o campo de endereço.
 * location: 0
 *
 * Se deve ou não exibir a barra de menus
 * menubar: 0
 *
 * Quer ou não a janela é redimensionável.
 * resizable: 0
 *
 * Se deve ou não exibir barras de rolagem.
 * scrollbars: 1
 *
 * Quer ou não adicionar uma barra de status
 * status: 0
 *
 * Se deve ou não exibir a barra de título. Ignorado a menos que o aplicativo de chamada é um aplicativo HTML ou uma caixa de diálogo de confiança
 * titlebar: 0
 *
 * Se deve ou não exibir a barra de ferramentas do navegador.
 * toolbar: 0
 *
 * @param {string} url
 * @param {string} target
 * @param {array} config
 * @returns {void}
 */
function popUp(url, target, config) {

    config = $.extend({
        channelmode: 0, // Se deve ou não exibir a janela no modo de teatro. O padrão é não.
        fullscreen: 0, // Se deve ou não exibir o navegador em modo de tela cheia. O padrão é não. Uma janela em modo de tela cheia também deve estar no modo de teatro.
        height: 600, // A altura da janela. Min. valor é de 100
        width: 400, // A largura da janela. Min. valor é de 100
        left: 0, // A posição esquerda da janela. Os valores negativos não permitidos
        top: 0, // A posição superior da janela. Os valores negativos não permitidos
        location: 0, // Se deve ou não exibir o campo de endereço.
        menubar: 0, // Se deve ou não exibir a barra de menus
        resizable: 0, // Quer ou não a janela é redimensionável.
        scrollbars: 1, // Se deve ou não exibir barras de rolagem.
        status: 0, // Quer ou não adicionar uma barra de status
        titlebar: 0, // Se deve ou não exibir a barra de título. Ignorado a menos que o aplicativo de chamada é um aplicativo HTML ou uma caixa de diálogo de confiança
        toolbar: 0, // Se deve ou não exibir a barra de ferramentas do navegador.
    }, config);

    config.width = Math.min(screen.availWidth - 100, Math.max(100, config.width));
    config.height = Math.min(screen.availHeight - 100, Math.max(100, config.height));

    config.left = screen.availWidth * 0.5 - config.width * 0.5;
    config.top = screen.availHeight * 0.5 - config.height * 0.5;

    var configString = '';

    $.each(config, function (index, value) {
        if (configString) {
            configString += ', ';
        }
        configString += index + '=' + value;
    });

    _log(configString);

    window.open(url, target, configString);

}

/**
 * Gera URL
 * @param {string} ControllerAction
 * @param {array} Variaveis
 * @param {string} Module
 * @returns {unresolved}
 */
function url(ControllerAction, Variaveis, Module) {

    var url = URL_APP;

    // Módulo
    if (Module === undefined) {
        Module = MODULE;
    }

    // Módulo
    if (Module != MODULE_DEFAULT) {
        url += '/' + Module;
    }

    // Controller/Action
    if (ControllerAction) {
        url += '/' + ControllerAction;
    }

    // Variaveis
    if ($.isArray(Variaveis)) {
        $.each(Variaveis, function (index, value) {
            url += '/' + value;
        });
    }

    return url.toString().replace(/\\/g, '/');
}

/**
 *
 * @param {type} obj
 * @param {type} classAnimate
 * @returns {undefined}
 */
function animated($selector, classAnimate) {
    $selector = $($selector);
    $selector.addClass(classAnimate + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        $selector.removeClass('animated ' + classAnimate);
    });
}

/**
 *
 * @param {string|jqueryObject} $estado
 * @param {string|jqueryObject} $cidade
 * @returns {undefined}
 */
function estadosCidades($estado, $cidade) {

    // Select.estado
    $estado = $($estado).first();

    // Cidade informada
    if (typeof $cidade != 'undefined') {
        $cidade = $($cidade);
    }
    // Buscando a única cidade do formulário
    else if (!$estado.data('selectCidade')) {
        $cidade = $estado.parents('form').find('select[name=cidade]').first();
    }

    if ($cidade.length) {
        $estado.change(function () {
            // Cancelando ultima interação
            if ($estado.data('ajaxCidades')) {
                $estado.data('ajaxCidades').abort();
            }

            // Buscando cidades
            setTimeout(function () {

                var estadoID = $estado.val() || 0;
                var cidadeID = $cidade.attr('data-setvalue') || 0;
                var temFocu = $estado.is(':focus');

                if (estadoID !== 0) {
                    $estado.data('ajaxCidades', $.ajax({
                        type: 'POST',
                        data: {
                            ajax_serialize: JSON.stringify({cidade: cidadeID, estado: estadoID}),
                            dtCache: (new Date()).getTime()
                        },
                        url: url('cidades', null, 'localizacao'),
                        success: function (result) {
                            $cidade.html(result);
                        }, complete: function () {
                            $estado.attr('disabled', false);
                            $cidade.attr('disabled', false);
                            if (temFocu) {
                                $cidade.focus();
                            }
                        }, beforeSend: function () {
                            $estado.attr('disabled', true);
                            $cidade.attr('disabled', true);
                        }, error: function () {
                            _log('Não foi possível buscar as Cidades.');
                            $cidade.html($('<option value="" >Error!</option>'));
                        }
                    }));
                } else {
                    $cidade.html('<option value="" >-- Selecione o estado --</option>');
                }

            }, 100);
        }).change();
    }
}

function apply_masks(Container) {

    Container = $(Container);

    // Data
    if (!Modernizr.inputtypes.date) {
        $('input[type=date], .mask-data')
            .each(function () {
                console.log('veio aqui');
                if (this.value)
                    $(this).val(this.value.toString().split('-').reverse().join('/'));
            })
            .attr('type', 'text').addClass('mask-data');
    } else {
        $('input[type=text].mask-data, input[type=date]')
            .each(function () {
                if (this.value)
                    $(this).val(this.value.toString().split('/').reverse().join('-'));
            })
            .attr('type', 'date').removeClass('mask-data');
    }

    // Time
    if (!Modernizr.inputtypes.time) {
        $('input[type=time]').attr('type', 'text').addClass('mask-hora');
    } else {
        $('input[type=text].mask-hora').attr('type', 'time').removeClass('mask-hora');
    }

    // Mascara de valor
    if (typeof mask2 == 'function') {
        mask2(Container.find('input.mask-valor'), '-?[###.]###,##');
        Container.find('input.mask-valor').focus(function () {
            var input = $(this);
            input.select();
            setTimeout(function () {
                input.select();
            }, 150);
        });
    }

    if ($.mask) {

        var maskData = '(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}';

        Container.find('input[type=text][class*=mask-], input[type=date]').filter(':not(.text-left):not(.text-right)').addClass('text-center');

        Container.find('input.mask-urlamigavel').change(function () {
            this.value = this.value.toLowerCase().rmAcentos('-');
        });

        Container.find('input.mask-credcard').mask('9999 9999 9999 9999');
        Container.find('input.mask-credcard-validate').mask('99/9999');

        Container.find('input.mask-numero').mask('[0-9]+');
        Container.find('input[type=text].mask-data').attr('pattern', maskData).mask('99/99/9999');
        Container.find('input[type=text].mask-datatime').attr('pattern', maskData + ' [0-9]{2}:[0-9]{2}:[0-9]{2}').mask('99/99/9999 99:99:99');
        Container.find('input[type=text].mask-hora').attr('pattern', '[0-9]{2}:[0-9]{2}:[0-9]{2}').mask('99:99:99');
        Container.find('input[type=text].mask-cep').attr('pattern', '[0-9]{5}\-[0-9]{3}').mask('99999-999').attr("placeholder", "00000-000");
        Container.find('input[type=text].mask-cpf').attr('pattern', '[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}').mask('999.999.999-99').attr("placeholder", '000.000.000-00');
        Container.find('input[type=text].mask-cnpj').attr('pattern', '[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}').mask('99.999.999/9999-99').attr("placeholder", '00.000.000/0000-00');
        Container.find('input.mask-telefone').mask('(99) 9999-9999?9').on("keyup", function () {

            var tmp = $(this).val();
            tmp = tmp.replace(/[^0-9]/g, '');
            var ddd = tmp.slice(0, 2);
            var servico_regex = new RegExp('0[0-9]00');
            var servico = servico_regex.exec(tmp.slice(0, 4));
            // var primeiro_numero_ddd = tmp.slice(0, 1);
            var primeiro_numero = tmp[2];

            if (tmp.length === 11 && primeiro_numero === '9') {
                $(this).unmask();
                $(this).val(tmp);
                $(this).mask("(99) 99999-999?9");
            } else if (servico && (tmp.length === 11 || tmp.length === 10)) {
                $(this).unmask();
                $(this).val(tmp);
                $(this).mask("9999-999999?9");
            } else if (tmp.length === 10 && primeiro_numero === '9') {
                $(this).unmask();
                $(this).val(tmp);
                $(this).mask("(99) 9999-9999?9");
            } else if (tmp.length === 10) {
                $(this).unmask();
                $(this).val(tmp);
                $(this).mask("(99) 9999-9999");
            }

        }).keyup();
    }

    Container.find('input[type=text].mask-cep').keyup(function () {

        var input = $(this);
        var form = $(input.context.form);
        var test = new RegExp('^[0-9]{5}\-[0-9]{3}$');

        if (input.data('ajaxViaCep')) {
            input.data('ajaxViaCep').abort();
        }

        if (test.test(input.val().toString())) {

            input.data('ajaxViaCep', $.get(url('logradouro/cep', [input.val()], 'localizacao'), function (e) {

                if (e.result == 1) {

                    form.find('[name=rua],[name=endereco],[name=logradouro],.end-logradouro').val(e.logradouro);
                    form.find('[name=bairro], .end-bairro').val(e.bairro);
                    form.find('select[name=cidade], select.end-cidade').attr('data-setvalue', $.isPlainObject(e.cidade) ? e.cidade.id : e.cidade);
                    form.find('input[name=cidade], input.end-cidade').val($.isPlainObject(e.cidade) ? e.cidade.cidade : e.cidade);
                    form.find('input[name=uf], input.end-uf').val(e.uf);
                    form.find('input[name=estado], input.end-estado').val($.isPlainObject(e.estado) ? e.estado.estado : e.estado);

                    // 
                    form.find('select[name=estado],select[name=uf], select.end-estado').find('option').filter(function () {
                        if (e.uf == $(this).text()) {
                            return true;
                        } else if ($.isPlainObject(e.estado) && e.estado.id == this.value) {
                            return true;
                        } else {
                            return false;
                        }
                    }).attr('selected', true).change();

                    // Buscando Localização
                    if (form.find("[name=latitude], .end-latitude").length > 0 && typeof GMaps != 'undefined') {
                        GMaps.geocode({
                            address: e.logradouro + ', ' + e.bairro + ', ' + (e.cidade.cidade || e.cidade) + '/' + e.uf + ', Brasil',
                            callback: function (results, status) {
                                if (status == 'OK') {
                                    var latlng = results[0].geometry.location;
                                    form.find('[name=latitude], input.end-latitude').val(latlng.lat()).change();
                                    form.find('[name=longitude], input.end-longitude').val(latlng.lng()).change();
                                    form.find('[name=zoom], input.end-zoom').val(17).change();
                                }
                            }
                        });
                    }
                }

            }, 'json'));

        }

    });

}

/**
 * Btn Scroll Top
 * @param {jQuery} $
 * @returns {undefined}
 */
(function ($) {

    $('.btn-scroll-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

    $(window).scroll(function () {
        if (this.scrollY > 200) {
            $('.btn-scroll-top').css('display', 'block');
        } else {
            $('.btn-scroll-top').css('display', 'none');
        }
    }).scroll().load(function () {
        $(this).scroll();
    });

})(jQuery);

(function ($) {

    $('form .change-submit').change(function () {
        $(this).parents("form").submit();
    });

    $('[data-toggle-class]').click(function () {
        var a = $(this).attr('data-toggle-class').toString().split(',');
        $(a[0]).toggleClass(a[1]);
    });


    $(document).on('mouseenter', '[data-animated-in]', function () {
        animated(this, $(this).attr('data-animated-in'));
    });

    $(document).on('mouseleave', '[data-animated-out]', function () {
        animated(this, $(this).attr('data-animated-out'));
    });

    if (Modernizr) {

        // Data
        if (!Modernizr.inputtypes.date) {
            $('input[type=date]').attr('type', 'text').addClass('mask-data');
        }

        // Placeholder
        if (!Modernizr.input.placeholder) {
            _log('Faça alguma coisa quanto a isso!', 'Resolva o problema!');
        }

    }

    $('form').find('select[name=estado], select[name=uf], select.estados[data-target]').each(function () {
        if ($(this).attr("data-target")) {
            estadosCidades(this, $(this).attr('data-target'));
        } else {
            estadosCidades(this);
        }
    });

    apply_masks(document);

    $.fn.resetForm = function () {

        var form = $(this);

        // Iputs e textarea
        form.find('input,textarea').filter(':not([type=radio]):not([type=checkbox])').val('').change().filter('.has-ckeditor').each(function () {
            $(this).data('ckeditor').setData('');
        });
        // Checkbox
        form.find('[type=checkbox], [type=radio]').filter(':checked').prop('checked', false).change();

        // Select
        form.find('select option').prop({'selected': false, 'checked': false});

        form.trigger('resetForm').find('select').trigger('chosen:updated');

        return this;

    }

    $('[type=checkbox]').change(function () {
        if (!$(this).prop('checked')) {
            $('[type=checkbox][value="*"][name="' + $(this).attr('name') + '"]').prop('checked', false);
        }
    }).filter('[value="*"]').change(function () {
        if ($(this).prop('checked')) {
            $('[type=checkbox][name="' + $(this).attr('name') + '"]:not([value="*"])').prop('checked', true);
        }
    });

    /**
     * @param {object} values
     * @returns {undefined}
     */
    $.fn.setValues = function (values, rolarPagina) {

        if (typeof rolarPagina == 'undefined') {
            rolarPagina = true;
        }

        var form = this;
        var fields;

        form.resetForm();

        if (!$.isPlainObject(values)) {
            try {
                values = $.parseJSON(values);
            } catch (e) {
                values = {};
            }
        }

        $.each(values, function (name, value) {


            if ($.isArray(value)) {

                $.each(value, function (index, value) {

                    form.find("[name='" + name + "[]']").filter(function () {
                        if ($(this).prop('value') == value) {
                            return true;
                        } else {
                            return false;
                        }
                    }).filter('[type=checkbox], [type=radio]').prop('checked', true).change();

                    form
                        .find("select[name='" + name + "'][multiple] option")
                        .filter(function () {
                            if ($(this).val() == value) {
                                return true;
                            } else {
                                return false;
                            }
                        })
                        .prop({'selected': true, 'checked': true});

                });

                form.find('[name="' + name + '[]"]').each(function (index) {
                    if (typeof value[index] != 'undefined') {

                        $(this).filter(':not([type=checkbox]):not([type=radio])').prop('value', value[index]);

                        $(this).filter('[type=checkbox], [type=radio]').filter(function () {
                            if ($(this).prop('value') == value[index]) {
                                return true;
                            } else {
                                return false;
                            }
                        }).prop('checked', true);

                        $(this)
                            .change()
                            .filter('.has-ckeditor')
                            .each(function () {
                                var ck = $(this).data('ckeditor');
                                if (ck) {
                                    setTimeout(function () {
                                        ck.setData(value[index]);
                                    }, 250);
                                }
                            });
                    }
                });

            } else if ($.isPlainObject(value)) {

                form.find('input[name="' + name + '"]').val($.param(value));

                $.each(value, function (index, value) {
                    if ($.isArray(value) || $.isPlainObject(value)) {
                        $.each(value, function (i, v) {
                            form.find('[name="' + name + '[' + index + '][' + i + ']"]').val(v);
                        });
                    } else {
                        form.find('[name="' + name + '[' + index + ']"]').val(value);
                    }
                });


            } else {

                fields = form.find("[name='" + name + "'], [data-name='" + name + "']").filter(':not([type=radio]):not([type=checkbox])');

                fields.attr('data-setvalue', value).filter(':not(select)').prop('value', value);

                fields
                    .filter('select')
                    .find('option')
                    .filter(function () {
                        if (this.value == value) {
                            return true;
                        }
                        return false;
                    })
                    .prop("selected", true)
                    .change();

                // Data
                if (value) {
                    fields.filter('input[type=date]').prop('value', value.toString().split("/").reverse().join('-')).change();
                    fields.filter('input[type="text"].mask-data').prop('value', value.toString().split('-').reverse().join('/')).change();

                    fields.filter('input[type=number]').prop('value', value.toString().toFloat());
                    fields.filter('input[type=text].mask-valor').prop('value', value.toString().toReal());
                }

                // CKEditor
                fields
                    .filter('.has-ckeditor')
                    .each(function () {
                        var input = $(this);
                        setTimeout(function () {
                            console.log(input.data('ckeditor'));
                            input.data('ckeditor').setData(value);
                        }, 250);
                    });

                // Input Radio/Checkbox
                form
                    .find("[name='" + name + "'], [data-name='" + name + "']")
                    .filter('[type=radio], [type=checkbox]')
                    .filter(function () {

                        if ($(this).prop('value') == value) {
                            return true;
                        } else {
                            return false;
                        }
                    })
                    .prop('checked', true).change();
            }


        });

        /* Modal open */
        form.filter('.modal').addClass('has-modal').modal("show");
        form.find('.modal').modal("show").parents('form').addClass('has-modal');

        if (!form.hasClass('modal')) {
            form.scrollTo();
        }

        form.trigger('setValues', [values]);
        form.find('select').trigger('chosen:updated');

        if ($.fn.uniform) {
            $('.checker input').uniform();
        }

        return form;

    };

    $.fn.scrollTo = function () {
        $('body, html', document).animate({scrollTop: ($(this).offset() ? $(this).offset().top : 0) - 10}, 'fast');
        return this;
    }

    /**
     * Retorna os valores do formulário
     * @returns {object}
     */
    $.fn.getValues = function () {
        var values = $(this).serializeObject();
        $(this).find(':not([name])[data-name]').each(function () {
            var name = $(this).attr('data-name');
            if (typeof values[name] == 'undefined') {
                values[name] = $(this).val();
            }
        });
        $(this).find("select[name][multiple]").each(function () {
            var name = $(this).attr('name');
            values[name] = '';
            $(this).find("option[value]:selected").each(function () {
                values[name] += '[' + $(this).attr('value') + ']';
            });
        })
        $(this).find('textarea[name].has-ckeditor').each(function () {
            values[$(this).attr('name')] = $(this).data('ckeditor').getData();
        });
        $(this).trigger('getValues', [values]);
        return values;
    }

    $('form[data-values]').each(function () {
        var form = $(this);
        try {
            var values = $.parseJSON(form.attr('data-values'));
            form.setValues(values, false);
        } catch (e) {
            _log('Não foi possível decodificar', form.attr('data-values'), e);
        }
    });

    $('form').find('[type=reset]').click(function () {
        $(this).parents('form:first').resetForm();
        return false;
    });

    $.adminPage = function (config) {
        return $('<div />').adminPage(config);
    };

    $.fn.adminPage = function (config) {

        var fn = this;
        fn.addClass('adminpage');

        // Configurações
        fn.config = $.extend({
            form: this.is('form') ? this : '<form />',
            formSearch: '<form />',
            controller: CONTROLLER,
            module: MODULE,
            insertAction: 'insert',
            updateAction: 'update',
            deleteAction: 'excluir',
            selectAction: 'list',
            statusAction: 'status',
            visibleAction: 'visible',
            container: undefined,
            autoReset: true,
            autoSearch: true,
            autoEnable: true,
            autoScroll: true,
            alertSuccess: false,
            reloadSuccess: false,
            errorAlert: true,
            searchValues: {page: 1},
            insertValues: {},
            updateValues: {},
            saveValues: {},
        }, config);

        fn.config.form = $(fn.config.form);

        // Container
        if (!fn.config.container) {
            fn.container = $('<div />').insertAfter(fn.config.form);
        } else {
            fn.container = $(fn.config.container);
        }

        fn.container.addClass('adminpage-container');

        fn.setConfig = function (config) {
            fn.config = $.extend(fn.config, config);
            return fn;
        }

        // Submit
        this.config.form.submit(function () {

            try {

                var form = $(this);
                var typeAction = null;
                var values = $.extend(form.getValues(), fn.config.saveValues || {});
                var action = (form.attr("action") ? form.attr("action") : url(fn.config.controller, null, fn.config.module)) + '/';

                if (typeof values.id != 'undefined' && values.id > 0) {
                    if (fn.config.updateAction.indexOf('http') != -1) {
                        action = fn.config.updateAction;
                    } else {
                        action += fn.config.updateAction;
                    }
                    typeAction = 'update';
                    values = $.extend(values, fn.config.updateValues || {});
                } else {
                    if (fn.config.insertAction.indexOf('http') != -1) {
                        action = fn.config.insertAction;
                    } else {
                        action += fn.config.insertAction;
                    }
                    typeAction = 'insert';
                    values = $.extend(values, fn.insertValues || {});
                }

                if (form.data('status') === true) {

                    // Adicionando valores ao envio
                    form.on('addValues', function (event, _values) {
                        $.each(_values, function (index, value) {
                            values[index] = value;
                        });
                    });

                    // beforeSubmit
                    var beforeSubmit = form.triggerHandler('beforeSubmit', [values]);
                    if (beforeSubmit === false) {
                        return false;
                    } else if ($.isPlainObject(beforeSubmit)) {
                        values = $.extend(values, beforeSubmit);
                    }

                    // Transformando em string
                    $.each(values, function (key, value) {
                        if ($.isArray(value)) {
                            values[key + '_array[]'] = value;
                            values[key] = JSON.stringify(value);
                        }
                    });

                    form.ajaxSubmit({
                        url: action,
                        forceSync: true,
                        data: {ajax_serialize: JSON.stringify(values), dtCache: (new Date()).getTime()},
                        type: 'POST',
                        dataType: 'json',
                        clearForm: false,
                        resetForm: false,
                        success: function (e) {
                            _log('Success!', e);
                            if (typeof e.result !== 'undefined') {
                                if (e.result == 1) {
                                    if (fn.config.autoReset) {

                                        form.resetForm();

                                        form.filter('.modal').modal('hide');
                                        form.find(".modal").modal("hide");

                                    }
                                    // Limpando apenas campos de arquivos já enviados
                                    else {
                                        form.find('input[type=file]').prop('value', '');
                                    }

                                    if (fn.config.autoSearch) {
                                        fn.reloadSearch();
                                    }

                                    /* if (fn.config.alertSuccess) {
                                        alert(e.message);
                                    } */

                                    if (fn.config.alertSuccess && fn.config.reloadSuccess == 1) {
                                        swal({
                                            title: 'Sucesso !!',
                                            text: e.message,
                                            type: 'success',
                                        }).then(function () {
                                            window.location.reload();
                                        });

                                    } else if (fn.config.alertSuccess && fn.config.reloadSuccess.toString().search('http') != -1) {
                                        swal({
                                            title: 'Sucesso !!',
                                            text: e.message,
                                            type: 'success',
                                        }).then(function () {
                                            window.location.href = fn.config.reloadSuccess;
                                        });

                                    } else if (fn.config.alertSuccess == false && fn.config.reloadSuccess == 1) {
                                        window.location.reload();
                                    } else if (fn.config.alertSuccess == false && fn.config.reloadSuccess.toString().search('http') != -1) {
                                        window.location.href = fn.config.reloadSuccess;
                                    } else if (fn.config.alertSuccess && fn.config.reloadSuccess == false) {
                                        swal(
                                            'Sucesso !!',
                                            e.message,
                                            'success'
                                        )
                                            .then(function () {
                                                fn.trigger('swalSuccess', [e]);
                                            });
                                    }
                                } else {
                                    if (fn.config.errorAlert) {
                                        swal(
                                            'Erro !!',
                                            e.message || 'Não foi possível concluir!',
                                            'error'
                                        )
                                        /* alert(e.message || 'Não foi possível concluir!');*/
                                    }
                                }
                            }
                            fn.trigger('success', [e]);
                            if (typeAction == 'update') {
                                fn.trigger('updateSuccess', [e]);
                            } else {
                                fn.trigger('insertSuccess', [e]);
                            }
                        }, complete: function (e) {
                            form.removeClass('adminpage-loading form-loading');
                            form.data('status', true);
                            fn.trigger('complete', [e]);
                            $('html').removeClass('admpage-loading');
                        }, beforeSubmit: function () {
                            _log('Submit: ' + action);
                            form.addClass('adminpage-loading form-loading');
                            form.data('status', false);
                            $('html').addClass("admpage-loading");
                        }, error: function (e) {
                            _log('Não foi possível concluir o envio!', e.responseText);
                            form.trigger('error', [e]);
                        }, uploadProgress: function (event, position, total, percentComplete) {
                            _log('Progress:', 'Position: ' + position, 'Total: ' + total, 'PercentComplete: ' + percentComplete);
                            fn.trigger('progress', [position, total, percentComplete]);
                        }
                    });

                }

            } catch (e) {
                _log('Falha desconhecida em `this.config.form.submit`', e);
            }

            return false;

        }).data('status', true);

        // Buscar
        fn.container.on('click', '[data-page]', function () {
            fn.searchValues.page = $(this).attr('data-page') || 1;
            fn.search(fn.searchValues);
            return false;
        });

        fn.reloadSearch = function (scrollTo) {
            fn.search(fn.searchValues, scrollTo);
        }

        $(fn.config.formSearch).submit(function () {
            fn.search($(this).getValues());
            return false;
        }).attr({
            onsubmit: 'javascript: return false;',
        });

        fn.search = function (values, scrollTo) {

            var urlSearch = fn.config.selectAction.indexOf('http') != -1 ? fn.config.selectAction : url(fn.config.controller + '/' + fn.config.selectAction, null, fn.config.module);

            scrollTo = typeof scrollTo == 'undefined' ? true : scrollTo;

            // Abortando anterior
            if (fn.data('searchingAjax')) {
                fn.data('searchingAjax').abort();
            }

            fn.container.addClass('adminpage-container-loading');
            $('html').addClass("admpage-loading");

            fn.searchValues = $.extend({}, fn.config.searchValues, values || {});

            // Buscando
            fn.data('searchingAjax', $.ajax({
                type: 'POST',
                data: {ajax_serialize: JSON.stringify(fn.searchValues), dtCache: (new Date()).getTime()},
                url: urlSearch,
                dataType: 'html',
                datatype: 'html', success: function (html) {

                    var json;

                    try {
                        json = $.parseJSON(html);
                        fn.container.html(json.html);
                        html = json;
                    } catch (e) {
                        fn.container.html(html);
                    }

                    apply_masks(fn.container);

                    fn.container.find("table.sortable").each(function () {

                        $(this).sortable({
                            items: 'tbody tr[data-id]',
                            update: function (event, ui) {

                                var values = {id: '', ordem: ''};
                                var itens = fn.container.find('table.sortable tbody tr[data-id]');
                                var min = 0;

                                itens.filter('[data-ordem]').each(function () {
                                    min = Math.min(min, parseInt($(this).attr('data-ordem') || 1));
                                });

                                min = Math.max(1, min);

                                itens.each(function (index) {
                                    values.id += $(this).attr('data-id') + ',';
                                    values.ordem += min + ',';
                                    min++;
                                });

                                values.id = values.id.replace(/,$/, '');
                                values.ordem = values.ordem.replace(/,$/, '');

                                $.ajax({
                                    url: url(fn.config.controller + '/sortable', null, fn.config.module),
                                    type: "POST",
                                    dataType: "html",
                                    data: {ajax_serialize: JSON.stringify(values), dtCache: (new Date()).getTime()},
                                    complete: function () {
                                        _log('Sortable complete!');
                                    }
                                });

                            }
                        });

                        $(this).disableSelection();
                    });

                    if (scrollTo) {
                        fn.container.scrollTo();
                    }

                    fn.container.find('[data-toggle="tooltip"]').tooltip();

                    setTimeout(function () {
                        $(window).resize();
                    }, 100);

                    fn.trigger("searchSuccess", [html, json]);

                }, complete: function (e) {
                    fn.container.removeClass('adminpage-container-loading');
                    fn.trigger('searchComplete', [e]);
                    $('html').removeClass('admpage-loading');
                }, error: function (e) {
                    fn.trigger('searchError', [e]);
                }
            }));
        }

        if (fn.config.autoSearch) {
            fn.search(undefined, false);
        }

        fn.on('search', function (event, values) {
            if ($.isPlainObject(values)) {
                fn.search(values);
            } else {
                fn.search();
            }
        });

        // Status
        fn.container.on('click', '[data-status]', function () {
            updateStatus(this, $(this).attr('data-status'), fn.config.statusAction);
        });

        function updateStatus(btn, id, action) {

            btn = $(btn);

            if (btn.data('ajaxStatus')) {
                btn.data('ajaxStatus').abort();
            }

            btn.filter('.fa').toggleClass('fa-eye fa-eye-slash');
            btn.children('.fa').filter('.fa-eye, .fa-eye-slash').toggleClass('fa-eye fa-eye-slash');

            btn.data('ajaxStatus', $.ajax({
                url: url(fn.config.controller + '/' + action, null, fn.config.module),
                data: {ajax_serialize: JSON.stringify({id: id}), dtCache: (new Date()).getTime()},
                type: "POST",
                dataType: "HTML",
                success: function (e) {
                    if (e != '') {
                        try {
                            var json = $.parseJSON(e);
                            if (json.result != 1 && fn.config.errorAlert) {
                                swal({
                                    title: 'Erro !!',
                                    text: json.message || 'Não foi possível alterar o status.',
                                    type: 'error',
                                }).then(function () {
                                    fn.reloadSearch();
                                });
                                /* alert(json.message || 'Não foi possível alterar o status.'); */

                            }
                        } catch (ex) {
                            fn.reloadSearch();
                        }
                    } else {
                        fn.reloadSearch();
                    }
                }
            }));
        }

        // Visible
        fn.container.on('click', '[data-visible]', function () {
            updateStatus(this, $(this).attr('data-visible'), fn.config.visibleAction);
        });

        // Editando
        fn.container.on('click', '[data-editar]', function () {
            fn.config.form.setValues($(this).attr('data-editar'));
        });

        // Excluir
        fn.container.on('click', '[data-excluir]', function () {
            var action = fn.config.deleteAction.indexOf('http') != -1 ? fn.config.deleteAction : url(fn.config.controller + '/' + fn.config.deleteAction, null, fn.config.module);
            var id = $(this).attr('data-excluir');
            swal({
                title: 'Atenção !!!',
                text: "Deseja excluir o registro ? ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then(function () {
                $.post(action, {id: id}, function (e) {
                    try {
                        e = $.parseJSON(e);
                        if (e.result == 1) {
                            fn.reloadSearch(false);
                        } else {
                            swal(
                                'Erro !!',
                                e.message,
                                'error'
                            );
                        }
                    } catch (e) {
                        fn.reloadSearch(false);
                    }
                }, 'html').fail(function (e) {
                    fn.reloadSearch();
                });
            });

        });

        this.data('adminPage', fn);

        return fn;

    }

    $('form[data-adminpage]').each(function () {
        var values = $(this).attr('data-adminpage');
        try {
            $(this).adminPage($.parseJSON(values));
        } catch (e) {
            $(this).adminPage({});
        }
    });

    FastClick.attach(document.body);

})(jQuery);

// CKEditor
(function () {

    if (typeof CKEDITOR != 'undefined') {

        $.fn.loadCkeditor = function (config) {

            if (this.length == 1) {
                var txt = $(this);
                var type = txt.attr("data-ckeditor");
                var id = this.attr('id') || 'ckeditor' + Math.floor(Math.random() * 99999);

                this.attr('id', id).addClass('has-ckeditor');

                var editor;

                if (!config) {
                    if (type == 'simples') {
                        editor = CKEDITOR.replace(id, {
                            language: 'pt-br',
                            height: txt.attr('height') || 200,
                            toolbar: [
                                {
                                    name: 'basicstyles',
                                    groups: ['basicstyles', 'cleanup'],
                                    items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
                                },
                                {name: 'links', items: ['Link', 'Unlink']},
                                {name: 'styles', items: ['Font', 'FontSize']},
                                //'/',
                                {name: 'colors', items: ['TextColor', 'BGColor']},
                                {
                                    name: 'paragraph',
                                    groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                                },
                                {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']},
                            ]
                        });
                    } else {
                        editor = CKEDITOR.replace(id, {
                            language: 'pt-br',
                            height: txt.attr('height') || 200,
                            contentsCss: [
                                'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
                                'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
                            ],
                            toolbar: [
                                {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source']},
                                {
                                    name: 'clipboard',
                                    groups: ['clipboard', 'undo'],
                                    items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                                },
                                {
                                    name: 'editing',
                                    groups: ['find', 'selection', 'spellchecker'],
                                    items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                                },
                                {
                                    name: 'basicstyles',
                                    groups: ['basicstyles', 'cleanup'],
                                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
                                },
                                //'/',
                                {
                                    name: 'paragraph',
                                    groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
                                },
                                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                                {
                                    name: 'insert',
                                    items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
                                },
                                //'/',
                                {name: 'styles', items: ['Format', 'Font', 'FontSize']},
                                {name: 'colors', items: ['TextColor', 'BGColor']},
                                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                                {name: 'others', items: ['-']},
                            ]
                        });
                    }
                } else {
                    editor = CKEDITOR.replace(id, config);
                }

                this.data('ckeditor', editor);

                setTimeout(function () {
                    $(window).resize();
                }, 200);

            } else {
                this.each(function () {
                    $(this).loadCkeditor(config);
                })
            }


            return this;

        }

        $('textarea[data-ckeditor]').loadCkeditor();

    }

    /**
     * Abre uma modal para posicionar no mapa
     */
    $('form button[data-marker], form .btn-marker').each(function () {

        var btn = $(this);
        var form = btn.parents('form:first');

        btn.click(function () {

            var parans = $.param({
                'latitude': form.find('[name=latitude], .end-latitude').first().prop('value') || 0,
                'longitude': form.find('[name=longitude], .end-longitude').first().prop('value') || 0,
                'zoom': form.find('[name=zoom], .end-zoom').first().prop('value') || 0,
            });

            var w = modalIframe('Geolocalização', url('mapa') + '?' + parans);

            w.on('close', function () {
                var p = w.find('iframe')[0].contentWindow.getPosition;
                if (typeof p != 'undefined' && $.isFunction(p)) {
                    p = p();
                    form.find('[name=latitude], .end-latitude').prop('value', p.latitude).change();
                    form.find('[name=longitude], .end-longitude').prop('value', p.longitude).change();
                    form.find('[name=zoom], .end-zoom').prop('value', p.zoom).change();
                }
            });

        })

    });

})(jQuery);

function modalIframe(title, src) {

    var w = jQuery('<div class="modal fade" style="z-index: 99999;" >'
        + '<div class="modal-dialog modal-lg">'
        + '<div class="modal-content">'
        + '<div class="modal-header">'
        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
        + '<h4 class="modal-title">' + (title || 'Imagens') + '</h4>'
        + '</div>'
        + '<div class="modal-body">'
        + '<div class="iframe" >'
        + '<iframe style="height: 450px; width: 100%; border: none; display: block; margin: 0;" ></iframe>'
        + '</div>'//iframe
        + '</div>'//modal-body
        + '</div>'//modal-content
        + '</div>'//modal-dialog
        + '</div>'//modal
    );

    var iframe = w.find('.iframe iframe');

    iframe.on('close', function () {
        w.trigger('close', [iframe]);
    })

    w.on('hide.bs.modal', function () {
        w.trigger('close', [iframe]);
        iframe.trigger('close');
    });

    w.on('shown.bs.modal', function () {
        iframe.prop('src', src).load(function () {

            $(this).contents().find('.btn-close').click(function () {
                w.modal('hide');
            });

        });
    });

    w.on('hidden.bs.modal', function () {
        iframe.unload();
        w.trigger('closed', [iframe]);
        setTimeout(function () {
            w.remove();
        }, 500);
    });

    w.modal('show');
    jQuery('body').prepend(w);

    return w;

}

function galeria(ref, refid, title) {
    return modalIframe(title || 'Imagens', url('imagens/iframe') + '?' + $.param({
        'ref': ref,
        'refid': refid,
        'title': title
    }));
}

/**
 * Envia notificação
 * @param {string} title
 * @param {string} body
 * @param {string} icon
 * @returns {Notification}
 */
function sendNotification(title, body, icon) {
    // Enviando notificação
    if (Notification.permission === "granted") {
        return new Notification(title, {
            icon: icon,
            body: body,
        });
    }
    // Pegando autorização
    else {
        Notification.requestPermission(function (permission) {
            if (permission == "granted") {
                return sendNotification(title, body, icon);
            }
        });
    }
}

$(document).on('change', '.btn-inputfile input', function () {

    var $input = $(this);
    var $btn = $input.closest('.btn-inputfile');

    if (this.files.length == 1) {
        $btn.find("span span").html(this.files[0].name.toString().replace(/.*\./, ''));
    } else if (this.files.length > 1) {
        $btn.find("span span").html(this.files.length + ' Arquivos');
    } else {
        $btn.find("span span").html('');
    }
});

$(document).on('change', 'input[type=file]', function () {

    var maxFileSize = 1 * 1024 * 1024;

    var input = $(this);

    $.each(this.files, function (index, file) {
        if (file.type == 'application/x-zip-compressed') {
            if (file.size > maxFileSize * 5) {
                swal(
                    'Oops...',
                    'Selecione arquivo (zip, rar) de no máximo 5MB. !!',
                    'error'
                );
                /* alert('Selecione arquivo (zip, rar) de no máximo 5MB.'); */
                input.prop('value', '').change();
            }
        } else if (file.type == 'application/pdf') {
            if (file.size > maxFileSize * 5) {
                swal(
                    'Oops...',
                    'Selecione arquivo (pdf) de no máximo 5MB. !!',
                    'error'
                );
                /*  alert('Selecione arquivo (pdf) de no máximo 5MB.'); */
                input.prop('value', '').change();
            }
        } else if (file.size > maxFileSize * 5) {
            swal(
                'Oops...',
                'Selecione arquivos de no máximo 5MB. !!',
                'error'
            );
            input.prop('value', '').change();
        }
    });
});

if (typeof Clipboard != 'undefined') {
    var clipboard = new Clipboard('[data-clipboard-text]');

    clipboard.on('success', function (e) {
        alert('URL copiada com sucesso.');
        e.clearSelection();
    });

    clipboard.on('error', function (e) {
        alert('Não foi possível copiar a URL.');
    });
}

$(window)
    .load(function () {
        $('html').removeClass("pre-loading");
    })
    .on('beforeunload', function () {
        $('html').addClass('pre-loading');
    });

$(document)
    .on("focus", "[type=password][readonly]", function () {
        $(this).prop('readonly', false);
    });

$('select[data-options]')
    .each(function () {
        if (!$(this).hasClass('loaded-options')) {

            var group = $(this).data('options');

            var select = $('select[data-options="' + group + '"]')
                .addClass("loaded-options");

            $.get(group, function (html) {

                select.append(html);

                select
                    .filter('[data-setvalue]')
                    .each(function () {
                        $(this).find('option[value="' + $(this).data('setvalue') + '"]').prop("selected", true);
                    })

                select.trigger("chosen:updated");
            });

        }
    });