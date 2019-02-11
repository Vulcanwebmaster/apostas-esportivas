<?php

/* admin/config/graduacoes.twig */
class __TwigTemplate_dd692d1edb182bed5bf4945d091b1876d679ad14b04e3a51d152fec3d608db23 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/config/graduacoes.twig", 1);
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
                            <th width=\"80\" class=\"text-center\"><i class=\"fa fa-sort-amount-asc\"></i></th>
                            <th>Graduação</th>
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
                                <td class=\"text-center\">";
                // line 20
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getOrdem", array(), "method"), "html", null, true);
                echo "</td>
                                <td>";
                // line 21
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getTitle", array(), "method"), "html", null, true);
                echo "</td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <div class=\"btn btn-default\" data-editar=\"";
                // line 24
                echo twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, $context["v"], "toArray", array(0 => true), "method")), "html", null, true);
                echo "\">
                                            <i class=\"fa fa-edit\"></i>
                                        </div>
                                        <div class=\"btn btn-danger\" data-excluir=\"";
                // line 27
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
            // line 34
            echo "                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"panel-footer text-right\">";
            // line 38
            echo ($context["busca"] ?? null);
            echo "</div>
        </div>
    ";
        } elseif (        // line 40
($context["message"] ?? null)) {
            // line 41
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> ";
            // line 42
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "
        </div>
    ";
        } else {
            // line 45
            echo "        <div class=\"alert alert-warning\">
            <i class=\"fa fa-warning\"></i> Nenhum registro encontrado
        </div>
    ";
        }
        // line 49
        echo "
";
    }

    // line 52
    public function block_links($context, array $blocks = array())
    {
        // line 53
        echo "
    <button class=\"btn btn-primary\" onclick=\"\$('.admpage-form').setValues()\">
        <i class=\"fa fa-plus\"></i> Nova graduação
    </button>

";
    }

    // line 60
    public function block_main($context, array $blocks = array())
    {
        // line 61
        echo "
    <form class=\"admpage-form modal fade\" enctype=\"multipart/form-data\" onsubmit=\"javascript:return false;\">
        <input type=\"hidden\" name=\"id\"/>
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Graduação</h3>
                </div>
                <div class=\"modal-body p-b-10\">
                    <div class=\"row\">
                        <div class=\"form-group col-xs-3\">
                            <label>Ordem</label>
                            <input type=\"number\" name=\"ordem\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-xs-9\">
                            <label>Título</label>
                            <input type=\"text\" name=\"title\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-xs-12\">
                            <label>Descrição</label>
                            <input type=\"text\" name=\"descricao\" class=\"form-control\"/>
                        </div>
                        <div class=\"form-group col-xs-4\">
                            <label>Comissão 1 jogo</label>
                            <div class=\"input-group\">
                                <input type=\"number\" class=\"form-control\" name=\"jogos1\" step=\"0.01\"/>
                                <div class=\"input-group-addon\">%</div>
                            </div>
                        </div>
                        <div class=\"form-group col-xs-4\">
                            <label>Comissão 2 jogos</label>
                            <div class=\"input-group\">
                                <input type=\"number\" class=\"form-control\" name=\"jogos2\" step=\"0.01\"/>
                                <div class=\"input-group-addon\">%</div>
                            </div>
                        </div>
                        <div class=\"form-group col-xs-4\">
                            <label>Comissão 3 jogos ou mais</label>
                            <div class=\"input-group\">
                                <input type=\"number\" class=\"form-control\" name=\"jogos3\" step=\"0.01\"/>
                                <div class=\"input-group-addon\">%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <div class=\"pull-left\">
                        ";
        // line 109
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array("Imagem", "upcapa", "image/*")), "html", null, true);
        echo "
                    </div>
                    <button class=\"btn btn-link\" type=\"button\" data-dismiss=\"modal\">
                        &times; Limpar
                    </button>
                    <button class=\"btn btn-primary\" type=\"submit\">
                        <i class=\"fa fa-save\"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class=\"admpage-container\"></div>

";
    }

    // line 126
    public function block_script($context, array $blocks = array())
    {
        // line 127
        echo "
    <script>

        \$('.admpage-form')
            .adminPage({
                container: '.admpage-container',
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/config/graduacoes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  214 => 127,  211 => 126,  191 => 109,  141 => 61,  138 => 60,  129 => 53,  126 => 52,  121 => 49,  115 => 45,  109 => 42,  106 => 41,  104 => 40,  99 => 38,  93 => 34,  80 => 27,  74 => 24,  68 => 21,  64 => 20,  61 => 19,  57 => 18,  43 => 6,  41 => 5,  38 => 4,  35 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/config/graduacoes.twig", "/home2/bets01/public_html/app/views/admin/config/graduacoes.twig");
    }
}
