<?php

/* admin/helpers/info-jogos.twig */
class __TwigTemplate_8ef0f00cd3e21932f48f6946e4760e408000628962066a93f63d41e1c8920318 extends Twig_Template
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
        $context["resumo"] = call_user_func_array($this->env->getFunction('resumoJogos')->getCallable(), array());
        // line 2
        echo "
<div class=\"row\">

    <div class=\"col-md-4 col-sm-12 col-xs-12\">
        <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
            <div class=\"panel-body\">
                <div class=\"info-box-stats\">
                    <p class=\"counter\">";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["resumo"] ?? null), "total", array()), "html", null, true);
        echo "</p>
                    <span class=\"info-box-title\">Total de jogos no Sistema</span>
                </div>
                <div class=\"info-box-icon\">
                    <i class=\"fa fa-futbol-o\"></i>
                </div>
            </div>
        </div>
    </div>
    <div class=\"col-md-4 col-sm-12 col-xs-12\">
        <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
            <div class=\"panel-body\">
                <div class=\"info-box-stats\">
                    <p class=\"counter\">";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["resumo"] ?? null), "hoje", array()), "html", null, true);
        echo "</p>
                    <span class=\"info-box-title\">Total de Jogos Hoje</span>
                </div>
                <div class=\"info-box-icon\">
                    <i class=\"fa fa-futbol-o\"></i>
                </div>
            </div>
        </div>
    </div>
    <div class=\"col-md-4 col-sm-12 col-xs-12\">
        <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
            <div class=\"panel-body\">
                <div class=\"info-box-stats\">
                    <p class=\"counter\">";
        // line 35
        echo twig_escape_filter($this->env, (($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["resumo"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["3dias"] ?? null) : null), "html", null, true);
        echo "</p>
                    <span class=\"info-box-title\">Total de Jogos nos Próximos 3 Dias</span>
                </div>
                <div class=\"info-box-icon\">
                    <i class=\"fa fa-futbol-o\"></i>
                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "admin/helpers/info-jogos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 35,  50 => 22,  34 => 9,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/info-jogos.twig", "/home2/bets01/public_html/app/views/admin/helpers/info-jogos.twig");
    }
}
