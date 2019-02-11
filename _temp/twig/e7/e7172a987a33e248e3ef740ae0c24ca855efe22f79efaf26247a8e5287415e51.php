<?php

/* website/inc/header.twig */
class __TwigTemplate_107ca6543b04ba51b820086e4f72ee7d98551ee44ed58111895617d0c15e71a0 extends Twig_Template
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
        if (($context["responsive"] ?? null)) {
            // line 2
            echo "    <header class=\"header-mobile d-blok d-md-none\">
        <div class=\"container-fluid\">
            <div class=\"row align-items-center\">
                <div class=\"col\">
                    <img src=\"";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, call_user_func_array($this->env->getFunction('dados')->getCallable(), array()), "imgCapa", array(0 => true, 1 => "logo"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
            echo "\" height=\"45\"/>
                </div>
                <div class=\"col-auto\">
                    <a href=\"app.apk\" class=\"btn btn-link\" target=\"_blank\">
                        <span class=\"text-success\">
                            <i class=\"fa fa-android\"></i> APP
                        </span>
                    </a>
                </div>
                <div class=\"col-auto\">
                    <button class=\"btn btn-link\" onclick=\"\$('html').toggleClass('show-menu');\">
                        <i class=\"fa fa-bars\"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <div class=\"menu-mobile\">
        <div class=\"header\">
            <i class=\"fa fa-bars\"></i> Menu
        </div>
        <ul>
            <li>
                <a href=\"";
            // line 29
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array()), "html", null, true);
            echo "\">
                    Apostar
                </a>
            </li>
            <li>
                <a href=\"";
            // line 34
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("bilhete")), "html", null, true);
            echo "\">
                    Consultar bilhete
                </a>
            </li>
            ";
            // line 38
            if (($context["user"] ?? null)) {
                // line 39
                echo "                <li>
                    <a href=\"";
                // line 40
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("apostas")), "html", null, true);
                echo "\">
                        Minhas apostas
                    </a>
                </li>
                <li>
                    <a href=\"";
                // line 45
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("logout")), "html", null, true);
                echo "\">
                        Sair
                    </a>
                </li>
            ";
            } else {
                // line 50
                echo "                <li>
                    <a href=\"#modal-login\" data-toggle=\"modal\" onclick=\"\$('html').removeClass('show-menu');\">
                        Entrar
                    </a>
                </li>
            ";
            }
            // line 56
            echo "        </ul>
    </div>
";
        }
        // line 59
        echo "
<header class=\"pt-4 pb-4 ";
        // line 60
        echo ((($context["responsive"] ?? null)) ? ("d-none d-md-block") : (""));
        echo "\">
    <div class=\"app-container container\">
        <div class=\"row justify-content-center align-items-center\">
            <div class=\"col\">
                <a href=\"./\">
                    <img src=\"";
        // line 65
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, call_user_func_array($this->env->getFunction('dados')->getCallable(), array()), "imgCapa", array(0 => true, 1 => "logo"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
        echo "\" class=\"img-fluid\"/>
                </a>
            </div>
            ";
        // line 68
        if ( !($context["user"] ?? null)) {
            // line 69
            echo "                <div class=\"col-auto d-none d-md-block\">
                    <h6 class=\"text-white\">Faça login</h6>
                    <div class=\"row align-items-center\">
                        <div class=\"col-auto\">
                            <form id=\"form-login\" onsubmit=\"return false;\">
                                <div class=\"row\">
                                    <div class=\"col\">
                                        <input type=\"text\" name=\"username\" class=\"form-control form-control-sm\" required
                                               placeholder=\"Login/E-mail\"/>
                                    </div>
                                    <div class=\"col\">
                                        <input type=\"password\" name=\"password\" class=\"form-control form-control-sm\"
                                               required
                                               readonly placeholder=\"Senha\"/>
                                    </div>
                                    <div class=\"col-auto\">
                                        <button class=\"btn btn-warning btn-sm\">
                                            <i class=\"fa fa-sign-in\"></i> Entrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class=\"text-right\">
                        <a href=\"#recuperar-senha\" data-toggle=\"modal\" class=\"btn btn-sm btn-link text-white\">Esqueceu a
                            senha?</a>
                        <a href=\"";
            // line 96
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("cadastrar")), "html", null, true);
            echo "\" class=\"btn btn-sm btn-link text-white\">Cadastre-se</a>
                    </div>
                </div>
            ";
        } else {
            // line 100
            echo "                <div class=\"col-auto d-none d-md-block text-white text-right\" style=\"line-height: 100%;\">
                    <div class=\"row align-items-center\">
                        <div class=\"col-auto pr-0\">
                            <div>";
            // line 103
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getNome", array(), "method"), "html", null, true);
            echo "</div>
                            <small>
                                <span class=\"text-warning\">";
            // line 105
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getTypetitle", array(), "method"), "html", null, true);
            echo "</span>
                                |
                                <a href=\"";
            // line 107
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("logout")), "html", null, true);
            echo "\" class=\"text-white\">Sair</a>
                            </small>
                        </div>
                        <div class=\"col-auto\">
                            <img src=\"";
            // line 111
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "imgCapa", array(), "method"), "redimensiona", array(0 => 50, 1 => 50), "method"), "html", null, true);
            echo "\"
                                 class=\"rounded-circle img-fluid border\"/>
                        </div>
                    </div>
                </div>
            ";
        }
        // line 117
        echo "        </div>
    </div>
</header>";
    }

    public function getTemplateName()
    {
        return "website/inc/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  192 => 117,  183 => 111,  176 => 107,  171 => 105,  166 => 103,  161 => 100,  154 => 96,  125 => 69,  123 => 68,  117 => 65,  109 => 60,  106 => 59,  101 => 56,  93 => 50,  85 => 45,  77 => 40,  74 => 39,  72 => 38,  65 => 34,  57 => 29,  31 => 6,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/inc/header.twig", "/home2/bets01/public_html/app/views/website/inc/header.twig");
    }
}
