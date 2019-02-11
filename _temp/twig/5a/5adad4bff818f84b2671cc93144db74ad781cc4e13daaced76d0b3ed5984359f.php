<?php

/* admin/biblioteca/listar.twig */
class __TwigTemplate_27ae534144709ec871a47ba653fd69858126b14d2944860a64ad44263c19dc75 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/biblioteca/listar.twig", 1);
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
    ";
        // line 5
        if (($context["isAdm"] ?? null)) {
            // line 6
            echo "        <form class=\"admpage-form\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"id\"/>
            <div class=\"panel panel-default\">
                <div class=\"panel-body p-b-10\">
                    <div class=\"row\">
                        <div class=\"form-group col-md-3 col-sm-6 col-xs-12\">
                            <label>Ordem</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                      data-content=\"Digite um número para ordenar.\"
                                                      data-original-title=\"\" title=\"\">[<i
                                        class=\"fa fa-question\"></i>]</span>
                            <input name=\"ordem\" type=\"number\" class=\"form-control\">
                        </div>
                        <div class=\"form-group col-md-9 col-xs-12 col-sm-6\">
                            <label>Título</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                       data-content=\"Digite um título.\" data-original-title=\"\" title=\"\">[<i
                                        class=\"fa fa-question\"></i>]</span>
                            <input type=\"text\" name=\"title\" class=\"form-control\">
                        </div>
                        <div class=\"form-group col-xs-12\">
                            <label>Link para download</label><span class=\"pointer\" data-toggle=\"popover\"
                                                                   data-trigger=\"hover\"
                                                                   data-content=\"Digite um link para download do arquivo.\"
                                                                   data-original-title=\"\" title=\"\">[<i
                                        class=\"fa fa-question\"></i>]</span>
                            <input type=\"text\" name=\"link\" class=\"form-control\">
                        </div>
                    </div>
                </div>
                <div class=\"text-right panel-footer clearfix\">
                    <div class=\"row\">
                        <div class=\"col-xs-6 text-left\">
                            <label for=\"upfile\" class=\"btn-success btn btn-inputfile\">
                                <span><i class=\"fa fa-upload\"></i> Arquivo <span></span></span>
                                <input type=\"file\" id=\"upfile\" name=\"upfile\"
                                       accept=\".rar,.zip,.pdf,.doc,.docx,.xsl,.xlsx,.jpg,.jpeg,.png,.gif\">
                            </label>
                        </div>
                        <div class=\"col-xs-6 text-right\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fa fa-save\"></i> Salvar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    ";
        }
        // line 54
        echo "
    <div class=\"admpage-container\"></div>

";
    }

    // line 59
    public function block_script($context, array $blocks = array())
    {
        // line 60
        echo "
    <script>

        \$
            .adminPage({
                container: '.admpage-container',
                form: '.admpage-form',
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/biblioteca/listar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 60,  98 => 59,  91 => 54,  41 => 6,  39 => 5,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/biblioteca/listar.twig", "/home2/bets01/public_html/app/views/admin/biblioteca/listar.twig");
    }
}
