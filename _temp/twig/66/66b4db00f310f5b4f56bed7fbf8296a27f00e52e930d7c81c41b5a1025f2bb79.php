<?php

/* website/page/saldo.twig */
class __TwigTemplate_533dace461c602f8c2a5bffd24828fb5c1a5a538bc3a1bc44a47c463cc3fd2b6 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/saldo.twig", 1);
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
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Valor/Anterior</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class=\"text-center\">-/-</td>
                                <td>-/-</td>
                                <td>Saldo anterior</td>
                                <td class=\"text-right\">R\$ ";
            // line 24
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "credito", array()), 2, ",", "."), "html", null, true);
            echo "</td>
                            </tr>
                            ";
            // line 26
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getRegistros", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 27
                echo "                                <tr>
                                    <td class=\"text-center\">#";
                // line 28
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getId", array(), "method"), "html", null, true);
                echo "</td>
                                    <td>";
                // line 29
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getInsert", array(), "method"), "d/m/Y \\à\\s H\\hi"), "html", null, true);
                echo "</td>
                                    <td>";
                // line 30
                echo twig_get_attribute($this->env, $this->source, $context["v"], "getDescricao", array(), "method");
                echo "</td>
                                    <td class=\"text-right\">
                                        <div>";
                // line 32
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('fncSinal')->getCallable(), array(twig_get_attribute($this->env, $this->source, $context["v"], "getValor", array(), "method"), true)), "html", null, true);
                echo "</div>
                                        <small>";
                // line 33
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('fncSinal')->getCallable(), array(twig_get_attribute($this->env, $this->source, $context["v"], "getSaldoCreditos", array(), "method"), true)), "html", null, true);
                echo "</small>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 37
            echo "                            </tbody>
                        </table>
                    </div>
                    <div class=\"card-footer\">";
            // line 40
            echo twig_escape_filter($this->env, ($context["busca"] ?? null), "html", null, true);
            echo "</div>
                </div>
            </div>
        ";
        } elseif (        // line 43
($context["message"] ?? null)) {
            // line 44
            echo "            <div class=\"alert alert-warning m-0\">
                <i class=\"fa fa-warning\"></i> ";
            // line 45
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
            </div>
        ";
        } else {
            // line 48
            echo "            <div class=\"alert alert-warning m-0\">
                <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
            </div>
        ";
        }
        // line 52
        echo "    </div>

";
    }

    // line 56
    public function block_main($context, array $blocks = array())
    {
        // line 57
        echo "
    <h3 class=\"page-title\">
        <i class=\"fa fa-history d-none d-md-inline\"></i> Histórico financeiro
    </h3>

    <div class=\"container-fluid\">
        <div class=\"py-3\">
            <form class=\"admpage-form-search\" onsubmit=\"javascript:return false;\">
                <div class=\"row\">
                    <div class=\"form-group col-md-6 col-12\">
                        <label>De:</label>
                        <input type=\"date\" name=\"dataInicial\" class=\"form-control form-control-sm\" value=\"";
        // line 68
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-01"), "html", null, true);
        echo "\"/>
                    </div>
                    <div class=\"form-group col-md-6 col-12\">
                        <label>Até:</label>
                        <input type=\"date\" name=\"dataFinal\" class=\"form-control form-control-sm\" value=\"";
        // line 72
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-t"), "html", null, true);
        echo "\"/>
                    </div>
                </div>
                <hr class=\"mt-1\"/>
                <div class=\"text-right\">
                    <button class=\"btn btn-danger\">
                        <i class=\"fa fa-search\"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class=\"admpage-container\"></div>


";
    }

    // line 90
    public function block_script($context, array $blocks = array())
    {
        // line 91
        echo "
    <script>

        \$
            .adminPage({
                formSearch: '.admpage-form-search',
                container: '.admpage-container',
                autoSearch: false,
            });

        \$('.admpage-form-search').submit();

    </script>

";
    }

    public function getTemplateName()
    {
        return "website/page/saldo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  182 => 91,  179 => 90,  158 => 72,  151 => 68,  138 => 57,  135 => 56,  129 => 52,  123 => 48,  117 => 45,  114 => 44,  112 => 43,  106 => 40,  101 => 37,  91 => 33,  87 => 32,  82 => 30,  78 => 29,  74 => 28,  71 => 27,  67 => 26,  62 => 24,  43 => 7,  41 => 6,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/saldo.twig", "/home2/bets01/public_html/app/views/website/page/saldo.twig");
    }
}
