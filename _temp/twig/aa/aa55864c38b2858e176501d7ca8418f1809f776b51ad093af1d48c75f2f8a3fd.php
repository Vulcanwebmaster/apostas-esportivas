<?php

/* admin/jogos/form.twig */
class __TwigTemplate_1bb912ae619ea934ffd24047ce7e96cf940d2e5f55aebc847f38c9e8478e864b extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/jogos/form.twig", 1);
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
        echo "    <a href=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_referer')->getCallable(), array()), "html", null, true);
        echo "\" class=\"btn btn-danger\">
        <i class=\"fa fa-chevron-left\"></i> Voltar
    </a>
";
    }

    // line 9
    public function block_main($context, array $blocks = array())
    {
        // line 10
        echo "
    <form id=\"form-jogo\" onsubmit=\"return false;\">
        <div class=\"panel panel-default\">

            <input type=\"hidden\" name=\"id\"/>

            <div class=\"panel-heading\">
                <h4 class=\"panel-title\">Jogo</h4>
            </div>

            <div class=\"panel-body\">

                <div class=\"row\">

                    <div class=\"col-md-6 col-sm-12 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Campeonato</label>
                            <select name=\"campeonato\" class=\"form-control chosen\" required
                                    data-options=\"admin/cadastros/campeonatos/options\">
                                <option value>-- Selecione o campeonato --</option>
                            </select>
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Data do Jogo</label>
                            <input type=\"date\" name=\"data\" placeholder=\"";
        // line 37
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-d"), "html", null, true);
        echo "\" class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Hora</label>
                            <input type=\"time\" name=\"hora\" placeholder=\"\" class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-6 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Time da Casa</label>
                            <select name=\"timecasa\" class=\"form-control chosen\" required
                                    data-options=\"admin/cadastros/times/options\">
                                <option value>-- Selecione o time da casa --</option>
                            </select>
                        </div>
                    </div>

                    <div class=\"col-md-6 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Time de Fora</label>
                            <select name=\"timefora\" class=\"form-control chosen\" required
                                    data-options=\"admin/cadastros/times/options\">
                                <option value>-- Selecione o time de fora --</option>
                            </select>
                        </div>
                    </div>

                    <div class=\"col-xs-12\">
                        <h3>Limites de Jogos</h3>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>
                                Max. Apostas
                            </label>
                            <input type=\"number\" min=\"0\" max=\"99999999999\" name=\"maxapostas\" placeholder=\"Ilimitado\"
                                   class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Limite 1 Jogo</label>
                            <input type=\"text\" name=\"limite1\" placeholder=\"Ilimitado\" class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Limite 2 Jogos</label>
                            <input type=\"text\" name=\"limite2\" placeholder=\"Ilimitado\" class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Limite 3 Jogos</label>
                            <input type=\"text\" name=\"limite3\" placeholder=\"Ilimitado\" class=\"form-control\">
                        </div>
                    </div>

                </div>

                <h3>Cotações</h3>

                <div>
                    <ul class=\"nav nav-tabs\" role=\"tablist\">
                        ";
        // line 109
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tempos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["tempo"]) {
            // line 110
            echo "                            <li role=\"presentation\" class=\"";
            echo (((twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()) == "90")) ? ("active") : (null));
            echo "}\">
                                <a href=\"#";
            // line 111
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "\" aria-controls=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "\" role=\"tab\"
                                   data-toggle=\"tab\">";
            // line 112
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "title", array()), "html", null, true);
            echo "</a>
                            </li>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tempo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
        echo "                    </ul>
                    <div class=\"tab-content\">
                        ";
        // line 117
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tempos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["tempo"]) {
            // line 118
            echo "                            <div role=\"tabpanel\" class=\"tab-pane pane-cotacoes ";
            echo (((twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()) == "90")) ? ("active") : (null));
            echo "\"
                                 id=\"";
            // line 119
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
            echo "\">
                                <div class=\"row\">
                                    ";
            // line 121
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cotacoes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["cotacao"]) {
                // line 122
                echo "                                        <div class=\"col-md-3 col-xs-6 form-group\">
                                            <label>";
                // line 123
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getSigla", array(), "method"), "html", null, true);
                echo "</label>
                                            <input type=\"number\" step=\"0.01\" min=\"0\" max=\"999.99\"
                                                   name=\"cotacoes[tempo";
                // line 125
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tempo"], "key", array()), "html", null, true);
                echo "][";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getCampo", array(), "method"), "html", null, true);
                echo "]\"
                                                   class=\"form-control\">
                                        </div>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cotacao'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 129
            echo "                                </div>
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tempo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 132
        echo "                    </div>
                </div>

            </div>

            ";
        // line 137
        if ((twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "getStatus", array(), "method") == 1)) {
            // line 138
            echo "                <div class=\"text-right panel-footer\">

                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fa fa-save\"></i>
                        Salvar
                    </button>

                </div>
            ";
        }
        // line 147
        echo "
        </div>
    </form>

";
    }

    // line 153
    public function block_script($context, array $blocks = array())
    {
        // line 154
        echo "
    <script>

        \$(function(){

            var \$form = \$('#form-jogo');
            var values = ";
        // line 160
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["v"] ?? null), true)), "html", null, true);
        echo ";

            values.cotacoes = {
              'tempo90': values.cotacoes['90'],
              'tempopt': values.cotacoes.pt,
              'tempost': values.cotacoes.st,
            };

            \$form
                .adminPage({
                    controller: 'jogos/jogo',
                    autoSearch: false,
                    alertSuccess: true,
                    autoReset: false,
                    reloadSuccess: '";
        // line 174
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_referer')->getCallable(), array()), "html", null, true);
        echo "',
                })
                .on(\"change\", \"[name=campeonato]\", function () {

                    var times = \$(this).find('option:selected').data('times');

                    var filtro = function () {

                        var value = \$(this).val();

                        if (times && value) {

                            var search = '\\\\[' + value + '\\\\]';
                            var result = times.search(search);

                            if (result == -1) {
                                return false;
                            } else {
                                return true;
                            }

                        } else {
                            return true;
                        }
                    };

                    // Removendo opções inválida
                    var selects = \$('[name=timecasa], [name=timefora]');

                    selects
                        .find('option').addClass('hide')
                        .filter(filtro).removeClass('hide');

                    selects.closest('select').trigger('chosen:updated');
                })
                .setValues(values);

        });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/jogos/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  283 => 174,  266 => 160,  258 => 154,  255 => 153,  247 => 147,  236 => 138,  234 => 137,  227 => 132,  219 => 129,  207 => 125,  202 => 123,  199 => 122,  195 => 121,  190 => 119,  185 => 118,  181 => 117,  177 => 115,  168 => 112,  162 => 111,  157 => 110,  153 => 109,  78 => 37,  49 => 10,  46 => 9,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/jogos/form.twig", "/home2/bets01/public_html/app/views/admin/jogos/form.twig");
    }
}
