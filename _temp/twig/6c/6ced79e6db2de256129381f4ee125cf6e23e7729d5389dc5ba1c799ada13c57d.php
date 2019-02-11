<?php

/* admin/helpers/info-saldo.twig */
class __TwigTemplate_93d2786259f241b3c9b4fbef14e3e3894ce4f35093ceffadebdd118d87493973 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"row\">
    <div class=\"col-md-6 col-xs-12\">
        <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
            <div class=\"panel-body\">
                <div class=\"info-box-stats\">
                    <p class=\"counter\">R\$ ";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getCredito", array(0 => true), "method"), "html", null, true);
        echo "</p>
                    <span class=\"info-box-title m-b-0\">Saldo em Créditos</span>
                </div>
                <div class=\"info-box-icon\">
                    <i class=\"fa fa-usd\"></i>
                </div>
            </div>
        </div>
    </div>
    <div class=\"col-md-6 col-xs-12\">
        <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
            <div class=\"panel-body\">
                <div class=\"info-box-stats\">
                    <p class=\"counter\">";
        // line 19
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getPontos", array(), "method"), 0, ".", "."), "html", null, true);
        echo "</p>
                    <span class=\"info-box-title m-b-0\">Pontos Acumulados</span>
                </div>
                <div class=\"info-box-icon\">
                    <i class=\"fa fa-ticket\"></i>
                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "admin/helpers/info-saldo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 19,  30 => 6,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/info-saldo.twig", "/home2/bets01/public_html/app/views/admin/helpers/info-saldo.twig");
    }
}
