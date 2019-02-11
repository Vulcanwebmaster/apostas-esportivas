<?php

/* admin/cadastros/campeonatos.twig */
class __TwigTemplate_6240e06dcafe87ab6124b786f78ef1900076c4c9ef435f07c7feda99a7e4d64f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/cadastros/campeonatos.twig", 1);
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
                            <th class=\"text-center\" width=\"60\"><i class=\"fa fa-image\"></i></th>
                            <th>Campeonato/País</th>
                            <th width=\"5\">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td colspan=\"2\">";
            // line 19
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getPageDescription", array(), "method"), "html", null, true);
            echo "</td>
                        </tr>
                        </tfoot>
                        <tbody>
                        ";
            // line 23
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["busca"] ?? null), "getRegistros", array(), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 24
                echo "                            <tr>
                                <td class=\"text-center\">
                                    ";
                // line 26
                if (twig_get_attribute($this->env, $this->source, $context["v"], "voPais", array(), "method")) {
                    // line 27
                    echo "                                        <img src=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["v"], "voPais", array(), "method"), "imgCapa", array(), "method"), "redimensiona", array(0 => 0, 1 => 30), "method"), "html", null, true);
                    echo "\"/>
                                    ";
                }
                // line 29
                echo "                                </td>
                                <td>
                                    <b>";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getTitle", array(), "method"), "html", null, true);
                echo "</b>
                                    <div>";
                // line 32
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getPaisTitle", array(), "method"), "html", null, true);
                echo "</div>
                                </td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <div class=\"btn btn-default\" data-editar=\"";
                // line 36
                echo twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, $context["v"], "toArray", array(0 => true), "method")), "html", null, true);
                echo "\">
                                            <i class=\"fa fa-edit\"></i>
                                        </div>
                                        <div class=\"btn btn-danger\" data-excluir=\"";
                // line 39
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
            // line 46
            echo "                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"panel-footer text-right\">";
            // line 50
            echo ($context["busca"] ?? null);
            echo "</div>
        </div>
    ";
        } elseif (        // line 52
($context["message"] ?? null)) {
            // line 53
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> ";
            // line 54
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
        </div>
    ";
        } else {
            // line 57
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
        </div>
    ";
        }
        // line 61
        echo "
";
    }

    // line 64
    public function block_links($context, array $blocks = array())
    {
        // line 65
        echo "
    <button type=\"button\" class=\"btn btn-warning btn-danger btn-importar\">
        <i class=\"fa fa-upload\"></i> Importar
    </button>

    <button type=\"button\" onclick=\"\$('.admpage-form').setValues({});\" class=\"btn btn-success\">
        <i class=\"fa fa-plus\"></i> Novo
    </button>

";
    }

    // line 76
    public function block_main($context, array $blocks = array())
    {
        // line 77
        echo "
    <form class=\"modal fade admpage-form\">
        <input type=\"hidden\" name=\"id\"/>
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Campeonato</h3>
                </div>
                <div class=\"modal-body\">
                    <div class=\"row\">
                        <div class=\"form-group col-xs-4\">
                            <label>País</label>
                            <select name=\"pais\" class=\"form-control\" required
                                    data-options=\"admin/helpers/options/options/paises\">
                                <option value>Selecione</option>
                            </select>
                        </div>
                        <div class=\"form-group col-xs-8\">
                            <label>Campeonato</label>
                            <input type=\"text\" name=\"title\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div>
                        <label>Times</label>
                        <select name=\"times\" multiple class=\"form-control chosen\"
                                data-options=\"admin/cadastros/times/options\"></select>
                    </div>
                </div>
                <div class=\"modal-footer\">
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

    // line 135
    public function block_script($context, array $blocks = array())
    {
        // line 136
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
                if (confirm(\"Deseja prosseguir com a importação de campeonatos para o sistema?\")) {

                    \$('html').addClass('page-loading');

                    \$
                        .get(url(CONTROLLER + '/importar'), function (e) {
                            alert(e.message);
                        }, 'json')
                        .fail(function () {
                            alert(\"Não foi possível importar os campeonatos, tente noavamente mais tarde.\");
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
        return "admin/cadastros/campeonatos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 136,  227 => 135,  167 => 77,  164 => 76,  151 => 65,  148 => 64,  143 => 61,  137 => 57,  131 => 54,  128 => 53,  126 => 52,  121 => 50,  115 => 46,  102 => 39,  96 => 36,  89 => 32,  85 => 31,  81 => 29,  75 => 27,  73 => 26,  69 => 24,  65 => 23,  58 => 19,  43 => 6,  41 => 5,  38 => 4,  35 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/cadastros/campeonatos.twig", "/home2/bets01/public_html/app/views/admin/cadastros/campeonatos.twig");
    }
}
