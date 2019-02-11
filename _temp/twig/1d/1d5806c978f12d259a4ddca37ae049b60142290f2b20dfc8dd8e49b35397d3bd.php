<?php

/* website/page/cadastrar.twig */
class __TwigTemplate_4d14ae9b696f29aa85d128e45561a85afcff87d3c099a139b6e7ee6e8c6c3dbc extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/cadastrar.twig", 1);
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
    <h1 class=\"page-title\">
        <i class=\"fa fa-edit\"></i> Cadastrar
    </h1>

    <form action=\"\">
        <h5 class=\"page-subtitle\">Dados bancários</h5>
        <div class=\"pt-3 pb-3\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-8\">
                        <div>
                            <div class=\"row\">
                                <div class=\"col-12 col-sm-12 col-12\">
                                    <div class=\"form-group\">
                                        <label>Banco</label>
                                        <select name=\"banco\" class=\"form-control\">
                                            <option value> -- Selecione --</option>
                                            ";
        // line 22
        echo twig_escape_filter($this->env, ($context["bancos"] ?? null), "html", null, true);
        echo "
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-6 col-sm-12 col-12\">
                                    <div class=\"form-group\">
                                        <label>N.º da Agência</label>
                                        <input type=\"text\" class=\"form-control\" name=\"agencia\">
                                    </div>
                                </div>
                                <div class=\"col-6 col-sm-12 col-12\">
                                    <div class=\"form-group\">
                                        <label>N.º da conta</label>
                                        <input type=\"text\" class=\"form-control\" name=\"conta\">
                                    </div>
                                </div>
                                <div class=\"col-6 col-sm-12 col-12 form-group\">
                                    <label>Tipo de conta</label>
                                    <select name=\"contatipo\" class=\"form-control\">
                                        <option>Poupança</option>
                                        <option>Corrente</option>
                                    </select>
                                </div>
                                <div class=\"col-6 col-sm-12 col-12 form-group\">
                                    <label>Variação</label>
                                    <input type=\"text\" name=\"variacao\" class=\"form-control\" maxlength=\"10\"/>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"text-right pb-3 px-3\">
            <button class=\"btn btn-danger\" type=\"submit\">
                <i class=\"fa fa-check\"></i> Concluír
            </button>
        </div>
    </form>

";
    }

    public function getTemplateName()
    {
        return "website/page/cadastrar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 22,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/cadastrar.twig", "/home2/bets01/public_html/app/views/website/page/cadastrar.twig");
    }
}
