<?php

/* admin/helpers/options.twig */
class __TwigTemplate_cad4191b7f96f3ac3651c2a5d2c95200ea8edaec366a13caeb68a2a04cd33c84 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/helpers/options.twig", 1);
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
    <form class=\"admpage-form panel\" enctype=\"multipart/form-data\">
        <input type=\"hidden\" name=\"id\"/>
        <div class=\"panel-body\">
            <input type=\"text\" name=\"title\" class=\"form-control\"/>
        </div>
        <div class=\"panel-footer text-right\">
            <div class=\"pull-left\">
                ";
        // line 12
        if ((($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["vars"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["image"] ?? null) : null)) {
            // line 13
            echo "                    ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array(("<i class=\"fa fa-image\" ></i> " . twig_get_attribute($this->env, $this->source, ($context["vars"] ?? null), "image", array())), "upimg", "image/*")), "html", null, true);
            echo "
                ";
        }
        // line 15
        echo "            </div>
            <button type=\"reset\" class=\"btn btn-link\">
                <i class=\"fa fa-eraser\"></i> Limpar
            </button>
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"fa fa-save\"></i> Salvar
            </button>
        </div>
    </form>

";
    }

    // line 27
    public function block_script($context, array $blocks = array())
    {
        // line 28
        echo "
    <script>

        \$('.admpage-form')
            .adminPage({
                saveValues: ";
        // line 33
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
                searchValues: ";
        // line 34
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/helpers/options.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 34,  78 => 33,  71 => 28,  68 => 27,  54 => 15,  48 => 13,  46 => 12,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/options.twig", "/home2/bets01/public_html/app/views/admin/helpers/options.twig");
    }
}
