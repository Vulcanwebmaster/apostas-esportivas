<?php

/* admin/cadastros/cotacoes.twig */
class __TwigTemplate_8ba2027f5303acc10caba9a444e551d9917f4256037eeacb814e052b1e190bf6 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/cadastros/cotacoes.twig", 1);
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
<form class=\"admpage-form panel panel-default\">
    <input type=\"hidden\" name=\"id\"/>
    <div class=\"panel-heading\">
        <h3 class=\"panel-title\">Cotação</h3>
    </div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-xs-2\">
                <label>Ordem</label>
                <input type=\"number\" name=\"ordem\" class=\"form-control\" min=\"0\" max=\"250\"/>
            </div>
            <div class=\"form-group col-xs-2\">
                <label>Principal?</label>
                <select name=\"principal\" class=\"form-control\">
                    <option value=\"0\">Não</option>
                    <option value=\"1\">Sim</option>
                </select>
            </div>
            <div class=\"form-group col-xs-2\">
                <label>Cor</label>
                <input type=\"color\" name=\"cor\" class=\"form-control\"/>
            </div>
            <div class=\"form-group col-xs-6\">
                <label>GRUPO</label>
                <select name=\"grupo\" class=\"form-control\">
                    ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["grupos"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["grupo"]) {
            // line 31
            echo "                    <option value=\"";
            echo twig_escape_filter($this->env, $context["id"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["grupo"], "html", null, true);
            echo "</option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['grupo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "                </select>
            </div>
            <div class=\"form-group col-xs-6\">
                <label>Título</label>
                <input type=\"text\" name=\"titulo\" class=\"form-control\" required maxlength=\"250\"/>
            </div>
            <div class=\"form-group col-xs-3\">
                <label>Campo</label>
                <input type=\"text\" name=\"campo\" class=\"form-control\" required pattern=\"[a-z][a-z0-9]+\" maxlength=\"50\"/>
            </div>
            <div class=\"form-group col-xs-3\">
                <label>Sigla</label>
                <input type=\"text\" name=\"sigla\" class=\"form-control\" maxlength=\"15\"/>
            </div>
            <div class=\"form-group col-xs-12\">
                <label>Descrição</label>
                <textarea name=\"descricao\" class=\"form-control\" data-ckeditor></textarea>
            </div>
            <div class=\"form-group col-xs-12\">
                <label>Query
                    <small>(É necessário conhecimento de mysql)</small>
                </label>
                <input type=\"text\" name=\"query\" class=\"form-control\" required maxlength=\"2500\"/>
            </div>
        </div>
    </div>
    <div class=\"panel-footer text-right\">
        <div class=\"pull-left\">
            <button class=\"btn btn-warning\" type=\"button\" onclick=\"javascript:admSalvarCopia();\">
                <i class=\"fa fa-copy\"></i>
                Salvar cópia
            </button>
        </div>
        <button type=\"reset\" class=\"btn btn-link\"><i class=\"fa fa-eraser\"></i> Limpar</button>
        <button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i> Salvar</button>
    </div>
</form>

";
    }

    // line 73
    public function block_script($context, array $blocks = array())
    {
        // line 74
        echo "
<script>

    var form = \$('.admpage-form');
    form
        .adminPage({});

    function admSalvarCopia() {
        form.find(\"[name=id]\").val(0);
        form.submit();
    }

</script>

";
    }

    public function getTemplateName()
    {
        return "admin/cadastros/cotacoes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 74,  121 => 73,  79 => 33,  68 => 31,  64 => 30,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/cadastros/cotacoes.twig", "/home2/bets01/public_html/app/views/admin/cadastros/cotacoes.twig");
    }
}
