<?php

/* admin/sys/menu.twig */
class __TwigTemplate_f7d5eace0e36e09114dbce7bf7a6e1ea41225a551937b384a0432efbdd5d66c1 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/sys/menu.twig", 1);
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
        echo "    <button onClick=\"\$('#form-this').resetForm().modal();\" class=\"btn btn-primary\">
        <i class=\"fa fa-plus\"></i> Novo
    </button>
";
    }

    // line 9
    public function block_main($context, array $blocks = array())
    {
        // line 10
        echo "
    <form class=\"modal fade admpage-form\" id=\"form-this\" onsubmit=\"return false;\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Menu</h3>
                </div>
                <div class=\"modal-body\">
                    <input type=\"hidden\" name=\"id\"/>
                    <div class=\"row\">
                        <div class=\"form-group col-md-3 col-xs-7\">
                            <label>Módulo</label>
                            <select name=\"module\" class=\"form-control\" required>
                                ";
        // line 24
        echo ($context["optModules"] ?? null);
        echo "
                            </select>
                        </div>
                        <div class=\"form-group col-md-2 col-xs-5\">
                            <label>Posição</label>
                            <input type=\"number\" name=\"ordem\" class=\"form-control\" min=\"0\" max=\"255\"/>
                        </div>
                        <div class=\"form-group col-md-2 col-xs-12\">
                            <label>Root</label>
                            <select name=\"root\" class=\"form-control\"></select>
                        </div>
                        <div class=\"form-group col-md-5 col-xs-12\">
                            <label>Controller</label>
                            <input type=\"text\" name=\"controller\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-2 col-xs-5\">
                            <label>Principal</label>
                            <input type=\"number\" name=\"principal\" class=\"form-control\" min=\"0\" max=\"255\"/>
                        </div>
                        <div class=\"form-group col-md-3 col-xs-5\">
                            <label>Ícone</label>
                            <input type=\"text\" name=\"icone\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-3 col-xs-5\">
                            <label>Título</label>
                            <input type=\"text\" name=\"title\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-4 col-xs-5\">
                            <label>Descrição</label>
                            <input type=\"text\" name=\"descricao\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-4 col-xs-5\">
                            <label>Onclick</label>
                            <input type=\"text\" name=\"onclick\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-6 col-xs-5\">
                            <label>Variáveis</label>
                            <input type=\"text\" name=\"variaveis\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-md-2 col-xs-5\">
                            <label>Status</label>
                            <select name=\"status\" class=\"form-control\" required>
                                <option value=\"1\">Ativo</option>
                                <option value=\"2\">Invisível</option>
                                <option value=\"0\">Inativo</option>
                                <option value=\"99\">Excluído</option>
                            </select>
                        </div>
                        ";
        // line 72
        if (($context["isDev"] ?? null)) {
            // line 73
            echo "                            <div class=\"form-group col-xs-12\">
                                <label>Permissões</label>
                                <select name=\"permissoes\" class=\"form-control chosen\" multiple required>
                                    ";
            // line 76
            echo ($context["permissoes"] ?? null);
            echo "
                                </select>
                            </div>
                        ";
        }
        // line 80
        echo "                    </div>
                </div>
                <div class=\"modal-footer\">
                    <div class=\"pull-left\">
                        <button class=\"btn btn-warning\" type=\"button\" onclick=\"javascript:salvarCopia()\">
                            <i class=\"fa fa-copy\"></i> Salvar cópia
                        </button>
                    </div>
                    <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-link\">
                        &times; Cancelar
                    </button>
                    <button class=\"btn btn-primary\" type=\"submit\">
                        <i class=\"fa fa-save\"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class=\"form-container\"></div>

";
    }

    // line 103
    public function block_script($context, array $blocks = array())
    {
        // line 104
        echo "
    <script>

        var form = \$('.admpage-form');

        form
            .adminPage({
                container: '.form-container',
            });

        function salvarCopia() {
            form.find(\"[name=id]\").val(0);
            form.submit();
        }

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/sys/menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  156 => 104,  153 => 103,  128 => 80,  121 => 76,  116 => 73,  114 => 72,  63 => 24,  47 => 10,  44 => 9,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/sys/menu.twig", "/home2/bets01/public_html/app/views/admin/sys/menu.twig");
    }
}
