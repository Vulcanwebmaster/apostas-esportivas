<?php

/* admin/forms/usuarios_tipos.twig */
class __TwigTemplate_87cd0b6781e1c0da5f329afafd7143e298f554a4c739c5ce7759b048540ed425 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/forms/usuarios_tipos.twig", 1);
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
    <form id=\"form-this\" data-adminpage>
        <input type=\"hidden\" name=\"id\" />
        <div class=\"panel\">
            <div class=\"panel-body\">
                <div class=\"row\">
                    <div class=\"form-group col-xs-12\">
                        <label>Título</label>
                        <input type=\"text\" name=\"title\" class=\"form-control\" required/>
                    </div>
                    <div class=\"col-xs-12\">
                        <label>Permissões</label>
                        <select name=\"permissoes\" multiple class=\"form-control chosen\">
                            ";
        // line 17
        echo ($context["types"] ?? null);
        echo "
                        </select>
                    </div>
                </div>
            </div>
            <div class=\"panel-footer text-right\">
                <button class=\"btn btn-warning\" type=\"reset\">
                    <i class=\"fa fa-eraser\"></i> Limpar
                </button>
                <button class=\"btn btn-primary\">
                    <i class=\"fa fa-save\"></i> Salvar
                </button>
            </div>
        </div>
    </form>

";
    }

    public function getTemplateName()
    {
        return "admin/forms/usuarios_tipos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 17,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/forms/usuarios_tipos.twig", "/home2/bets01/public_html/app/views/admin/forms/usuarios_tipos.twig");
    }
}
