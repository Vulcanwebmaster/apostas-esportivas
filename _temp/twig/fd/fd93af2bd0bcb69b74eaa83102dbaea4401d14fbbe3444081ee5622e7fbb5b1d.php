<?php

/* website/layout.twig */
class __TwigTemplate_3aff91fe4c4fefe6b60237b8fbb45ac2b0537c5c743b13fd32dcbb333f1c3b22 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'main' => array($this, 'block_main'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html lang=\"pt-br\" class=\"pre-loading ";
        // line 2
        echo ((($context["responsive"] ?? null)) ? ("responsive") : (null));
        echo "\">
<head>

    ";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('seo_header')->getCallable(), array()), "html", null, true);
        echo "

    <link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,700\" rel=\"stylesheet\">

    <link rel=\"stylesheet\" href=\"css/bootstrap4.css\"/>
    <link rel=\"stylesheet\" href=\"css/site.css?v=1.0.4\"/>
    <link rel=\"stylesheet\" href=\"css/loading.css\"/>

    <style>
        html {
            background-image: url('";
        // line 15
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, call_user_func_array($this->env->getFunction('dados')->getCallable(), array()), "imgCapa", array(0 => true, 1 => "background"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
        echo "');
        }
    </style>

</head>
<body>

";
        // line 22
        $this->loadTemplate("website/inc/header.twig", "website/layout.twig", 22)->display($context);
        // line 23
        echo "
<div class=\"app-container container\">
    <div class=\"app shadow-lg rounded border mb-3\">
        <header class=\"app-header rounded-top\">
            <div class=\"row justify-content-end\">
                <div class=\"col ";
        // line 28
        echo ((($context["responsive"] ?? null)) ? ("d-none d-md-block") : (""));
        echo "\">
                    <ul>
                        <li>
                            <a href=\"";
        // line 31
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array()), "html", null, true);
        echo "\">
                                Apostar
                            </a>
                        </li>
                        <li>
                            <a href=\"";
        // line 36
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("bilhete")), "html", null, true);
        echo "\">
                                Consultar bilhete
                            </a>
                        </li>
                        ";
        // line 40
        if (($context["user"] ?? null)) {
            // line 41
            echo "                            <li>
                                <a href=\"";
            // line 42
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("apostas")), "html", null, true);
            echo "\">
                                    Minhas apostas
                                </a>
                            </li>
                            <li>
                                <a href=\"";
            // line 47
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("logout")), "html", null, true);
            echo "\">
                                    Sair
                                </a>
                            </li>
                        ";
        }
        // line 52
        echo "                    </ul>
                </div>
                ";
        // line 54
        if (($context["user"] ?? null)) {
            // line 55
            echo "                    <div class=\"col-auto\">
                        <a href=\"";
            // line 56
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("saldo")), "html", null, true);
            echo "\" class=\"text-white\">
                            Meu saldo: <span class=\"text-warning\">R\$ ";
            // line 57
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getCredito", array(0 => true), "method"), "html", null, true);
            echo "</span>
                        </a>
                    </div>
                ";
        }
        // line 61
        echo "            </div>
        </header>
        <main class=\"app-main\">
            ";
        // line 64
        $this->displayBlock('main', $context, $blocks);
        // line 65
        echo "        </main>
        <footer class=\"app-footer rounded-bottom\">
            <div class=\"container-fluid\">
                <div class=\"row ";
        // line 68
        echo ((($context["responsive"] ?? null)) ? ("justify-content-center justify-content-md-between") : ("justify-content-between"));
        echo "\">
                    <div class=\"col-auto\">
                        ©";
        // line 70
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " Todos os direitos reservados.
                    </div>
                    ";
        // line 72
        if (($context["responsive"] ?? null)) {
            // line 73
            echo "                        <div class=\"col-12 d-block d-md-none\">
                            <hr class=\"my-1\"/>
                        </div>
                    ";
        }
        // line 77
        echo "                    <div class=\"col-auto\">
                        <ul>
                            <li><a href=\"";
        // line 79
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("termos-uso")), "html", null, true);
        echo "\">Termos de uso</a></li>
                            <li>|</li>
                            <li><a href=\"";
        // line 81
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("regras")), "html", null, true);
        echo "\">Regras</a></li>
                            <li>|</li>
                            <li><a href=\"";
        // line 83
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("cotacoes")), "html", null, true);
        echo "\">Cotações</a></li>
                            <li>|</li>
                            <li><a href=\"";
        // line 85
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array("perguntas-frequentes")), "html", null, true);
        echo "\">Perguntas frequentes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

";
        // line 94
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('seo_footer')->getCallable(), array()), "html", null, true);
        echo "

<script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js\"></script>
<script type=\"text/javascript\" src=\"node_modules/bootstrap/dist/js/bootstrap.min.js\"></script>

<script type=\"text/javascript\" src=\"node_modules/owl.carousel2/dist/owl.carousel.js\"></script>

<script type=\"text/javascript\" src=\"node_modules/sweetalert/dist/sweetalert.min.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/clipboard.min.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/jquery.form.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/jquery.serializeObject.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/modernizr.min.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/jquery.mask.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/mask.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/fastclick.js\"></script>
<script type=\"text/javascript\" src=\"cdn/js/admin.js?v=1.0.0\"></script>
<script type=\"text/javascript\" src=\"cdn/js/string.js\"></script>
<script type=\"text/javascript\" src=\"js/site.js?v=1.0.0\"></script>

";
        // line 113
        $this->loadTemplate("website/modals/login.twig", "website/layout.twig", 113)->display($context);
        // line 114
        echo "
";
        // line 115
        $this->displayBlock('script', $context, $blocks);
        // line 116
        echo "
</body>
</html>";
    }

    // line 64
    public function block_main($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($context["endblock"] ?? null), "html", null, true);
    }

    // line 115
    public function block_script($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "website/layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 115,  224 => 64,  218 => 116,  216 => 115,  213 => 114,  211 => 113,  189 => 94,  177 => 85,  172 => 83,  167 => 81,  162 => 79,  158 => 77,  152 => 73,  150 => 72,  145 => 70,  140 => 68,  135 => 65,  133 => 64,  128 => 61,  121 => 57,  117 => 56,  114 => 55,  112 => 54,  108 => 52,  100 => 47,  92 => 42,  89 => 41,  87 => 40,  80 => 36,  72 => 31,  66 => 28,  59 => 23,  57 => 22,  47 => 15,  34 => 5,  28 => 2,  25 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/layout.twig", "/home2/bets01/public_html/app/views/website/layout.twig");
    }
}
