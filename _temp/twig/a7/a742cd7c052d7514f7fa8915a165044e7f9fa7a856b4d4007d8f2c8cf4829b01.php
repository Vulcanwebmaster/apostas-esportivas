<?php

/* admin/comunicados.twig */
class __TwigTemplate_314e53272acefd4d59031689c0a47919e4368fdfcc921e50d1a0a97e7630b5c8 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/comunicados.twig", 1);
        $this->blocks = array(
            'links' => array($this, 'block_links'),
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
    public function block_links($context, array $blocks = array())
    {
        // line 4
        echo "    <button type=\"button\" onclick=\"\$('.admpage-form').setValues({});\" class=\"btn btn-success\">
        <i class=\"fa fa-plus\"></i> Novo
    </button>
";
    }

    // line 9
    public function block_main($context, array $blocks = array())
    {
        // line 10
        echo "
    <form class=\"modal fade admpage-form\">
        <input type=\"hidden\" name=\"id\"/>
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Comunicado</h3>
                </div>
                <div class=\"modal-body\">
                    <div class=\"row\">
                        <div class=\"form-group col-xs-3\">
                            <label>Data</label>
                            <input type=\"date\" name=\"data\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-xs-2\">
                            <label>Hora</label>
                            <input type=\"time\" name=\"hora\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-xs-7\">
                            <label>Título</label>
                            <input type=\"text\" name=\"title\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div>
                        <label>Mensagem</label>
                        <textarea data-ckeditor type=\"text\" name=\"mensagem\" class=\"form-control\"></textarea>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <button class=\"btn btn-link\" type=\"button\" data-dismiss=\"modal\">
                        <i class=\"fa fa-times\"></i> Cancelar
                    </button>
                    <button class=\"btn btn-primary\" type=\"submit\">
                        <i class=\"fa fa-save\"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form class=\"admpage-form-search panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"input-group\">
                <input type=\"text\" name=\"search\" class=\"form-control\" placeholder=\"Buscar por\"/>
                <div class=\"input-group-btn\">
                    <button class=\"btn btn-primary\" type=\"submit\">
                        Buscar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class=\"admpage-container\"></div>

";
    }

    // line 68
    public function block_script($context, array $blocks = array())
    {
        // line 69
        echo "
    <script>

        var container = \$('.admpage-container');

        \$('.admpage-form')
            .adminPage({
                formSearch: '.admpage-form-search',
                container: container,
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/comunicados.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 69,  107 => 68,  47 => 10,  44 => 9,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/comunicados.twig", "/home2/bets01/public_html/app/views/admin/comunicados.twig");
    }
}
