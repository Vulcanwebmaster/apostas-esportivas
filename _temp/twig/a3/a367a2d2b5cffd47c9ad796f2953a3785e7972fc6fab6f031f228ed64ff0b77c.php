<?php

/* admin/inc/modal-placar.twig */
class __TwigTemplate_3a542e8e213560c082788a19e7e5d3b8a52bcfe1350a35d6ef2de561aabbae11 extends Twig_Template
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
        echo "<form class=\"modal-placar modal fade\">
    <input type=\"hidden\" name=\"jogo\"/>
    <div class=\"modal-dialog modal-md\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                <h3 class=\"modal-title\">Placar</h3>
            </div>
            <div class=\"modal-body\">
                <div class=\"jogo-times m-b-20 text-center\"></div>
                ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(array(0 => "primeiro", 1 => "segundo"));
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 12
            echo "                <div class=\"form-group\">
                    <label>";
            // line 13
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, $context["key"]), "html", null, true);
            echo " TEMPO</label>
                    <div class=\"input-group\">
                        <input type=\"number\" name=\"timecasaplacar";
            // line 15
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" class=\"form-control\" required min=\"0\" max=\"99\"/>
                        <div class=\"input-group-addon\">casa x fora</div>
                        <input type=\"number\" name=\"timeforaplacar";
            // line 17
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" class=\"form-control\" required min=\"0\" max=\"99\"/>
                    </div>
                </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "                <small class=\"text-justify text-danger\">OBS: O resultado final será a soma dos resultados.</small>
            </div>
            <div class=\"modal-footer\">
                <button class=\"btn btn-primary\">
                    <i class=\"fa fa-check\"></i> Definir
                </button>
            </div>
        </div>
    </div>
</form>";
    }

    public function getTemplateName()
    {
        return "admin/inc/modal-placar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 21,  52 => 17,  47 => 15,  42 => 13,  39 => 12,  35 => 11,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/inc/modal-placar.twig", "/home2/bets01/public_html/app/views/admin/inc/modal-placar.twig");
    }
}
