<?php

/* website/page/pre-bilhete.twig */
class __TwigTemplate_e468e37739574669de13bb6de7e9aec28da6cd38e317457ef2724511389a7aa0 extends Twig_Template
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
        echo "<!doctype html>
<html lang=\"pt-br\">
<head>

    ";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('seo_header')->getCallable(), array()), "html", null, true);
        echo "

</head>
<body onload=\"window.print()\">

<table border='0' cellpadding='0' cellspacing='0' width='305px' style='font-size:16px;'>
    <tbody>
    <tr>
        <td>==================================</td>
    </tr>
    <tr align='center'>
        <td>
            ";
        // line 17
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("banca")), "html", null, true);
        echo "
            <br/>
            Aposte na Emoção
        </td>
    </tr>
    <tr>
        <td>==================================</td>
    </tr>
    <tr>
        <td>
            Data do pré-bilhete: ";
        // line 27
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getData", array(0 => true), "method"), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getHora", array(), "method"), "html", null, true);
        echo "
            <br />
            <br />
        </td>
    </tr>
    <tr align='center'>
        <td>
            CÓDIGO DO BILHETE<br/>
            <span style=\"font-size:26px;\">";
        // line 35
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('preg_replace')->getCallable(), array("/(.{3})/", "\$1 ", twig_get_attribute($this->env, $this->source, ($context["aposta"] ?? null), "getCodigoBilhete", array(), "method"))), "html", null, true);
        echo "</span>
            <br/>
    <tr align='center'>
        <td>Procure um dos nossos cambistas<br/>para validar o seu bilhete</td>
    </tr>
    </tbody>
</table>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "website/page/pre-bilhete.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 35,  57 => 27,  44 => 17,  29 => 5,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/pre-bilhete.twig", "/home2/bets01/public_html/app/views/website/page/pre-bilhete.twig");
    }
}
