<?php

/* website/inc/slideshow.twig */
class __TwigTemplate_5ec510636fad26c1db4e4a638ad4ccb6481941c9872ccb3c880f68bd52ce12b9 extends Twig_Template
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
        $context["banners"] = call_user_func_array($this->env->getFunction('banners')->getCallable(), array(($context["ref"] ?? null)));
        // line 2
        if (($context["banners"] ?? null)) {
            // line 3
            echo "    <div class=\"inc-slideshow mb-3\">
        <div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\">
            <ol class=\"carousel-indicators\">
                ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["banners"] ?? null));
            foreach ($context['_seq'] as $context["i"] => $context["v"]) {
                // line 7
                echo "                    <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"";
                echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                echo "\"
                        class=\"";
                // line 8
                echo ((($context["i"] == 0)) ? ("active") : (""));
                echo "\"></li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['i'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 10
            echo "            </ol>
            <div class=\"carousel-inner\">
                ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["banners"] ?? null));
            foreach ($context['_seq'] as $context["i"] => $context["v"]) {
                // line 13
                echo "                    <div class=\"carousel-item ";
                echo ((($context["i"] == 0)) ? ("active") : (""));
                echo "\">
                        ";
                // line 14
                if (($context["responsive"] ?? null)) {
                    // line 15
                    echo "                            <picture>
                                <source srcset=\"";
                    // line 16
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "imgCapa", array(0 => true, 1 => "mobile"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
                    echo "\" media=\"(max-width: 768px)\"/>
                                <img src=\"";
                    // line 17
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "imgCapa", array(0 => true, 1 => "desktop"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
                    echo "\" class=\"w-100\"/>
                            </picture>
                        ";
                } else {
                    // line 20
                    echo "                            <img src=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "imgCapa", array(0 => true, 1 => "desktop"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
                    echo "\" class=\"w-100\"/>
                        ";
                }
                // line 22
                echo "                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['i'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo "            </div>
            <a class=\"carousel-control-prev\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"prev\">
                <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Previous</span>
            </a>
            <a class=\"carousel-control-next\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"next\">
                <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Next</span>
            </a>
        </div>
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "website/inc/slideshow.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 24,  83 => 22,  77 => 20,  71 => 17,  67 => 16,  64 => 15,  62 => 14,  57 => 13,  53 => 12,  49 => 10,  41 => 8,  36 => 7,  32 => 6,  27 => 3,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/inc/slideshow.twig", "/home2/bets01/public_html/app/views/website/inc/slideshow.twig");
    }
}
