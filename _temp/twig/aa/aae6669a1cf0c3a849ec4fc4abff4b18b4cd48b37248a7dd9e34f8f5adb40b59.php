<?php

/* website/page/texto.twig */
class __TwigTemplate_7edff63600fe131f167c7777d523b4beb9afa5a702cbb41c08e6e2aab5738d43 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/texto.twig", 1);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
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
    public function block_main($context, array $blocks = array())
    {
        // line 4
        echo "
    <h1 class=\"page-title\">";
        // line 5
        echo twig_get_attribute($this->env, $this->source, ($context["pagina"] ?? null), "getTitle", array(), "method");
        echo "</h1>

    <div class=\"p-3\">
        ";
        // line 8
        echo twig_get_attribute($this->env, $this->source, ($context["pagina"] ?? null), "getTexto", array(), "method");
        echo "
    </div>

";
    }

    public function getTemplateName()
    {
        return "website/page/texto.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  44 => 8,  38 => 5,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/texto.twig", "/home2/bets01/public_html/app/views/website/page/texto.twig");
    }
}
