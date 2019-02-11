<?php

/* website/page/apostas.twig */
class __TwigTemplate_85185870b8d7ba556d58a4092a1442898652afed75b9807663f9a8ee033f936d extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/apostas.twig", 1);
        $this->blocks = array(
            'list' => array($this, 'block_list'),
            'main' => array($this, 'block_main'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "website/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_list($context, array $blocks = array())
    {
        // line 4
        echo "
    <div class=\"container-fluid pb-3\">
        ";
        // line 6
        if (twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getCount", array(), "method")) {
            // line 7
            echo "            <div class=\"card\">
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive m-0\">
                        <table class=\"table table-minified table-striped table-bordered table-hover m-0\">
                            <thead>
                            <tr class=\"table-danger\">
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Jogos</th>
                                <th>Valor</th>
                                <th>Prêmio</th>
                                <th>Data</th>
                                <th>Usuário</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th colspan=\"7\">";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getPageDescription", array(), "method"), "html", null, true);
            echo "</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            ";
            // line 28
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getRegistros", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 29
                echo "                                <tr class=\"table-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getStatusClass", array(), "method"), "html", null, true);
                echo "\">
                                    <td class=\"text-center\">
                                        <a href=\"";
                // line 31
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("apostas/imprimir", array(0 => twig_get_attribute($this->env, $this->source, $context["v"], "getToken", array(), "method")))), "html", null, true);
                echo "\" target=\"_blank\">
                                            #";
                // line 32
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getId", array(), "method"), "html", null, true);
                echo "
                                        </a>
                                    </td>
                                    <td>";
                // line 35
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getApostadorNome", array(), "method"), "html", null, true);
                echo "</td>
                                    <td class=\"text-center\">";
                // line 36
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getJogos", array(), "method"), "html", null, true);
                echo "</td>
                                    <td class=\"text-center\">R\$ ";
                // line 37
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getValor", array(0 => true), "method"), "html", null, true);
                echo "</td>
                                    <td class=\"text-center\">R\$ ";
                // line 38
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getRetornoValido", array(0 => true), "method"), "html", null, true);
                echo "</td>
                                    <td class=\"text-center\">";
                // line 39
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getData", array(0 => true), "method"), "html", null, true);
                echo "</td>
                                    <td>";
                // line 40
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getUserNome", array(), "method"), "html", null, true);
                echo "</td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "                            </tbody>
                        </table>
                    </div>
                    <div class=\"card-footer\">";
            // line 46
            echo ($context["busca"] ?? null);
            echo "</div>
                </div>
            </div>

            <div style=\"font-size: 12px;\">
                <span class=\"text-info mr-2\"><i class=\"fa fa-circle\"></i> Ganhou a aposta</span>
                <span class=\"text-danger mr-2\"><i class=\"fa fa-circle\"></i> Perdeu a aposta</span>
                <span class=\"mr-2\"><i class=\"fa fa-circle\"></i> Aguardando o jogo terminar</span>
                <span class=\"text-warning mr-2\"><i class=\"fa fa-circle\"></i> Aposta cancelada</span>
            </div>

        ";
        } elseif (        // line 57
($context["message"] ?? null)) {
            // line 58
            echo "            <div class=\"alert alert-warning\">
                <i class=\"fa fa-warning\"></i> ";
            // line 59
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
            </div>
        ";
        } else {
            // line 62
            echo "            <div class=\"alert alert-warning\">
                <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
            </div>
        ";
        }
        // line 66
        echo "    </div>

";
    }

    // line 70
    public function block_main($context, array $blocks = array())
    {
        // line 71
        echo "
    <h3 class=\"page-title\">
        <i class=\"fa fa-ticket\"></i> Minhas apostas
    </h3>

    <div class=\"container-fluid\">
        <div class=\"py-3\">
            <form class=\"admpage-form-search\" onsubmit=\"return false;\">
                <div class=\"row\">
                    <div class=\"form-group col-md-4 col-12\">
                        <label>De:</label>
                        <div class=\"row\">
                            <div class=\"col-7\">
                                <input type=\"date\" name=\"dataInicial\" class=\"form-control form-control-sm\"/>
                            </div>
                            <div class=\"col-5\">
                                <input type=\"time\" name=\"horaInicial\" class=\"form-control form-control-sm\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"form-group col-md-4 col-12\">
                        <label>Até:</label>
                        <div class=\"row\">
                            <div class=\"col-7\">
                                <input type=\"date\" name=\"dataFinal\" class=\"form-control form-control-sm\"/>
                            </div>
                            <div class=\"col-5\">
                                <input type=\"time\" name=\"horaFinal\" class=\"form-control form-control-sm\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"form-group col-md-4 col-12\">
                        <label>Ordenar por:</label>
                        <select name=\"orderby\" class=\"form-control form-control-sm\">
                            <option value=\"data-desc\">Data (decrescente)</option>
                            <option value=\"data-asc\">Data (crescente)</option>
                            <option value=\"valor-desc\">Valor da aposta (decrescente)</option>
                            <option value=\"valor-asc\">Valor da aposta (crescente)</option>
                            <option value=\"retorno-desc\">Valor do prêmio (decrescente)</option>
                            <option value=\"retorno-asc\">Valor do prêmio (crescente)</option>
                        </select>
                    </div>
                    <div class=\"form-group col-12\">
                        <label>Cliente</label>
                        <input type=\"text\" name=\"apostadornome\" class=\"form-control form-control-sm\"/>
                    </div>
                </div>
                <hr class=\"mt-1\"/>
                <div class=\"text-right\">
                    <button class=\"btn btn-danger\">
                        <i class=\"fa fa-search\"></i> Pesquisar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class=\"admpage-container\"></div>

";
    }

    // line 132
    public function block_script($context, array $blocks = array())
    {
        // line 133
        echo "
    <script>

        \$
            .adminPage({
                formSearch: '.admpage-form-search',
                container: '.admpage-container',
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "website/page/apostas.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  229 => 133,  226 => 132,  163 => 71,  160 => 70,  154 => 66,  148 => 62,  142 => 59,  139 => 58,  137 => 57,  123 => 46,  118 => 43,  109 => 40,  105 => 39,  101 => 38,  97 => 37,  93 => 36,  89 => 35,  83 => 32,  79 => 31,  73 => 29,  69 => 28,  62 => 24,  43 => 7,  41 => 6,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/apostas.twig", "/home2/bets01/public_html/app/views/website/page/apostas.twig");
    }
}
