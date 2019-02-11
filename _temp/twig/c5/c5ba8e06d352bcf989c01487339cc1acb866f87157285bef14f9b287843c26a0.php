<?php

/* admin/config/logs.twig */
class __TwigTemplate_e9d4e97e2141860cc016c9d89310a49795ddcf7d24d8dae926113c7c55a5c0b2 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/config/logs.twig", 1);
        $this->blocks = array(
            'list' => array($this, 'block_list'),
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
    public function block_list($context, array $blocks = array())
    {
        // line 4
        echo "
    ";
        // line 5
        if (twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getCount", array(), "method")) {
            // line 6
            echo "        <div class=\"panel\">
            <div class=\"panel-body p-0\">
                <div class=\"table-responsive m-0\">
                    <table class=\"m-0 table table-minified table-striped table-bordered table-hover\">
                        <thead>
                        <tr>
                            <th width=\"80\" class=\"text-center\">ID</th>
                            <th width=\"120\" class=\"text-center\">Data/Hora</th>
                            <th>Usuário</th>
                            <th>Referência</th>
                            <th width=\"120\">IP</th>
                            <th>Descrição</th>
                        </tr>
                        </thead>
                        <tbody>
                        ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getRegistros", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 22
                echo "                            <tr>
                                <td class=\"text-center\">";
                // line 23
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getId", array(), "method"), "html", null, true);
                echo "</td>
                                <td class=\"text-center\">";
                // line 24
                echo twig_replace_filter(twig_get_attribute($this->env, $this->source, $context["v"], "getInsert", array(0 => true), "method"), array(" " => "<br />"));
                echo "</td>
                                ";
                // line 25
                if (twig_get_attribute($this->env, $this->source, $context["v"], "getUserNome", array(), "method")) {
                    // line 26
                    echo "                                    <td>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getUserNome", array(), "method"), "html", null, true);
                    echo " (";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getUserLogin", array(), "method"), "html", null, true);
                    echo ")</td>
                                ";
                } else {
                    // line 28
                    echo "                                    <td>Servidor</td>
                                ";
                }
                // line 30
                echo "                                <td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getReferencia", array(), "method"), "html", null, true);
                echo "</td>
                                <td class=\"text-center\">";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getIp", array(), "method"), "html", null, true);
                echo "</td>
                                <td>";
                // line 32
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getDescricao", array(), "method"), "html", null, true);
                echo "</td>
                            </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 35
            echo "                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"panel-footer text-right\">";
            // line 39
            echo ($context["busca"] ?? null);
            echo "</div>
        </div>
    ";
        } elseif (        // line 41
($context["message"] ?? null)) {
            // line 42
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> ";
            // line 43
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
        </div>
    ";
        } else {
            // line 46
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
        </div>
    ";
        }
        // line 50
        echo "
";
    }

    // line 53
    public function block_main($context, array $blocks = array())
    {
        // line 54
        echo "    <form method=\"post\" class=\"page-form-search panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"row\">
                <div class=\"form-group col-md-1 col-xs-3\">
                    <label>ID</label>
                    <input type=\"number\" class=\"form-control\" name=\"id\">
                </div>
                <div class=\"form-group col-md-4 col-xs-9\">
                    <label>Usuário</label>
                    <select name=\"user\" class=\"form-control chosen\">
                        <option value>-- Todos --</option>
                        ";
        // line 65
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('optUsers')->getCallable(), array()), "html", null, true);
        echo "
                    </select>
                </div>
                <div class=\"form-group col-md-3 col-xs-12\">
                    <label>Referência</label>
                    <input type=\"text\" name=\"referencia\" class=\"form-control\" maxlength=\"50\"/>
                </div>
                <div class=\"clearfix hidden-md hidden-lg\"></div>
                <div class=\"form-group col-md-2 col-xs-6\">
                    <label>Início</label>
                    <input type=\"date\" class=\"form-control\" name=\"dataInicial\" placeholder=\"";
        // line 75
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-01"), "html", null, true);
        echo "\">
                </div>
                <div class=\"form-group col-md-2 col-xs-6\">
                    <label>Fim</label>
                    <input type=\"date\" class=\"form-control\" name=\"dataFinal\" placeholder=\"";
        // line 79
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-t"), "html", null, true);
        echo "\">
                </div>
                <div class=\"form-group col-xs-12\">
                    <label>Descrição</label>
                    <input type=\"text\" class=\"form-control\" name=\"search\"/>
                </div>
            </div>
        </div>
        <div class=\"panel-footer text-right\">
            <button type=\"submit\" class=\"btn btn-info\">
                <i class=\"fa fa-search\"></i> Pesquisar
            </button>
        </div>
    </form>

    <div class=\"row\">
        <div class=\"col-md-12 col-sm-12 col-xs-12 \">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading clearfix\">
                    <h4 class=\"panel-title\">Logs</h4>
                    <div class=\"pull-right m-t-minus-9\">
                    </div>
                </div>
                <div class=\"panel-body page-container panel-table\">
                    <div class=\"table-responsive m-t-md hide\" style=\"width: 100%;\">
                        <table class=\"table table-minified table-bordered table-striped list-table\">
                            <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Usuário</th>
                                <th>IP</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>01/05/2016 ás 15:05</td>
                                <td>hebert</td>
                                <td>127.0.0.1</td>
                                <td class=\"text-center\">Adicionou 18 jogos</td>
                            </tr>
                            <tr>
                                <td>02/05/2016 ás 10:12</td>
                                <td>hebert</td>
                                <td>127.0.0.1</td>
                                <td class=\"text-center\">Adicionou 5 jogos</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    // line 135
    public function block_script($context, array $blocks = array())
    {
        // line 136
        echo "    <script>

        \$('<div />').adminPage({
            formSearch: '.page-form-search',
            container: '.page-container',
        });

    </script>
";
    }

    public function getTemplateName()
    {
        return "admin/config/logs.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  237 => 136,  234 => 135,  175 => 79,  168 => 75,  155 => 65,  142 => 54,  139 => 53,  134 => 50,  128 => 46,  122 => 43,  119 => 42,  117 => 41,  112 => 39,  106 => 35,  97 => 32,  93 => 31,  88 => 30,  84 => 28,  76 => 26,  74 => 25,  70 => 24,  66 => 23,  63 => 22,  59 => 21,  42 => 6,  40 => 5,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/config/logs.twig", "/home2/bets01/public_html/app/views/admin/config/logs.twig");
    }
}
