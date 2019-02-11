<?php

/* admin/home/jogador.twig */
class __TwigTemplate_f0d7f3096bbb61010bf1faada302ffd3513c10c49f3ed0a1bb206a96cf802374 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/home/jogador.twig", 1);
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
        echo "
    ";
        // line 5
        $this->loadTemplate("admin/inc/modal-saque.twig", "admin/home/jogador.twig", 5)->display($context);
        // line 6
        echo "
    <div class=\"row\">
        ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(call_user_func_array($this->env->getFunction('banners')->getCallable(), array("slideshow")));
        foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
            // line 9
            echo "            <div class=\"col-xs-12\" style=\"margin-bottom: 30px\">
                <div class=\"imagem\">
                    <img class=\"center-block\" src=\"";
            // line 11
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "imgCapa", array(), "method"), "getSource", array(0 => true), "method"), "html", null, true);
            echo "\">
                </div>
            </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "    </div>

    ";
        // line 17
        $this->loadTemplate("admin/helpers/comunicados.twig", "admin/home/jogador.twig", 17)->display($context);
        // line 18
        echo "
    ";
        // line 19
        $this->loadTemplate("admin/helpers/info-saldo.twig", "admin/home/jogador.twig", 19)->display($context);
        // line 20
        echo "
";
    }

    public function getTemplateName()
    {
        return "admin/home/jogador.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 20,  71 => 19,  68 => 18,  66 => 17,  62 => 15,  52 => 11,  48 => 9,  44 => 8,  40 => 6,  38 => 5,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/home/jogador.twig", "/home2/bets01/public_html/app/views/admin/home/jogador.twig");
    }
}
