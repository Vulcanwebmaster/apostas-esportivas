<?php

/* admin/financeiro/historico.twig */
class __TwigTemplate_b02f845d0d70e1a3d12ed22c6d347ea0efbda188067ddd90805c0bc2314b5293 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/financeiro/historico.twig", 1);
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
    <form class=\"panel panel-default admpage-form-search\">
        <div class=\"panel-body p-b-10\">
            <div class=\"row\">
                ";
        // line 8
        if (($context["users"] ?? null)) {
            // line 9
            echo "                    <div class=\"form-group col-xs-12\">
                        <label>Usuário/Cambista</label>
                        <select name=\"user\" class=\"form-control chosen\">
                            <option value>Meu prório histórico</option>
                            ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["users"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
                // line 14
                echo "                                <option value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getId", array(), "method"), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getNome", array(), "method"), "html", null, true);
                echo "</option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 16
            echo "                        </select>
                    </div>
                ";
        }
        // line 19
        echo "                <div class=\"form-group col-md-5 col-xs-12\">
                    <label>Período</label>
                    <div class=\"input-group input-financeiro\">
                        <div class=\"input-group-addon\">
                            DE:
                        </div>
                        <input type=\"date\" class=\"form-control\" name=\"dataInicial\" value=\"";
        // line 25
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-01"), "html", null, true);
        echo "\" required/>
                        <div class=\"input-group-addon\">
                            ATÉ:
                        </div>
                        <input type=\"date\" class=\"form-control\" name=\"dataFinal\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-t"), "html", null, true);
        echo "\" required/>
                    </div>
                </div>
                <div class=\"form-group col-md-7 col-xs-12\">
                    <label>Pesquisar</label>
                    <div class=\"input-group\">
                        <input type=\"text\" name=\"search\" class=\"form-control\" />
                        <div class=\"input-group-btn\">
                            <button class=\"btn btn-roxo\" type=\"submit\">
                                <i class=\"fa fa-filter\"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class=\"admpage-container\"></div>

";
    }

    // line 51
    public function block_script($context, array $blocks = array())
    {
        // line 52
        echo "
<script>

    var formSearch = \$('.admpage-form-search');

    formSearch
        .on(\"click\", \"[data-group]\", function () {
            var btn = \$(this);

            if (!btn.hasClass('active')) {

                var group = btn.attr('data-group');
                var ativo = \$('[data-group=' + group + '].active');

                ativo.removeClass('active').toggleClass('btn-default btn-primary');
                btn.addClass('active').toggleClass('btn-default btn-primary');

                formSearch.find('[name=' + group + ']').val(btn.val());

                formSearch.submit();
            }
        });

    \$('<div />')
        .adminPage({
            formSearch: formSearch,
            container: '.admpage-container',
            autoSearch: false,
        });


    formSearch.submit();

</script>

";
    }

    public function getTemplateName()
    {
        return "admin/financeiro/historico.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 52,  110 => 51,  85 => 29,  78 => 25,  70 => 19,  65 => 16,  54 => 14,  50 => 13,  44 => 9,  42 => 8,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/financeiro/historico.twig", "/home2/bets01/public_html/app/views/admin/financeiro/historico.twig");
    }
}
