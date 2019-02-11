<?php

/* admin/helpers/comunicados.twig */
class __TwigTemplate_3f99e8ae3918c2c71b0ac26d9b69f28a2bf4a4ac854ef73a31d5971721f01653 extends Twig_Template
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
        $context["comunicados"] = call_user_func_array($this->env->getFunction('comunicados')->getCallable(), array());
        // line 2
        echo "
";
        // line 3
        if (($context["comunicados"] ?? null)) {
            // line 4
            echo "
    <div class=\"row m-t-10 m-b-10\">
        <div class=\"col-xs-12\">
            <div class=\"panel panel-default panel-roxo\">
                <div class=\"panel-heading\">
                    <h4 class=\"modal-title\">
                        Comunicados
                    </h4>
                </div>
                <div class=\"panel-body panel-table\">
                    <ul class=\"lista-comunicados\">
                        ";
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["comunicados"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                // line 16
                echo "                            <li>
                                <div class=\"date-comunicado\">
                                    <i class=\"fa fa-calendar\"></i>
                                    ";
                // line 19
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getData", array(0 => true), "method"), "html", null, true);
                echo " às ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getHora", array(), "method"), "html", null, true);
                echo "
                                </div>
                                <div class=\"titulo-comunicado\">
                                    ";
                // line 22
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getTitle", array(), "method"), "html", null, true);
                echo "
                                </div>
                                <div class=\"acoes\">
                                    <button data-toggle=\"modal\" data-target=\"#modal-comunicado";
                // line 25
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getId", array(), "method"), "html", null, true);
                echo "\"
                                            class=\"btn btn-info\">
                                        <i class=\"fa fa-eye\"></i>
                                        Visualizar
                                    </button>
                                </div>
                            </li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 33
            echo "                    </ul>
                </div>
            </div>
        </div>
    </div>

    ";
            // line 39
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["comunicados"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                // line 40
                echo "        <div class=\"modal fade modal-comunicado\" id=\"modal-comunicado";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getId", array(), "method"), "html", null, true);
                echo "\" tabindex=\"-1\" role=\"dialog\"
             aria-hidden=\"true\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"exampleModalLabel\">
                            <i class=\"fa fa-info\"></i> Comunicado
                        </h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <div class=\"titulo\">
                            ";
                // line 54
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["c"], "getTitle", array(), "method"), "html", null, true);
                echo "
                        </div>
                        <div class=\"texto\">
                            ";
                // line 57
                echo twig_get_attribute($this->env, $this->source, $context["c"], "getMensagem", array(), "method");
                echo "
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "admin/helpers/comunicados.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 64,  116 => 57,  110 => 54,  92 => 40,  88 => 39,  80 => 33,  66 => 25,  60 => 22,  52 => 19,  47 => 16,  43 => 15,  30 => 4,  28 => 3,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/comunicados.twig", "/home2/bets01/public_html/app/views/admin/helpers/comunicados.twig");
    }
}
