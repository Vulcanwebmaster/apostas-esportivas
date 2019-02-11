<?php

/* admin/informacoes/sistema.twig */
class __TwigTemplate_f1d00089e4f1adc0400dc8aaa78260b5b19cbdd2b67d1f6257d4b6b7f18b469e extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/informacoes/sistema.twig", 1);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
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
        echo "    <div class=\"row\">
        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-white\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 9
        echo twig_escape_filter($this->env, ($context["usuarios"] ?? null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, ($context["limite"] ?? null), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\">Usuários</span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-white\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p><span class=\"counter\">";
        // line 22
        echo twig_escape_filter($this->env, ($context["apostas"] ?? null), "html", null, true);
        echo "</span></p>
                        <span class=\"info-box-title\">Apostas realizadas</span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-edit\"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "admin/informacoes/sistema.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 22,  42 => 9,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/informacoes/sistema.twig", "/home2/bets01/public_html/app/views/admin/informacoes/sistema.twig");
    }
}
