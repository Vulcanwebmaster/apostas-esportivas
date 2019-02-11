<?php

/* admin/informacoes/cotacoes.twig */
class __TwigTemplate_dc338a2bcb2f41e05e4ee342d9499eb3385a95a1c4b6d0dcbd1479809742711e extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/informacoes/cotacoes.twig", 1);
        $this->blocks = array(
            'style' => array($this, 'block_style'),
            'main' => array($this, 'block_main'),
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
    public function block_style($context, array $blocks = array())
    {
        // line 4
        echo "
    <style>
        .topo-grupo {
            border-bottom: 2px solid #333;
        }

        .topo-grupo .info-topo {
            display: inline-block;
            padding: 10px;
            padding-left: 14px;
            padding-right: 14px;
            background: #333;
            color: #fff;
            font-weight: bold;
            position: relative;
            text-transform: uppercase;
        }

        .arrow {
            position: absolute;
            bottom: -14px;
            left: 0px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 12px 10px 0 10px;
            border-color: #333333 transparent transparent transparent;
        }

        .body-grupo {
            padding: 15px;
            padding-top: 30px;
        }

        .body-grupo ul {
            list-style: none;
            padding: 0px;
            margin: 0px;
            display: flex;
            flex-wrap: wrap;
        }

        .body-grupo ul li {
            padding: 8px;
            border: 1px solid #9e9e9e;
            margin-right: 6px;
            margin-bottom: 6px;
            transition: all 0.3s;
            font-weight: bold !important;
            cursor: pointer;
            color: #000;
        }

        .body-grupo ul li:hover {
            background: #fff;
        }

        .modal-cotacoes h5 {
            display: inline-block;
            font-weight: bold;
        }
    </style>

";
    }

    // line 69
    public function block_main($context, array $blocks = array())
    {
        // line 70
        echo "
    ";
        // line 71
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["grupos"] ?? null));
        foreach ($context['_seq'] as $context["grupoId"] => $context["grupo"]) {
            // line 72
            echo "        ";
            if (twig_in_filter($context["grupoId"], array(0 => 1, 1 => 4, 2 => 7))) {
                // line 73
                echo "            <div class=\"row\">
        ";
            }
            // line 75
            echo "
        <div class=\"col-md-4 col-sm-12 col-xs-12 m-b-20 m-t-20\">
            <div class=\"topo-grupo\">
                <div class=\"info-topo\">
                    ";
            // line 79
            echo twig_escape_filter($this->env, $context["grupo"], "html", null, true);
            echo "
                    <span class=\"arrow\"></span>
                </div>
            </div>
            <div class=\"body-grupo\">
                <ul>
                    ";
            // line 85
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cotacoes"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["cotacao"]) {
                // line 86
                echo "                        ";
                if ((twig_get_attribute($this->env, $this->source, $context["cotacao"], "getGrupo", array(), "method") == $context["grupoId"])) {
                    // line 87
                    echo "                            <li data-toggle=\"modal\" data-target=\"#modal";
                    echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                    echo "\">
                                ";
                    // line 88
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getTitulo", array(), "method"), "html", null, true);
                    echo " (";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getSigla", array(), "method"), "html", null, true);
                    echo ")
                            </li>
                            <div class=\"modal fade modal-cotacoes\" id=\"modal";
                    // line 90
                    echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                    echo "\" tabindex=\"-1\" role=\"dialog\"
                                 aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                                <div class=\"modal-dialog\" role=\"document\">
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\">
                                            <h5 class=\"modal-title\" id=\"exampleModalLabel\">
                                                ";
                    // line 96
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getTitulo", array(), "method"), "html", null, true);
                    echo " (";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cotacao"], "getSigla", array(), "method"), "html", null, true);
                    echo ")
                                            </h5>
                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">&times;</span>
                                            </button>
                                        </div>
                                        <div class=\"modal-body\">
                                            <p>
                                                ";
                    // line 104
                    echo twig_get_attribute($this->env, $this->source, $context["cotacao"], "getDescricao", array(), "method");
                    echo "
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
                }
                // line 111
                echo "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['cotacao'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 112
            echo "                </ul>
            </div>
        </div>

        ";
            // line 116
            if (twig_in_filter($context["grupoId"], array(0 => 3, 1 => 6, 2 => 9))) {
                // line 117
                echo "            </div>
        ";
            }
            // line 119
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['grupoId'], $context['grupo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 120
        echo "
";
    }

    public function getTemplateName()
    {
        return "admin/informacoes/cotacoes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  210 => 120,  204 => 119,  200 => 117,  198 => 116,  192 => 112,  186 => 111,  176 => 104,  163 => 96,  154 => 90,  147 => 88,  142 => 87,  139 => 86,  135 => 85,  126 => 79,  120 => 75,  116 => 73,  113 => 72,  109 => 71,  106 => 70,  103 => 69,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/informacoes/cotacoes.twig", "/home2/bets01/public_html/app/views/admin/informacoes/cotacoes.twig");
    }
}
