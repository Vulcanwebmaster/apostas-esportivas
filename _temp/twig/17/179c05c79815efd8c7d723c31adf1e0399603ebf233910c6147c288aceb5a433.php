<?php

/* admin/jogos/placares.twig */
class __TwigTemplate_909c9e53a34acd0726991bd3987ae9eb10051a3b5ea82303bb6645beff4c506f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/jogos/placares.twig", 1);
        $this->blocks = array(
            'links' => array($this, 'block_links'),
            'main' => array($this, 'block_main'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_links($context, array $blocks = array())
    {
        // line 4
        echo "
    <button type=\"button\" class=\"btn-importar btn btn-primary\">
        <i class=\"fa fa-upload\"></i> Importar placares
    </button>

";
    }

    // line 11
    public function block_main($context, array $blocks = array())
    {
        // line 12
        echo "
    ";
        // line 13
        $this->loadTemplate("admin/inc/modal-placar.twig", "admin/jogos/placares.twig", 13)->display($context);
        // line 14
        echo "
    <div class=\"modalSimulado modal fade\">
        <div class=\"modal-dialog modal-md\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Simulação de Placares</h3>
                </div>
                <div class=\"modal-body no-padding\">
                    <div class=\"hide\">
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-hover table-bordered table-minified lista-table\">
                                <thead>
                                <tr>
                                    <th>Times/Campeonato</th>
                                    <th width=\"120\">Data/Hora</th>
                                    <th width=\"120\">Tipo/Cotação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class=\"aposta-item\">
                                    <td class=\"text-center\"><span class=\"td-timecasa\">Celta de Vigo</span> x <span
                                                class=\"td-timefora\">Málaga</span> <br> <b class=\"td-campeonato\">Liga
                                            BBVA</b></td>
                                    <td class=\"text-center\"><span class=\"td-data\">08/05/2016</span><br><span
                                                class=\"td-hora\">12:00</span></td>
                                    <td class=\"text-center\"><span class=\"td-tipo\">Fora</span><br><b
                                                class=\"td-cotacao\">5,75</b></td>
                                </tr>
                                <tr class=\"aposta-item\">
                                    <td class=\"text-center\"><span class=\"td-timecasa\">Real Madrid</span> x <span
                                                class=\"td-timefora\">Atlético de Madrid</span> <br> <b
                                                class=\"td-campeonato\">Champions
                                            League</b></td>
                                    <td class=\"text-center\"><span class=\"td-data\">28/05/2016</span><br><span
                                                class=\"td-hora\">15:45</span></td>
                                    <td class=\"text-center\"><span class=\"td-tipo\">Fora</span><br><b
                                                class=\"td-cotacao\">3.5</b></td>
                                </tr>
                                <tr class=\"aposta-item\">
                                    <td class=\"text-center\"><span class=\"td-timecasa\">Real Madrid</span> x <span
                                                class=\"td-timefora\">Atlético de Madrid</span> <br> <b
                                                class=\"td-campeonato\">Champions
                                            League</b></td>
                                    <td class=\"text-center\"><span class=\"td-data\">28/05/2016</span><br><span
                                                class=\"td-hora\">15:45</span></td>
                                    <td class=\"text-center\"><span class=\"td-tipo\">Casa</span><br><b
                                                class=\"td-cotacao\">2.5</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class=\"text-center\">
                            <p>
                                <b>Apostas Ganhas:</b> 12 <br/>
                                <b>Valores apostados:</b> R\$ 1.264 <br/>
                                <b>Valores a receber:</b> R\$ 3.191 <br/>
                                <b>Valores de Comissões pagas:</b> R\$ 500,00 <br/>
                                <b>Qtd. Jogos:</b> 5/15 <br/>
                            </p>
                        </div>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <a href=\"#\" onclick=\"javascript:\$(this).parents('.modal').modal('hide');\" class=\"btn btn-default\">
                        <i class=\"fa fa-times\"></i>
                        Fechar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form class=\"admpage-form-search panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"row\">
                <div class=\"col-md-3 col-sm-12 col-xs-12\">
                    <label><b>Data de Cadastro</b></label>
                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                          data-content=\"Digite ou selecione a data de cadastro.\"
                          data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                    <input type=\"date\" name=\"datacadastro\" class=\"form-control\">
                </div>
                <div class=\"col-md-3 col-sm-12 col-xs-12\">
                    <label><b>Data do Jogo</b></label>
                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                          data-content=\"Digite ou selecione a data do jogo.\"
                          data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                    <input type=\"date\" name=\"data\" class=\"form-control\">
                </div>
                <div class=\"col-md-3 col-sm-12 col-xs-12\">
                    <label><b>Nome da Equipe</b></label>
                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                          data-content=\"Digite o nome da equipe\"
                          data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                    <input type=\"text\" name=\"search\" class=\"form-control\">
                </div>
                <div class=\"col-md-3 col-sm-12 col-xs-12\">
                    <label><b>Campeonato</b></label>
                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                          data-content=\"Selecione um campeonato\"
                          data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                    <select name=\"campeonato\" class=\"form-control\" data-options=\"";
        // line 116
        echo twig_escape_filter($this->env, ($context["module"] ?? null), "html", null, true);
        echo "/cadastros/campeonatos/options\">
                        <option value> -- Selecione --</option>
                    </select>
                </div>
            </div>
        </div>
        <div class=\"panel-footer text-right\">
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"fa fa-search\"></i> Buscar
            </button>
        </div>
    </form>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading clearfix\">
            <h4 class=\"panel-title\">Placares</h4>

            <div class=\"pull-right m-t-minus-9 hide\">
                <button class=\"btn btn-info\" type=\"button\" onClick=\"placar.simular();\">
                    <i class=\"fa fa-check\"></i> Simular
                </button>
            </div>

        </div>
        <div class=\"panel-body panel-table\">
            <div class=\"table-responsive\">
                <div class=\"page-container\">
                    <table class=\"table hide table-minified table-bordered table-striped list-table\">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Campeonato</th>
                            <th>Casa/Fora</th>
                            <th>Placar</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Brasileiro</td>
                            <td class=\"text-center\">São Paulo x Palmeiras<br/>
                                <small>01/05/2016 - 15:05:00</small>
                            </td>
                            <td class=\"text-center\">
                                <form method=\"post\" action=\"\" class=\"form-inline\" onsubmit=\"\">

                                    <div class=\"form-group m-r-xs\">
                                        <label class=\"sr-only\" for=\"time_casa\">Time da Casa</label>
                                        <input type=\"number\" min=\"0\" max=\"10\" class=\"form-control input-sm input-placar\"
                                               name=\"timecasaplacar\" id=\"time_casa\" placeholder=\"0\" required=\"\">
                                    </div>

                                    <div class=\"form-group m-r-xs\">
                                        x
                                    </div>

                                    <div class=\"form-group m-r-xs\">
                                        <label class=\"sr-only\" for=\"time_fora\">Time de Fora</label>
                                        <input type=\"number\" min=\"0\" max=\"10\" class=\"form-control input-sm input-placar\"
                                               name=\"timeforaplacar\" id=\"time_fora\" placeholder=\"0\" required=\"\">
                                    </div>

                                    <button type=\"submit\" class=\"btn btn-success\" data-toggle=\"tooltip\"
                                            onclick=\"javascript:return confirm('Definir placar do jogo?');\"><i
                                                class=\"fa fa-save\"></i></button>
                                </form>
                            </td>
                            <td class=\"text-center\">
                                <div class=\"btn-group\">
                                    <div href=\"\" class=\"btn btn-default\"><i class=\"fa fa-edit\"></i></div>
                                    <div href=\"\" class=\"btn btn-danger\"><i class=\"fa fa-trash-o\"></i></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

";
    }

    // line 200
    public function block_script($context, array $blocks = array())
    {
        // line 201
        echo "
    <script>

        var page;

        \$(function () {

            var container = \$('.page-container');

            page = \$('<div />').adminPage({
                formSearch: '.page-form-search',
                container: container,
                insertAction: '',
            });

            container
                .on('click', '[data-placar]', function () {
                    \$('.modal-placar')
                        .setValues({
                            jogo: \$(this).data('placar'),
                        })
                        .find('.jogo-times')
                        .html(\$(this).data('title'));
                });


            var placar = {
                modal: \$('.modalSimulado'),
                simular: function () {

                    placar.modal.modal('show');

                    placar.modal
                        .find('.modal-body')
                        .html('<div class=\"m-t-lg m-l-lg m-b-lg m-r-lg alert alert-info\" >Gerando simulação...</div>');

                    \$.post(url(CONTROLLER + '/simulacao'), {
                        jogos: placar.getPlacaresDefinidos(),
                    }, function (html) {
                        placar.modal.find('.modal-body').html(html);
                    }, 'html');

                },
                getPlacaresDefinidos: function () {
                    var values = {};

                    \$('.page-container .tr-jogo').filter(function () {
                        var campos = \$(this).find(\".input-placar\");
                        var algumVazio = false;

                        campos.each(function () {
                            if (this.value === '') {
                                algumVazio = true;
                            }
                        });

                        return !algumVazio;

                    }).each(function () {
                        values[\$(this).attr('data-token')] = {
                            timeCasa: \$(this).find('[name=timecasaplacar]').val(),
                            timeFora: \$(this).find('[name=timeforaplacar]').val(),
                        };
                    });

                    return values;

                }
            };

            \$('.btn-importar')
                .on(\"click\", function () {
                    if (confirm(\"Deseja importar os placares?\")) {

                        \$('html').addClass('page-loading');

                        \$
                            .post(url('jogos/definirplacares/importarPlacares'), function (e) {
                                alert(e.message);
                            }, 'json')
                            .always(function () {
                                \$('html').removeClass('page-loading');
                            });
                    }
                });

        });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/jogos/placares.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  248 => 201,  245 => 200,  158 => 116,  54 => 14,  52 => 13,  49 => 12,  46 => 11,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/jogos/placares.twig", "/home2/bets01/public_html/app/views/admin/jogos/placares.twig");
    }
}
