<?php

/* admin/cadastros/times.twig */
class __TwigTemplate_da8f130c414450388ad3500161350653783b1b6c5bbafaac60f144f09bde2b7c extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/cadastros/times.twig", 1);
        $this->blocks = array(
            'list' => array($this, 'block_list'),
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
    public function block_list($context, array $blocks = array())
    {
        // line 4
        echo "
    ";
        // line 5
        if (twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getCount", array(), "method")) {
            // line 6
            echo "        <div class=\"panel\">
            <div class=\"panel-body p-0\">
                <div class=\"table-responsive m-0\">
                    <table class=\"m-0 table table-striped table-bordered table-hover\">
                        <thead>
                        <tr>
                            <th width=\"80\" class=\"text-center\"><i class=\"fa fa-flag\"></i></th>
                            <th>Time</th>
                            <th width=\"5\">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        ";
            // line 18
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getRegistros", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 19
                echo "                            <tr>
                                <td class=\"text-center\">
                                    <img src=\"";
                // line 21
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "imgCapa", array(), "method"), "redimensiona", array(0 => 0, 1 => 30), "method"), "html", null, true);
                echo "\" />
                                </td>
                                <td>";
                // line 23
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getTitle", array(), "method"), "html", null, true);
                echo "</td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <div class=\"btn btn-default\" data-editar=\"";
                // line 26
                echo twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, $context["v"], "toArray", array(0 => true), "method")), "html", null, true);
                echo "\">
                                            <i class=\"fa fa-edit\"></i>
                                        </div>
                                        <div class=\"btn btn-danger\" data-excluir=\"";
                // line 29
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getToken", array(), "method"), "html", null, true);
                echo "\">
                                            <i class=\"fa fa-trash\"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            echo "                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"panel-footer text-right\">";
            // line 40
            echo ($context["busca"] ?? null);
            echo "</div>
        </div>
    ";
        } elseif (        // line 42
($context["message"] ?? null)) {
            // line 43
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> ";
            // line 44
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
        </div>
    ";
        } else {
            // line 47
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
        </div>
    ";
        }
        // line 51
        echo "
";
    }

    // line 54
    public function block_links($context, array $blocks = array())
    {
        // line 55
        echo "
    <button type=\"button\" class=\"btn btn-warning btn-danger btn-importar\">
        <i class=\"fa fa-upload\"></i> Importar
    </button>

    <button type=\"button\" onclick=\"\$('.admpage-form').setValues({});\" class=\"btn btn-success\">
        <i class=\"fa fa-plus\"></i> Novo
    </button>

";
    }

    // line 66
    public function block_main($context, array $blocks = array())
    {
        // line 67
        echo "
    <form class=\"modal fade admpage-form\" enctype=\"multipart/form-data\">
        <input type=\"hidden\" name=\"id\"/>
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Time</h3>
                </div>
                <div class=\"modal-body\">
                    <label>Nome</label>
                    <input type=\"text\" name=\"title\" class=\"form-control\"/>
                </div>
                <div class=\"modal-footer\">
                    <div class=\"pull-left\">
                        ";
        // line 82
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array("<i class=\"fa fa-image\"></i> Logo", "upimg", "image/*")), "html", null, true);
        echo "
                    </div>
                    <button class=\"btn btn-link\" type=\"button\">
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

    // line 112
    public function block_script($context, array $blocks = array())
    {
        // line 113
        echo "
    <script>

        var container = \$('.admpage-container');

        \$('.admpage-form')
            .adminPage({
                formSearch: '.admpage-form-search',
                container: container,
            });

        \$('.btn-importar')
            .on(\"click\", function () {
                if (confirm(\"Deseja prosseguir com a importação de times para o sistema?\")) {

                    \$('html').addClass('page-loading');

                    \$
                        .get(url(CONTROLLER + '/importar'), function (e) {
                            alert(e.message);
                        }, 'json')
                        .fail(function () {
                            alert(\"Não foi possível importar os times, tente noavamente mais tarde.\");
                        })
                        .always(function () {
                            \$('html').removeClass('page-loading');
                        });

                }
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/cadastros/times.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 113,  197 => 112,  164 => 82,  147 => 67,  144 => 66,  131 => 55,  128 => 54,  123 => 51,  117 => 47,  111 => 44,  108 => 43,  106 => 42,  101 => 40,  95 => 36,  82 => 29,  76 => 26,  70 => 23,  65 => 21,  61 => 19,  57 => 18,  43 => 6,  41 => 5,  38 => 4,  35 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/cadastros/times.twig", "/home2/bets01/public_html/app/views/admin/cadastros/times.twig");
    }
}
