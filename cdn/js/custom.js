$(document).ready(function () {

    if (!Modernizr.inputtypes.date) {
        $('.date-picker').datepicker({language: "pt-BR", orientation: "top auto", autoclose: true});
    } else {
        $('.date-picker').prop('type', 'date');
    }

    $('.time-picker').timepicker({showMeridian: false});
    $('.select2').select2();

    // Modal placar
    $('.modal-placar')
        .adminPage({
            autoSearch: false,
            controller: 'jogos/jogo',
            insertAction: 'placar',
        })
        .on('success', function () {
            if (typeof page != 'undefined') {
                page.reloadSearch();
            }
        });

});

// modal-editar-aposta
$(function () {

    var form = $('.modal-editar-aposta');

    if (form.length) {

        form.data("status", true);

        var containerJogos = $('.jogos-selecionados-lista', form);
        var tpl = containerJogos.find('.jogo-selecionado').remove();
        var openModalEditar = function (json) {
            try {

                var token = json.token;

                form.find('.aposta-nome').html(json.apostadornome);
                form.find('.aposta-id').html(json.id);
                form.find('.aposta-telefone').html(json.apostadortelefone);

                form.data("token", token);

                form.find(".modal-footer").addClass('hide');

                form
                    .setValues(json)
                    .modal("show");

                containerJogos
                    .html("Carregando jogos da aposta...");

                $.get(url('apostas/aposta/jogos', [token], 'admin'), function (j) {
                    if (j.result == 1) {

                        containerJogos.html("");

                        if (j.editavel) {
                            form.find(".modal-footer").removeClass('hide');
                        }

                        $.each(j.jogos, function (index, jogo) {

                            var div = tpl.clone();

                            if (jogo.cancelado) {
                                div.addClass('cancelado');
                            }

                            div.data("token", jogo.token);
                            div.find(".casa").html(jogo.timecasa);
                            div.find(".fora").html(jogo.timefora);
                            div.find(".tempo").html(jogo.data);
                            div.find(".cotacao").html(jogo.cotacao);
                            div.find(".campeonato").html(jogo.campeonato);
                            div.find(".tempo-cotacao").html(jogo.tempo);

                            if (!jogo.editavel) {
                                div.find(".btn-exclui").remove();
                            }

                            if (jogo.verificado) {
                                div.addClass(jogo.ganhou ? 'ganhou' : 'perdeu');
                            }

                            containerJogos.append(div);

                        });

                    } else {
                        alert(j.message);
                    }
                }, 'json');

            } catch (err) {
                form.modal("hide");
            }
        };

        $(document)
            .on('click', '.btn-cancelar-aposta', function () {
                if (form.data("status") == true) {
                    var token = form.data("token");
                    swal({
                        title: 'Deseja prosseguir com o cancelamento ?',
                        text: "Se cancelar essa aposta será cobrado 10% de taxa sendo reembolsado apenas 90% do valor apostado.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sim',
                        cancelButtonText: "Não"
                    }).then(function () {
                        form.data("status", false);
                        $
                            .post(url('apostas/aposta/cancelar'), {aposta: token}, function (e) {
                                if (e.result == 1) {

                                    swal({
                                        title: 'Sucesso !!',
                                        text: e.message,
                                        type: 'success',
                                    }).then(function () {
                                        window.location.reload();
                                    });

                                } else {

                                    swal(
                                        'Erro !!',
                                        e.message,
                                        'error'
                                    );

                                }
                            }, 'json')
                            .always(function () {
                                form.data("status", true);
                            });
                    });

                }
            })
            .on('click', '.jogo-selecionado .btn-exclui', function () {
                if (form.data("status") == true) {
                    var div = $(this).parents('.jogo-selecionado');
                    var token = div.data("token");
                    var aposta = form.data("token");
                    swal({
                        title: 'Deseja prosseguir com a exclusão ?',
                        text: "Se excluir esse jogo a cotação será atualizada e o retorno será recalculado com 10% de taxa.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'
                    }).then(function () {

                        div.addClass('hide');

                        form.data("status", false);

                        $
                            .post(url("apostas/aposta/cancelarjogo"), {
                                aposta: aposta,
                                jogo: token
                            }, function (e) {
                                if (e.result == 1) {

                                    openModalEditar(e.aposta);

                                    if (page) {
                                        page.reloadSearch();
                                    }
                                } else {
                                    div.removeClass('hide');
                                    swal(
                                        'Erro !!',
                                        e.message,
                                        'error'
                                    );
                                }
                            }, 'json')
                            .always(function () {
                                form.data("status", true);
                            });

                    });
                }
            })
            .on('click', '[data-editar-aposta]', function () {
                var json = JSON.parse($(this).attr('data-editar-aposta'));
                openModalEditar(json);
            });

    }

});

$('.modal-saque')
    .data("status", true)
    .on('show.bs.modal', function () {
        var form = $(this);
        if (form.data('status')) {
            form.data("status", false);
            $.get(url('saques/dadosbancarios'), {}, function (j) {
                if (j.result == 1) {
                    form.setValues(j.dados);
                }
            }, 'json')
                .always(function () {
                    form.data('status', true);
                });
        }
    })
    .on("change", '[name=tipo]', function () {
        var modal = $(this).closest('.modal');
        modal.find(".tipos").children().addClass('hide');
        modal.find(".tipos .tipo-" + this.value).removeClass('hide');
    })
    .adminPage({
        controller: 'saques',
        autoSearch: false,
        alertSuccess: true,
        reloadSuccess: true,
    });