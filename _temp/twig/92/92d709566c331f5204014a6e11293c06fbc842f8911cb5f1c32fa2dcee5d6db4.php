<?php

/* website/page/cotacoes.twig */
class __TwigTemplate_05f4389bd813e06ede0e4a62da3af23a9d9ed7e6a4c1039777c06cf161b77846 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/cotacoes.twig", 1);
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
    <h1 class=\"page-title\">Cotações</h1>

    ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["grupos"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["g"]) {
            // line 8
            echo "        <h3 class=\"page-subtitle\">";
            echo twig_escape_filter($this->env, $context["g"], "html", null, true);
            echo "</h3>
        <div class=\"container-fluid\">
            <div class=\"row pt-3\">
                ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cotacoes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                // line 12
                echo "                    ";
                if (($context["id"] == twig_get_attribute($this->env, $this->source, $context["c"], "getGrupo", array(), "method"))) {
                    // line 13
                    echo "                        <div class=\"col-3 col-sm-4 col-6 mb-3\">
                            <div class=\"card\">
                                <div class=\"card-header text-center\">
                                    <div><b>";
                    // line 16
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getTitulo", array(), "method"), "html", null, true);
                    echo "</b></div>
                                    <small>";
                    // line 17
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getSigla", array(), "method"), "html", null, true);
                    echo "</small>
                                </div>
                                <div class=\"card-body pb-0\">
                                    ";
                    // line 20
                    echo twig_get_attribute($this->env, $this->source, $context["c"], "getDescricao", array(), "method");
                    echo "
                                </div>
                            </div>
                        </div>
                    ";
                }
                // line 25
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 26
            echo "            </div>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['g'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "
";
    }

    public function getTemplateName()
    {
        return "website/page/cotacoes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 29,  87 => 26,  81 => 25,  73 => 20,  67 => 17,  63 => 16,  58 => 13,  55 => 12,  51 => 11,  44 => 8,  40 => 7,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/cotacoes.twig", "/home2/bets01/public_html/app/views/website/page/cotacoes.twig");
    }
}
