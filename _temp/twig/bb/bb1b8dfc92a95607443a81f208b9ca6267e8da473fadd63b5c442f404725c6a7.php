<?php

/* website/page/bilhete.twig */
class __TwigTemplate_044aaeb656f237fecda2fdc6386e242cd413aa4d22b9c66ce38af1d8ce5fbddd extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/bilhete.twig", 1);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
            'bilhete' => array($this, 'block_bilhete'),
            'script' => array($this, 'block_script'),
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
    <h3 class=\"page-title\"><i class=\"fa fa-ticket\"></i> Consulta de Bilhete</h3>
    <div class=\"container pt-3 pb-3\">
        <form class=\"admpage-form\">
            <div class=\"row\">
                <div class=\"col-12\">
                    <label>Código</label>
                    <div class=\"input-group input-group-lg\">
                        <input type=\"text\" maxlength=\"12\" name=\"codigo\" class=\"form-control\"/>
                        <div class=\"input-group-append\">
                            <button class=\"btn btn-danger\">
                                <i class=\"fa fa-search\"></i> Pesquisar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class=\"admpage-container\"></div>
    </div>

";
    }

    // line 28
    public function block_bilhete($context, array $blocks = array())
    {
        // line 29
        echo "    <table class=\"table table-striped table-bordered table-hover mb-0\">
        <tbody>
        <tr>
            <th>Código:</th>
            <td colspan=\"3\">";
        // line 33
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getCodigoBilhete", array(), "method"), "html", null, true);
        echo "</td>
        </tr>
        <tr>
            <th>Cliente:</th>
            <td>";
        // line 37
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getApostadorNome", array(), "method"), "html", null, true);
        echo "</td>
            <th>Usuário:</th>
            <td>";
        // line 39
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getNome", array(), "method"), "html", null, true);
        echo "</td>
        </tr>
        <tr>
            <th>Valor da aposta:</th>
            <td>";
        // line 43
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getValor", array(0 => true), "method"), "html", null, true);
        echo "</td>
            <th>Número de jogos:</th>
            <td>";
        // line 45
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getJogos", array(), "method"), "html", null, true);
        echo "</td>
        </tr>
        <tr>
            <th>Data:</th>
            <td>";
        // line 49
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getData", array(0 => true), "method"), "html", null, true);
        echo "</td>
            <th>Valor do prêmio:</th>
            <td>R\$ ";
        // line 51
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getRetornoValido", array(0 => true), "method"), "html", null, true);
        echo "</td>
        </tr>
        <tr>
            <th>Qtd. Acertos:</th>
            <td>";
        // line 55
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "get", array(0 => "acertos"), "method"), "html", null, true);
        echo "</td>
            <th>Situação:</th>
            <td>
                ";
        // line 58
        if ((twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getStatus", array(), "method") == 1)) {
            // line 59
            echo "                    ";
            echo ((twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getVerificado", array(), "method")) ? (((twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getGanhou", array(), "method")) ? ("Ganhou") : ("Perdeu"))) : ("Aguardando conclusão dos jogos"));
            echo "
                ";
        } else {
            // line 61
            echo "                    ";
            echo twig_escape_filter($this->env, (($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = array(0 => "Cancelada", 2 => "Aguardando pagamento", 3 => "Não recebeu pagamento", 99 => "Excluída")) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5[twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getStatus", array(), "method")] ?? null) : null), "html", null, true);
            echo "
                ";
        }
        // line 63
        echo "            </td>
        </tr>
        </tbody>
    </table>


    ";
        // line 69
        if ((twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getStatus", array(), "method") == 2)) {
            // line 70
            echo "        <div class=\"text-right pt-3\">
            <form onsubmit=\"javascript:return false;\" class=\"form-bilhete\">
                <input type=\"hidden\" name=\"token\" value=\"";
            // line 72
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getToken", array(), "method"), "html", null, true);
            echo "\">
                <button class=\"btn btn-danger\">
                    <i class=\"fa fa-check\"></i> Validar aposta
                </button>
            </form>
        </div>
        <script>
            \$('.form-bilhete')
                .adminPage({
                    autoSearch: false,
                    controller: 'bilhete',
                    insertAction: 'validar',
                    alertSuccess: true,
                })
                .on(\"success\", function (event, e) {
                    if (e.result == 1)
                        page.reloadSearch();
                });
        </script>
    ";
        }
        // line 92
        echo "
";
    }

    // line 95
    public function block_script($context, array $blocks = array())
    {
        // line 96
        echo "
    <script>

        var page = \$
            .adminPage({
                formSearch: '.admpage-form',
                container: '.admpage-container',
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "website/page/bilhete.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  180 => 96,  177 => 95,  172 => 92,  149 => 72,  145 => 70,  143 => 69,  135 => 63,  129 => 61,  123 => 59,  121 => 58,  115 => 55,  108 => 51,  103 => 49,  96 => 45,  91 => 43,  84 => 39,  79 => 37,  72 => 33,  66 => 29,  63 => 28,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/bilhete.twig", "/home2/bets01/public_html/app/views/website/page/bilhete.twig");
    }
}
