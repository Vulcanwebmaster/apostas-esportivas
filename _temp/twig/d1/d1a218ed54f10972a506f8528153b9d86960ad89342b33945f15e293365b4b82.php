<?php

/* admin/financeiro/contas.twig */
class __TwigTemplate_33616c0963f391370671e50ecc0682fc08142bb1105e250388897efd914ffba0 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/financeiro/contas.twig", 1);
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
        echo twig_escape_filter($this->env, ($context["module"] ?? null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, ($context["controller"] ?? null), "html", null, true);
        echo "/novo\" class=\"btn btn-info\">
        <i class=\"fa fa-plus\"></i> Adicionar
    </a>
";
    }

    // line 9
    public function block_main($context, array $blocks = array())
    {
        // line 10
        echo "
    <form class=\"page-search panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"row\">
                <div class=\"form-group col-xs-12\">
                    <label>Usuário</label>
                    <select name=\"user\" class=\"form-control\" data-options=\"admin/users/users/options\">
                        <option value>-- Todos --</option>
                    </select>
                </div>
                <div class=\"form-group col-md-2 col-xs-6\">
                    <label>Pago</label>
                    <select name=\"pago\" class=\"form-control\">
                        <option value>Ambos</option>
                        <option value=\"1\">Sim</option>
                        <option value=\"0\">Não</option>
                    </select>
                </div>
                <div class=\"form-group col-md-10 col-xs-12\">
                    <label>Descrição</label>
                    <select name=\"descricao\" class=\"form-control\"
                            data-options=\"admin/helpers/options/options/financeiro-descricao\">
                        <option value>-- Todas --</option>
                    </select>
                </div>
            </div>
        </div>
        <div class=\"panel-footer text-right\">
            <button class=\"btn btn-info\">
                <i class=\"fa fa-search\"></i>
                Buscar
            </button>
        </div>
    </form>

    <div class=\"page-container\"></div>

";
    }

    // line 49
    public function block_script($context, array $blocks = array())
    {
        // line 50
        echo "
    <script>

        \$.adminPage({
            formSearch: '.page-search',
            container: '.page-container',
        });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/financeiro/contas.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 50,  92 => 49,  51 => 10,  48 => 9,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/financeiro/contas.twig", "/home2/bets01/public_html/app/views/admin/financeiro/contas.twig");
    }
}
