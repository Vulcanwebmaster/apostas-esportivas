<?php

/* admin/impressoras.twig */
class __TwigTemplate_c8067da6a936aa788520671e663342c043c974df87fb533ad1c7e41dbc1522d9 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/impressoras.twig", 1);
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
        echo "    <button class=\"btn btn-primary\" onclick=\"\$('.admpage-form').setValues()\">
        <i class=\"fa fa-plus\"></i> Nova
    </button>
";
    }

    // line 9
    public function block_main($context, array $blocks = array())
    {
        // line 10
        echo "
    <form class=\"admpage-form modal fade\" onsubmit=\"return false;\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\"><i class=\"fa fa-print\"></i> Impressora</h3>
                </div>
                <div class=\"modal-body p-b-10\">
                    <div class=\"row\">
                        <div class=\"form-group col-md-2 col-xs-4\">
                            <label>Ordem</label>
                            <input type=\"number\" class=\"form-control\" name=\"ordem\"/>
                        </div>
                        <div class=\"form-group col-md-3 col-xs-8\">
                            <label>Tipo</label>
                            <select class=\"form-control\" name=\"tipo\">
                                ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(array(0 => 80, 1 => 58));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 28
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $context["i"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["i"], "html", null, true);
            echo "mm</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo "                            </select>
                        </div>
                        <div class=\"form-group col-md-7 col-xs-12\">
                            <label>Título</label>
                            <input type=\"text\" class=\"form-control\" name=\"title\" required maxlength=\"500\"/>
                        </div>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <div class=\"pull-left\">
                        ";
        // line 40
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array("<i class=\"fa fa-image\"></i> Imagem", "upcapa", "image/*")), "html", null, true);
        echo "
                    </div>
                    <button class=\"btn btn-link\" type=\"button\" data-dismiss=\"modal\">
                        &times; Cancelar
                    </button>
                    <button class=\"btn btn-primary\" type=\"submit\">
                        <i class=\"fa fa-plus\"></i> Novo
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class=\"admpage-container\"></div>

";
    }

    // line 57
    public function block_script($context, array $blocks = array())
    {
        // line 58
        echo "    <script>
        \$('.admpage-form')
            .adminPage({
                container: '.admpage-container',
            })
    </script>
";
    }

    public function getTemplateName()
    {
        return "admin/impressoras.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 58,  113 => 57,  93 => 40,  81 => 30,  70 => 28,  66 => 27,  47 => 10,  44 => 9,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/impressoras.twig", "/home2/bets01/public_html/app/views/admin/impressoras.twig");
    }
}
