<?php

/* admin/layout.twig */
class __TwigTemplate_9bd1d7cd64682e8a1cfc43ac2f80342e35997230a67def911e9fcbc1b4fd2926 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'style' => array($this, 'block_style'),
            'links' => array($this, 'block_links'),
            'main' => array($this, 'block_main'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>

    ";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('seo_header')->getCallable(), array()), "html", null, true);
        echo "

    <link rel=\"stylesheet\" href=\"admfiles/plugins/pace-master/themes/blue/pace-theme-flash.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/uniform/css/uniform.default.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/bootstrap/css/bootstrap.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/line-icons/simple-line-icons.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/offcanvasmenueffects/css/menu_cornerbox.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/waves/waves.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/switchery/switchery.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/3d-bold-navigation/css/style.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/slidepushmenus/css/component.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/bootstrap-datepicker/css/datepicker3.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/select2/css/select2.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/bootstrap-vertical-tabs-master/bootstrap.vertical-tabs.min.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/bootstrap-colorpicker/css/colorpicker.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/plugins/summernote-master/summernote.css\"/>
    <link rel=\"stylesheet\" href=\"cdn/css/chosen.css\"/>

    <link rel=\"stylesheet\" href=\"admfiles/css/modern.min.css\"/>
    <link rel=\"stylesheet\" href=\"fixedheader/css/defaultTheme.css\"/>
    <link rel=\"stylesheet\" href=\"admfiles/css/custom.css?v=1.0.0\"/>
    <link rel=\"stylesheet\" href=\"css/bootstrap-multiselect.css\"/>
    <link rel=\"stylesheet\" href=\"css/admin.css?v=2.0.2\"/>
    <link rel=\"stylesheet\" href=\"css/sweetalert2.min.css\"/>

    <link rel=\"stylesheet\" href=\"css/loading.css?v=1.0.0\"/>

    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,300,600\"/>
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\"/>

    ";
        // line 37
        $this->displayBlock('style', $context, $blocks);
        // line 38
        echo "
</head>
<body class=\"compact-menu\">

<div class=\"overlay\"></div>

";
        // line 44
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "getManual", array(), "method")) {
            // line 45
            echo "    <div class=\"modal fade modal-manual\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Dicas de Uso</h3>
                </div>
                <div class=\"modal-body\">";
            // line 52
            echo twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "getManual", array(), "method");
            echo "</div>
            </div>
        </div>
    </div>
";
        }
        // line 57
        echo "
<main class=\"page-content content-wrap\">
    <div class=\"navbar\">
        <div class=\"navbar-inner\">
            <div class=\"sidebar-pusher\">
                <a href=\"javascript:void(0);\" class=\"waves-effect waves-button waves-classic push-sidebar\">
                    <i class=\"fa fa-bars\"></i>
                </a>
            </div>
            <div class=\"logo-box\">
                <a href=\"admin\">
                    <img src=\"";
        // line 68
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, call_user_func_array($this->env->getFunction('dados')->getCallable(), array()), "imgCapa", array(0 => true, 1 => "logo"), "method"), "getSource", array(0 => true), "method"), "html", null, true);
        echo "\" class=\"brand\"/>
                </a>
            </div><!-- Logo Box -->
            <div class=\"search-button\">
                <a href=\"entrar/logout\" class=\"waves-effect waves-button waves-classic show-search\"><i
                            class=\"fa fa-sign-out\"></i></a>
            </div>
            <div class=\"topmenu-outer\">
                <div class=\"top-menu\">
                    <ul class=\"nav navbar-nav navbar-left\">
                        ";
        // line 78
        if (($context["isMaster"] ?? null)) {
            // line 79
            echo "                            <li>
                                <a href=\"admin/configuracoes/bloqueio\" class=\"waves-effect waves-button waves-classic\"
                                   data-toggle=\"tooltip\" title=\"";
            // line 81
            echo ((($context["bloqueado"] ?? null)) ? ("Liberado") : ("Bloqueado"));
            echo "\"
                                   data-placement=\"bottom\">
                                    <i class=\"fa ";
            // line 83
            echo ((($context["bloqueado"] ?? null)) ? ("fa-lock") : ("fa-unlock"));
            echo "\"></i>
                                </a>
                            </li>
                        ";
        }
        // line 87
        echo "                        ";
        if (($context["isDev"] ?? null)) {
            // line 88
            echo "                            <li>
                                <a href=\"";
            // line 89
            echo twig_escape_filter($this->env, ($context["module"] ?? null), "html", null, true);
            echo "/twig\" class=\"waves-effect waves-button waves-classic\"
                                   data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Limpar cache twig\">
                                    <i class=\"fa fa-refresh\"></i> Twig
                                </a>
                            </li>
                        ";
        }
        // line 95
        echo "                        ";
        if (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("app"))) {
            // line 96
            echo "                            <li>
                                <a href=\"";
            // line 97
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("app")), "html", null, true);
            echo "\" target=\"_blank\"
                                   class=\"waves-effect waves-button waves-classic\">
                                    <i class=\"fa fa-android\"></i>
                                </a>
                            </li>
                        ";
        }
        // line 103
        echo "                        ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "getManual", array(), "method")) {
            // line 104
            echo "                            <li>
                                <a href=\"#\" data-toggle=\"modal\" data-target=\".modal-manual\"
                                   class=\"waves-effect waves-button waves-classic\">
                                    <i class=\"fa fa-info\"></i> Dicas
                                </a>
                            </li>
                        ";
        }
        // line 111
        echo "                    </ul>
                    <ul class=\"nav navbar-nav navbar-right\">
                        <li class=\"dropdown hide\">
                            <a href=\"#\" class=\"dropdown-toggle waves-effect waves-button waves-classic\"
                               data-toggle=\"dropdown\"><i class=\"fa fa-envelope\"></i><span
                                        class=\"badge badge-success pull-right\">4</span></a>
                            <ul class=\"dropdown-menu title-caret dropdown-lg\" role=\"menu\">
                                <li><p class=\"drop-title\">You have 4 new messages !</p></li>
                                <li class=\"dropdown-menu-list slimscroll messages\">
                                    <ul class=\"list-unstyled\">
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online on\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar2.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Sandra Smith</p>
                                                <p class=\"msg-text\">Hey ! I'm working on your project</p>
                                                <p class=\"msg-time\">3 minutes ago</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online off\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar4.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Amily Lee</p>
                                                <p class=\"msg-text\">Hi David !</p>
                                                <p class=\"msg-time\">8 minutes ago</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online off\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar3.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Christopher Palmer</p>
                                                <p class=\"msg-text\">See you soon !</p>
                                                <p class=\"msg-time\">56 minutes ago</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online on\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar5.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Nick Doe</p>
                                                <p class=\"msg-text\">Nice to meet you</p>
                                                <p class=\"msg-time\">2 hours ago</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online on\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar2.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Sandra Smith</p>
                                                <p class=\"msg-text\">Hey ! I'm working on your project</p>
                                                <p class=\"msg-time\">5 hours ago</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"msg-img\">
                                                    <div class=\"online off\"></div>
                                                    <img class=\"img-circle\"
                                                         src=\"admfiles/images/avatar4.png\"
                                                         alt=\"\"></div>
                                                <p class=\"msg-name\">Amily Lee</p>
                                                <p class=\"msg-text\">Hi David !</p>
                                                <p class=\"msg-time\">9 hours ago</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=\"drop-all\"><a href=\"#\" class=\"text-center\">All Messages</a></li>
                            </ul>
                        </li>
                        <li class=\"dropdown hide\">
                            <a href=\"#\" class=\"dropdown-toggle waves-effect waves-button waves-classic\"
                               data-toggle=\"dropdown\"><i class=\"fa fa-bell\"></i><span
                                        class=\"badge badge-success pull-right\">3</span></a>
                            <ul class=\"dropdown-menu title-caret dropdown-lg\" role=\"menu\">
                                <li><p class=\"drop-title\">You have 3 pending tasks !</p></li>
                                <li class=\"dropdown-menu-list slimscroll tasks\">
                                    <ul class=\"list-unstyled\">
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"task-icon badge badge-success\"><i class=\"icon-user\"></i>
                                                </div>
                                                <span class=\"badge badge-roundless badge-default pull-right\">1min ago</span>
                                                <p class=\"task-details\">New user registered.</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"task-icon badge badge-danger\"><i class=\"icon-energy\"></i>
                                                </div>
                                                <span class=\"badge badge-roundless badge-default pull-right\">24min ago</span>
                                                <p class=\"task-details\">Database error.</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"task-icon badge badge-info\"><i class=\"icon-heart\"></i></div>
                                                <span class=\"badge badge-roundless badge-default pull-right\">1h ago</span>
                                                <p class=\"task-details\">Reached 24k likes</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=\"drop-all\"><a href=\"#\" class=\"text-center\">All Tasks</a></li>
                            </ul>
                        </li>

                        ";
        // line 235
        if ((($context["isMaster"] ?? null) && (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("limiteusuarios")) > 0))) {
            // line 236
            echo "                            <li>
                                <a href=\"admin/page/43\" class=\"waves-effect waves-button waves-classic show-search\"
                                   data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Limite de Usuários\"><b>
                                        ";
            // line 239
            echo twig_escape_filter($this->env, ((($context["total"] ?? null)) ? (($context["total"] ?? null)) : (0)), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("limiteusuarios")), "html", null, true);
            echo "</b> <i class=\"fa fa-users\"></i>
                                </a>
                            </li>
                        ";
        }
        // line 243
        echo "
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle waves-effect waves-button waves-classic\"
                               data-toggle=\"dropdown\">
                                <span class=\"user-name\">";
        // line 247
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getNome", array(), "method"), "html", null, true);
        echo "<i
                                            class=\"fa fa-angle-down\"></i></span>
                                <img class=\"img-circle avatar\" src=\"";
        // line 249
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "imgCapa", array(), "method"), "redimensiona", array(0 => 40, 1 => 40), "method"), "html", null, true);
        echo "\"
                                     width=\"40\" height=\"40\"/>
                            </a>
                            <ul class=\"dropdown-menu dropdown-list\" role=\"menu\">
                                <li role=\"presentation\">
                                    <a href=\"admin/users/eu\">
                                        <i class=\"fa fa-user\"></i> Meu Perfil
                                    </a>
                                </li>
                                <li role=\"presentation\" class=\"divider\"></li>
                                <li role=\"presentation\">
                                    <a href=\"entrar/logout\">
                                        <i class=\"fa fa-sign-out m-r-xs\"></i> Sair
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=\"entrar/logout\" class=\"log-out waves-effect waves-button waves-classic\">
                                <span><i class=\"fa fa-sign-out m-r-xs\"></i>Sair</span>
                            </a>
                        </li>
                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div><!-- Navbar -->
    <div class=\"page-sidebar sidebar\">
        <div class=\"page-sidebar-inner slimscroll\">
            <div class=\"sidebar-header\">
                <div class=\"sidebar-profile\">
                    <a href=\"admin/users/eu\">
                        <div class=\"sidebar-profile-image\">
                            <img src=\"";
        // line 282
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "imgCapa", array(), "method"), "redimensiona", array(0 => 60, 1 => 60), "method"), "html", null, true);
        echo "\" class=\"img-circle img-responsive\"
                                 alt=\"\"/>
                        </div>
                        <div class=\"sidebar-profile-details\">
                            <span>
                                ";
        // line 287
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getNome", array(), "method"), "html", null, true);
        echo "<br>
                                <small>";
        // line 288
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getTypeTitle", array(), "method"), "html", null, true);
        echo "</small>
                                <br>
                                <small style=\"color : #fff;font-size : 14px\">(";
        // line 290
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getLogin", array(), "method"), "html", null, true);
        echo ")</small>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
            <ul class=\"menu accordion-menu\">
                <li>
                    <a href=\"admin\" class=\"waves-effect waves-button\">
                        <span class=\"menu-icon glyphicon glyphicon-th-large\"></span>
                        <p>Início</p>
                    </a>
                </li>
                ";
        // line 303
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('admMenu')->getCallable(), array(($context["module"] ?? null))), "html", null, true);
        echo "
            </ul>
        </div><!-- Page Sidebar Inner -->
    </div><!-- Page Sidebar -->
    <div class=\"page-inner\">
        <div class=\"page-title\">
            <div class=\"pull-right\">
                <div class=\"btn-group page-links\">
                    ";
        // line 311
        $this->displayBlock('links', $context, $blocks);
        // line 312
        echo "                </div>
            </div>
            ";
        // line 314
        if (($context["title"] ?? null)) {
            // line 315
            echo "                <h3>";
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
            echo "</h3>
            ";
        } elseif (        // line 316
($context["page"] ?? null)) {
            // line 317
            echo "                <h3>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "getIcone", array(), "method"), "html", null, true);
            echo "</h3>
            ";
        } else {
            // line 319
            echo "                <h3>Painel administrativo</h3>
            ";
        }
        // line 321
        echo "            <div class=\"page-breadcrumb\">
                <ol class=\"breadcrumb\">
                    <a href=\"";
        // line 323
        echo twig_escape_filter($this->env, ($context["module"] ?? null), "html", null, true);
        echo "\" title=\"Início\">Início</a>
                </ol>
            </div>
        </div>
        <div id=\"main-wrapper\">

            ";
        // line 329
        $this->displayBlock('main', $context, $blocks);
        // line 330
        echo "
        </div><!-- Main Wrapper -->
        <div class=\"page-footer\">
            <p class=\"no-s\">";
        // line 333
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " &copy; ";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("banca")), "html", null, true);
        echo ".</p>
        </div>
    </div><!-- Page Inner -->
</main><!-- Page Content -->

<div class=\"cd-overlay\"></div>

<!-- Javascripts -->
";
        // line 341
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('seo_footer')->getCallable(), array()), "html", null, true);
        echo "

<script src=\"admfiles/plugins/3d-bold-navigation/js/modernizr.js\"></script>
<script src=\"admfiles/plugins/offcanvasmenueffects/js/snap.svg-min.js\"></script>

<script src=\"admfiles/plugins/jquery/jquery-2.1.4.min.js\"></script>
<script src=\"admfiles/plugins/jquery-ui/jquery-ui.min.js\"></script>
<script src=\"admfiles/plugins/pace-master/pace.min.js\"></script>
<script src=\"admfiles/plugins/jquery-blockui/jquery.blockui.js\"></script>
<script src=\"admfiles/plugins/bootstrap/js/bootstrap.min.js\"></script>
<script src=\"admfiles/plugins/jquery-slimscroll/jquery.slimscroll.min.js\"></script>
<script src=\"admfiles/plugins/switchery/switchery.min.js\"></script>
<script src=\"admfiles/plugins/uniform/jquery.uniform.min.js\"></script>
<script src=\"admfiles/plugins/offcanvasmenueffects/js/classie.js\"></script>
<script src=\"admfiles/plugins/offcanvasmenueffects/js/main.js\"></script>
<script src=\"admfiles/plugins/waves/waves.min.js\"></script>
<script src=\"admfiles/plugins/3d-bold-navigation/js/main.js\"></script>
<script src=\"admfiles/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js\"></script>
<script src=\"admfiles/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js\"></script>
<script src=\"admfiles/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.min.js\"></script>
<script src=\"admfiles/plugins/select2/js/select2.min.js\"></script>
<script src=\"admfiles/plugins/chartsjs/Chart.min.js\"></script>
<script src=\"admfiles/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js\"></script>
<script src=\"admfiles/plugins/summernote-master/summernote.min.js\"></script>
<script src=\"fixedheader/jquery.fixedheadertable.min.js\"></script>
<script src=\"admfiles/js/modern.js\"></script>

<script src=\"cdn/js/jquery.chosen.js\"></script>
<script src=\"cdn/js/jquery.form.js\"></script>
<script src=\"cdn/js/jquery.serializeObject.js\"></script>
<script src=\"cdn/js/mask.js\"></script>
<script src=\"cdn/js/jquery.mask.js\"></script>
<script src=\"cdn/js/modernizr.min.js\"></script>
<script src=\"cdn/js/fastclick.js\"></script>
<script src=\"cdn/js/string.js\"></script>
<script src=\"js/bootstrap-multiselect.js\"></script>
<script src=\"js/main.js\"></script>
<script src=\"cksource/ckeditor4/ckeditor.js\"></script>
<script src=\"js/sweetalert2.min.js\"></script>
<script src=\"cdn/js/clipboard.min.js\"></script>
<script src=\"cdn/js/admin.js?v=1.0.8\"></script>

<script src=\"cdn/js/custom.js\"></script>

";
        // line 385
        $this->displayBlock('script', $context, $blocks);
        // line 386
        echo "
</body>
</html>";
    }

    // line 37
    public function block_style($context, array $blocks = array())
    {
    }

    // line 311
    public function block_links($context, array $blocks = array())
    {
    }

    // line 329
    public function block_main($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($context["endblock"] ?? null), "html", null, true);
    }

    // line 385
    public function block_script($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($context["endblock"] ?? null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "admin/layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  545 => 385,  539 => 329,  534 => 311,  529 => 37,  523 => 386,  521 => 385,  474 => 341,  461 => 333,  456 => 330,  454 => 329,  445 => 323,  441 => 321,  437 => 319,  431 => 317,  429 => 316,  424 => 315,  422 => 314,  418 => 312,  416 => 311,  405 => 303,  389 => 290,  384 => 288,  380 => 287,  372 => 282,  336 => 249,  331 => 247,  325 => 243,  316 => 239,  311 => 236,  309 => 235,  183 => 111,  174 => 104,  171 => 103,  162 => 97,  159 => 96,  156 => 95,  147 => 89,  144 => 88,  141 => 87,  134 => 83,  129 => 81,  125 => 79,  123 => 78,  110 => 68,  97 => 57,  89 => 52,  80 => 45,  78 => 44,  70 => 38,  68 => 37,  33 => 5,  27 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/layout.twig", "/home2/bets01/public_html/app/views/admin/layout.twig");
    }
}
