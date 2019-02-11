<?php

/* admin/importar/jogos.twig */
class __TwigTemplate_38268a923dfc5bd3f7c07e9b97574a6ade2841c5cad9764100f6352195f6e68c extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/importar/jogos.twig", 1);
        $this->blocks = array(
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
    public function block_main($context, array $blocks = array())
    {
        // line 4
        echo "    <style>

        .form-jogos th, .form-jogos td {
            vertical-align: middle !important;
        }

    </style>

    <form class=\"text-right m-b-30 form-cotacoes geral\">
        <div class=\"form-inline\">
            <div class=\"input-group\">
                <div class=\"input-group-addon\">Tipo</div>
                <select class=\"form-control\" name=\"tipo\">
                    <option value=\"%\">%</option>
                    <option value=\"\$\">\$</option>
                </select>
                <div class=\"input-group-addon\">Valor</div>
                <input type=\"number\" name=\"percent\" step=\"1\" value=\"0\" min=\"-500\" max=\"500\" class=\"form-control\"/>
                <div class=\"input-group-btn\">
                    <button type=\"submit\" class=\"btn btn-success btn-aplicar\">
                        <i class=\"fa fa-check\"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form class=\"form-jogos\" onsubmit=\"return false;\">

        <div class=\"panel panel-default panel-jogos\">
            <div class=\"panel-heading\"></div>
            <div class=\"panel-body p-0\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered m-b-0 table-hover table-minify\">
                        <thead>
                        <tr>
                            <th width=\"80\"><input type=\"checkbox\" name=\"input_jogos\" checked/></th>
                            <th width=\"100\">Data/Hora</th>
                            <th>Time casa x Time fora</th>
                            ";
        // line 43
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 44
            echo "                                <th width=\"100\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["cotacoes"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5[$context["i"]] ?? null) : null), "getSigla", array(), "method"), "html", null, true);
            echo "</th>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "                        </tr>
                        </thead>
                        <tbody>
                        <td><input type=\"checkbox\" name=\"jogo\" class=\"input-jogo m-0\" checked/></td>
                        <td>
                            <div class=\"data\"></div>
                            <div class=\"hora\"></div>
                        </td>
                        <td>
                            <div class=\"title\"></div>
                            <a href='#cotacoes' class=\"ver-cotacoes\">Ver todas as cotações</a>
                        </td>
                        ";
        // line 58
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 59
            echo "                            <td>
                                ";
            // line 60
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["tempos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["tempo"]) {
                // line 61
                echo "                                    <div>
                                        <b>";
                // line 62
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
                echo ":</b>
                                        <span data-cotacao='";
                // line 63
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a = ($context["cotacoes"] ?? null)) && is_array($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a) || $__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a instanceof ArrayAccess ? ($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a[$context["i"]] ?? null) : null), "getCampo", array(), "method"), "html", null, true);
                echo "'></span>
                                    </div>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tempo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 66
            echo "                            </td>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        echo "                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class=\"container-tabelas\"></div>
        <div class=\"text-right p-b-20\">
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"fa fa-upload\"></i> Importar Jogos
            </button>
        </div>
    </form>

    <!-- Modal Mais cotações !-->
    <div class=\"modal fade modal-cotacoes\" id=\"modal-cotacoes\" tabindex=\"-1\" role=\"dialog\"
         aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-lg\" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"exampleModalLabel\">Mais Cotações</h5>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>
                <div class=\"modal-body\">

                    <form class=\"text-center m-b-20 form-cotacoes jogo\">
                        <input type=\"hidden\" name=\"refid\"/>
                        <div class=\"form-inline\">
                            <div class=\"input-group\">
                                <div class=\"input-group-addon\">Tipo</div>
                                <select class=\"form-control\" name=\"tipo\">
                                    <option value=\"%\">%</option>
                                    <option value=\"\$\">\$</option>
                                </select>
                                <div class=\"input-group-addon\">Valor</div>
                                <input type=\"number\" name=\"percent\" step=\"1\" value=\"0\" min=\"-500\" max=\"500\"
                                       class=\"form-control\"/>
                                <div class=\"input-group-btn\">
                                    <button type=\"submit\" class=\"btn btn-success btn-aplicar\">
                                        <i class=\"fa fa-check\"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class=\"info-jogo\">
                        <div class=\"row\">
                            <div class=\"col-md-3 col-sm-12 col-xs-12 text-center\">
                                <i class=\"fa fa-clock-o\"></i> <span class=\"data\"></span>
                                <div class=\"dia-semana\"></div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12 text-center\">
                                <div class=\"times text-uppercase\">
                                    <span class=\"casa\"></span>
                                    <span>X</span>
                                    <span class=\"fora\"></span>
                                </div>
                            </div>
                            <div class=\"col-md-3 col-sm-12 col-xs-12 text-center\">
                                <div class=\"campeonato\"></div>
                            </div>
                        </div>
                    </div>
                    <ul class=\"nav nav-tabs\" role=\"tablist\">
                        ";
        // line 135
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tempos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["tempo"]) {
            // line 136
            echo "                            <li class=\"nav-item ";
            echo (((twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()) == "90")) ? ("active") : (null));
            echo "\">
                                <a class=\"nav-link\" href=\"#tab-";
            // line 137
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "\" role=\"tab\" data-toggle=\"tab\">
                                    <span class=\"hidden-sm hidden-xs\">";
            // line 138
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "</span>
                                    <span class=\"hidden-md hidden-lg\">";
            // line 139
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "title", array()), "html", null, true);
            echo "</span>
                                </a>
                            </li>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tempo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 143
        echo "                    </ul>

                    <!-- Tab panes -->
                    <div class=\"tab-content p-0 p-t-20\">

                        ";
        // line 148
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tempos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["tempo"]) {
            // line 149
            echo "                            <div role=\"tabpanel\" class=\"tab-pane fade ";
            echo twig_escape_filter($this->env, ($context["active"] ?? null), "html", null, true);
            echo "\" id=\"tab-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "\">
                                <div class=\"botoes-cotacoes modal-botoes\">
                                    <h4>";
            // line 151
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "title", array()), "html", null, true);
            echo "</h4>
                                    ";
            // line 152
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["grupos"] ?? null));
            foreach ($context['_seq'] as $context["idGrupo"] => $context["grupo"]) {
                // line 153
                echo "                                        ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["cotacoes"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["cotacao"]) {
                    // line 154
                    echo "                                            ";
                    if ((twig_get_attribute($this->env, $this->source, ($context["c"] ?? null), "getGrupo", array(), "method") == $context["idGrupo"])) {
                        // line 155
                        echo "                                                <div class=\"btn btn-cotacao\">
                                                    <div>";
                        // line 156
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["c"] ?? null), "getSigla", array(), "method"), "html", null, true);
                        echo "</div>
                                                    <div class=\"valor\"
                                                         data-cotacao=\"";
                        // line 158
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
                        echo "-";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["c"] ?? null), "getCampo", array(), "method"), "html", null, true);
                        echo "\">0.00
                                                    </div>
                                                </div>
                                            ";
                    }
                    // line 162
                    echo "                                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cotacao'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 163
                echo "                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['idGrupo'], $context['grupo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 164
            echo "                                </div>
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tempo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 167
        echo "
                    </div>

                </div>
            </div>
        </div>
    </div>

";
    }

    // line 177
    public function block_script($context, array $blocks = array())
    {
        // line 178
        echo "
    <script>

        \$(function () {

            var form = \$('.form-jogos');
            var modal = \$('.modal-cotacoes');
            var tplTr = \$('.panel-jogos tbody tr').addClass('tr-jogo').clone();
            \$('.panel-jogos tbody tr').remove();
            var tpl = \$('.panel-jogos').clone();
            \$('.panel-jogos').remove();

            \$('html').addClass('page-loading');

            \$.get(url('importar/marjosports/jogos'), function (json) {

                \$.each(json.jogos, function (index, jogo) {
                    if (!\$.isPlainObject(jogo.cotacoes)) {
                        console.log(\"Não é um objeto\", jogo.cotacoes);
                    } else {
                        \$.each(jogo.cotacoes, function (index, cotacoes) {
                            if (!\$.isPlainObject(cotacoes)) {
                                console.log(\"Não é um objeto\", jogo.cotacoes);
                            }
                        });
                    }
                });

                console.log(\"Inicia outra lista\");

                if (json.campeonatos) {
                    \$.each(json.campeonatos, function (index, campeonato) {

                        var tb = tpl.clone();

                        tb.find('.panel-heading').html(campeonato);

                        \$.each(json.jogos, function (index, jogo) {
                            if (jogo && jogo.campeonato == campeonato) {

                                var tr = tplTr.clone();
                                var title = jogo.timecasa + ' <img src=\"' + jogo.timecasaimg + '\"/> x <img src=\"' + jogo.timeforaimg + '\"/> ' + jogo.timefora;

                                tr.attr(\"data-title\", title);
                                tr.attr(\"data-ref\", jogo.refid);
                                tr.data(\"dados\", jogo);

                                tr.find(\".input-jogo\").val(jogo.refid);
                                tr.find(\".title\").html(title);
                                tr.find(\".data\").html(jogo.data.split('-').reverse().join('/'));
                                tr.find(\".hora\").html(jogo.hora);

                                \$.each(jogo.cotacoes, function (tempo, values) {
                                    if (\$.isPlainObject(values)) {
                                        \$.each(values, function (campo, valor) {
                                            tr.find('[data-cotacao=\"' + tempo + '-' + campo + '\"]').html(valor);
                                        });
                                    }
                                });

                                tb.find(\"tbody\").append(tr);
                            }
                        });

                        \$('.container-tabelas').append(tb);

                        tb.find(\"input[type=checkbox]\").uniform();

                    });
                }
                \$('html').removeClass('page-loading');

            }, 'json');

            \$(document)
                .on(\"change\", \"input[name=input_jogos]\", function () {
                    var tb = \$(this).closest('table');
                    var inputs = tb.find('input[type=checkbox]');
                    inputs.prop('checked', \$(this).prop('checked'));
                    inputs.uniform();
                })
                .on(\"change\", \"input[name=jogo]\", function () {

                    var tb = \$(this).closest('table');
                    var inputs = tb.find('input[type=checkbox][name=jogo]');
                    var master = tb.find('input[name=input_jogos]');

                    var notCheckeds = inputs.filter(\":not(:checked)\");

                    if (notCheckeds && notCheckeds.length > 0) {
                        master.prop('checked', false);
                    } else {
                        master.prop('checked', true);
                    }

                    inputs.uniform();
                    master.uniform();

                });

            \$('.form-cotacoes')
                .on('submit', function (e) {

                    e.preventDefault();

                    var form = \$(this);
                    var geral = form.hasClass('geral');

                    var refid = \$('[name=refid]', form).val();

                    var tipo = \$('[name=tipo]', form).val();
                    var valueInput = parseFloat(\$('[name=percent]', form).val());
                    var valor = tipo == '%' ? 0 : valueInput;
                    var percent = tipo == '\$' ? 1 : (valueInput + 100) / 100;

                    \$('.tr-jogo')
                        .each(function () {

                            var row = \$(this);
                            var jogoValues = row.data(\"dados\");

                            if (geral || jogoValues.refid == refid) {

                                var cotacoes = jogoValues.cotacoes;

                                if (cotacoes) {
                                    \$.each(cotacoes, function (tempo, values) {
                                        if (\$.isPlainObject(values)) {
                                            \$.each(values, function (index, value) {
                                                value = value * percent + valor;
                                                cotacoes[tempo][index] = parseFloat(value.toFixed(2));
                                                row.find('[data-cotacao=\"' + tempo + '-' + index + '\"]').html(cotacoes[tempo][index].toFixed(2));
                                            });
                                        }
                                    });
                                }

                                jogoValues.cotacoes = cotacoes;
                                row.data(\"dados\", jogoValues);

                                if (!geral) {
                                    modalCotacoes(null, jogoValues);
                                }

                            }
                        });

                    return false;

                });

            \$(document)
                .on(\"click\", '.ver-cotacoes', function (e) {

                    e.preventDefault();

                    var row = \$(this).closest('tr');
                    var jogoValues = row.data(\"dados\");

                    modalCotacoes(row.data(\"title\"), jogoValues);

                    return false;

                });

            function modalCotacoes(title, jogoValues) {

                var cotacoes = jogoValues.cotacoes;

                modal.find(\".form-cotacoes [name=refid]\").val(jogoValues.refid);

                modal.modal(\"show\");

                if (title) {
                    modal.find(\".modal-title\").html(title);
                }

                modal.find(\".casa\").html(jogoValues.timecasa);
                modal.find(\".data\").html(jogoValues.data.split('-').reverse().join('/') + ' às ' + jogoValues.hora);
                modal.find(\".fora\").html(jogoValues.timefora);
                modal.find(\".campeonato\").html(jogoValues.campeonato);
                modal.find(\"[data-cotacao]\").html('0.00').closest(\".btn\").attr(\"disabled\", true);

                if (cotacoes) {
                    \$.each(cotacoes, function (tempo, values) {
                        if (\$.isPlainObject(values)) {
                            \$.each(values, function (index, value) {
                                var valor = cotacoes[tempo][index].toFixed(2);
                                var span = modal.find('[data-cotacao=\"' + tempo + '-' + index + '\"]');
                                span.html(valor);
                                if (valor != '0.00') {
                                    span.closest(\".btn\").attr('disabled', false);
                                }
                            });
                        }
                    });
                }

            };

            form
                .on('submit', function () {
                    var jogos = [];

                    \$('input[type=checkbox][name=jogo]:checked')
                        .each(function () {
                            jogos.push(\$(this).closest('.tr-jogo').data('dados'));
                        });

                    if (!jogos || jogos.length == 0) {
                        alert('É necessário que selecione no mínimo 1 jogo para importar.');
                    } else if (confirm('Tem certeza de que deseja importar os ' + jogos.length + ' jogos?')) {

                        \$('html').addClass('page-loading');

                        \$
                            .post(url(CONTROLLER + '/importar'), {jogos: JSON.stringify(jogos)}, function (e) {
                                alert(e.message);
                            }, 'json')
                            .fail(function () {
                                alert('Não foi possível importar os jogos');
                            })
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
        return "admin/importar/jogos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  323 => 178,  320 => 177,  308 => 167,  300 => 164,  294 => 163,  288 => 162,  279 => 158,  274 => 156,  271 => 155,  268 => 154,  263 => 153,  259 => 152,  255 => 151,  247 => 149,  243 => 148,  236 => 143,  226 => 139,  222 => 138,  218 => 137,  213 => 136,  209 => 135,  140 => 68,  133 => 66,  122 => 63,  118 => 62,  115 => 61,  111 => 60,  108 => 59,  104 => 58,  90 => 46,  81 => 44,  77 => 43,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/importar/jogos.twig", "/home2/bets01/public_html/app/views/admin/importar/jogos.twig");
    }
}
