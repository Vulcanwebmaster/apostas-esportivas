<?php

/* admin/informacoes/regras.twig */
class __TwigTemplate_f2be1468cb14389f52bbb928e987e31d486f7040eaad54ea6a3d3695bd36e233 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/informacoes/regras.twig", 1);
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
        echo "    ";
        if ((($context["isMaster"] ?? null) == false)) {
            // line 5
            echo "        <div class=\"panel\">
            <div class=\"panel-heading\">
                <h4 class=\"panel-title\">";
            // line 7
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
            echo "</h4>
            </div>
            <div class=\"panel-body\">
                ";
            // line 10
            echo ($context["regra"] ?? null);
            echo "
            </div>
        </div>
    ";
        } else {
            // line 14
            echo "        <form onsubmit=\"return false;\"
              data-adminpage=\"";
            // line 15
            echo twig_escape_filter($this->env, json_encode(array("alertSuccess" => true, "autoSearch" => false, "autoReset" => false, "controller" => "config/dados")), "html", null, true);
            echo "\">
            <div class=\"panel\">
                <div class=\"panel-body\">
                    <textarea name=\"";
            // line 18
            echo twig_escape_filter($this->env, ($context["field"] ?? null), "html", null, true);
            echo "\" data-ckeditor height=\"400\">";
            echo twig_escape_filter($this->env, ($context["regra"] ?? null), "html", null, true);
            echo "</textarea>
                </div>
                <div class=\"panel-footer text-right\">
                    <button class=\"btn btn-primary\">
                        <i class=\"fa fa-save\"></i> Salvar
                    </button>
                </div>
            </div>
        </form>
    ";
        }
    }

    public function getTemplateName()
    {
        return "admin/informacoes/regras.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 18,  58 => 15,  55 => 14,  48 => 10,  42 => 7,  38 => 5,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/informacoes/regras.twig", "/home2/bets01/public_html/app/views/admin/informacoes/regras.twig");
    }
}
