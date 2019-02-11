<?php

/* admin/fluxo/apuracao.twig */
class __TwigTemplate_2935e1f5f04754513fad3c97c9413294f4583fbe515e9bc17b1f6cb6eb9bd115 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/fluxo/apuracao.twig", 1);
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
        echo "
    <form class=\"page-form-search\" onsubmit=\"return false;\">
        <div class=\"panel panel-default\">
            <div class=\"panel-heading clearfix\">
                <h4 class=\"panel-title\">Apuração</h4>
            </div>
            <div class=\"panel-body\">

                <div class=\"row\">
                    <div class=\"col-xs-6\">
                        <div class=\"form-group\">
                            <label>Início</label>
                            <input type=\"date\" class=\"form-control text-center\" name=\"dataInicial\" required
                                   value=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-01"), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <div class=\"col-xs-6\">
                        <div class=\"form-group\">
                            <label>Fim</label>
                            <input type=\"date\" class=\"form-control text-center\" name=\"dataFinal\" required
                                   value=\"";
        // line 24
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-t"), "html", null, true);
        echo "\">
                        </div>
                    </div>
                </div>

            </div>

            <div class=\"panel-footer text-right\">
                <button type=\"submit\" class=\"btn btn-info\">
                    <i class=\"fa fa-bar-chart\"></i> Gerar
                </button>
            </div>

        </div>
    </form>

    <div class=\"page-container\"></div>

";
    }

    // line 44
    public function block_script($context, array $blocks = array())
    {
        // line 45
        echo "
    <script>

        \$('.page-form-search')
            .submit(function () {
                var _url = window.location.href + '?' + \$(this).serialize();
                \$('.page-container').load(_url);
                return false;
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/fluxo/apuracao.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 45,  84 => 44,  61 => 24,  51 => 17,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/fluxo/apuracao.twig", "/home2/bets01/public_html/app/views/admin/fluxo/apuracao.twig");
    }
}
