<?php

/* admin/apostas/pdf.twig */
class __TwigTemplate_c6d6e98e775dd1ba31397857e24e380f718398a55831bd7d18406349bf8879ca extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<style>

    ";
        // line 3
        $context["text"] = "black";
        // line 4
        echo "    ";
        $context["bg"] = "white";
        // line 5
        echo "
    @page {
        padding: 0 10pt;
        margin: 0;
        width: 320pt;
    }

    html, body {
        background-color: ";
        // line 13
        echo twig_escape_filter($this->env, ($context["bg"] ?? null), "html", null, true);
        echo ";
        font-family: Courier;
        text-transform: uppercase;
        margin: 0px auto;
        width: 300pt;
        color: ";
        // line 18
        echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
        echo ";
        font-size: 10pt;
        line-height: 150%;
        font-weight: normal;
    }

    a {
        color: inherit;
    }

    hr {
        display: block;
        margin: 15px;
        border-bottom: none;
        border-top: 1px dashed";
        // line 32
        echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
        echo ";
    }

    [padding] {
        padding: 0 15px;
    }

    [padding] div {
        clear: both;
    }

    .regras {
        text-align: justify;
    }

    .token {
        text-align: center;
        font-size: 7pt;
    }

    .header {
        padding-top: 15px;
        text-align: center;
    }

    .header .banca {
        padding-top: 15px;
        font-size: 25pt;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .codigo {
        font-size: 18pt;
    }

    .right {
        float: right;
    }

</style>

";
        // line 85
        if ((twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getStatus", array(), "method") == 0)) {
            // line 86
            echo "    Aposta cancelada
";
        } elseif ((twig_get_attribute($this->env, $this->source,         // line 87
($context["aposta"] ?? null), "getStatus", array(), "method") == 3)) {
            // line 88
            echo "    Aposta cancelada por ausência de pagamento
";
        }
        // line 90
        echo "
<div class=\"header\" padding>
    <div class=\"banca\">";
        // line 92
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("banca")), "html", null, true);
        echo "</div>
    <div class=\"site\">";
        // line 93
        echo twig_escape_filter($this->env, twig_replace_filter(call_user_func_array($this->env->getFunction('domain')->getCallable(), array()), array("https://" => "", "http://" => "")), "html", null, true);
        echo "</div>
</div>

<hr/>

<div padding>
    <div>DATA: <span class=\"right\">";
        // line 99
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getData", array(0 => true), "method"), "html", null, true);
        echo "</span></div>
    <div>COLABORADOR: <span class=\"right\">";
        // line 100
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getUserNome", array(), "method"), "html", null, true);
        echo "</span></div>
    <div>CLIENTE: <span class=\"right\">";
        // line 101
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getApostadorNome", array(), "method"), "html", null, true);
        echo "</span></div>
</div>

<hr/>

";
        // line 106
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "voJogos", array(0 => true), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
            // line 107
            echo "    ";
            $context["jogo"] = twig_get_attribute($this->env, $this->source, $context["v"], "voJogo", array(), "method");
            // line 108
            echo "    <div padding>
        <div>Futebol - ";
            // line 109
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["jogo"] ?? null), "getData", array(0 => true), "method"), "html", null, true);
            echo " às ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["jogo"] ?? null), "getHora", array(), "method"), "html", null, true);
            echo "</div>
        <div>";
            // line 110
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["jogo"] ?? null), "getCampeonatoTitle", array(), "method"), "html", null, true);
            echo "</div>
        <div>";
            // line 111
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["jogo"] ?? null), "getTimeCasaTitle", array(), "method"), "html", null, true);
            echo " <b>x</b> ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["jogo"] ?? null), "getTimeForaTitle", array(), "method"), "html", null, true);
            echo "</div>
        <div>Cotação: <span class=\"right\">";
            // line 112
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getCotacaoTitle", array(), "method"), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getCotacaoValor", array(), "method"), "html", null, true);
            echo "</span></div>
        <div>Status: <span class=\"right\">";
            // line 113
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getStatusTitle", array(), "method"), "html", null, true);
            echo "</span>
        </div>
    </div>
    <hr/>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 118
        echo "
<div padding>
    <div>Quantidade de jogos: <span class=\"right\">";
        // line 120
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getJogos", array(), "method"), "html", null, true);
        echo "</span></div>
    <div>Cotação: <span class=\"right\">";
        // line 121
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getCotacaoValida", array(), "method"), "html", null, true);
        echo "</span></div>
    <div>Total apostado: <span class=\"right\">R\$ ";
        // line 122
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getValor", array(0 => true), "method"), "html", null, true);
        echo "</span></div>
    <div>Possível retorno: <span class=\"right\">R\$ ";
        // line 123
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getRetornoValido", array(0 => true), "method"), "html", null, true);
        echo "</span></div>
</div>

<hr/>

<div padding class=\"text-center\">
    <div>BILHETE</div>
    <div class=\"codigo\">";
        // line 130
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getCodigoBilhete", array(), "method"), "html", null, true);
        echo "</div>
</div>

<hr/>

<div class=\"regras\" padding>
    ";
        // line 136
        if (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("ImprimirRegras"))) {
            // line 137
            echo "        <div class=\"regras\">";
            echo call_user_func_array($this->env->getFunction('dados')->getCallable(), array("RegrasAposta"));
            echo "</div>
    ";
        }
        // line 139
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "admin/apostas/pdf.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  253 => 139,  247 => 137,  245 => 136,  236 => 130,  226 => 123,  222 => 122,  218 => 121,  214 => 120,  210 => 118,  199 => 113,  193 => 112,  187 => 111,  183 => 110,  177 => 109,  174 => 108,  171 => 107,  167 => 106,  159 => 101,  155 => 100,  151 => 99,  142 => 93,  138 => 92,  134 => 90,  130 => 88,  128 => 87,  125 => 86,  123 => 85,  67 => 32,  50 => 18,  42 => 13,  32 => 5,  29 => 4,  27 => 3,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/apostas/pdf.twig", "/home2/bets01/public_html/app/views/admin/apostas/pdf.twig");
    }
}
