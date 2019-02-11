<?php

/* admin/configuracoes/smtp.twig */
class __TwigTemplate_41e0dccfe3dc7ff0d3d98dd00ea8bf02f5136d9333d76d8fcc954c7cc1ada7ce extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/configuracoes/smtp.twig", 1);
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
<form class=\"admpage-form panel\" enctype=\"multipart/form-data\" onsubmit=\"javascript:return false;\">
    <input type=\"hidden\" name=\"id\"/>
    <div class=\"panel panel-default\">
        <div class=\"panel-body p-b-10\">
            <div>
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label>Nome</label>
                            <input name=\"nome\" type=\"text\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div class=\"col-md-8\">
                        <div class=\"form-group\">
                            <label>E-mail</label>
                            <input name=\"email\" type=\"email\" class=\"form-control\"/>
                        </div>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"col-md-10\">
                        <div class=\"form-group\">
                            <label>Host</label>
                            <input name=\"host\" type=\"text\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div class=\"col-md-2\">
                        <div class=\"form-group\">
                            <label>Porta</label>
                            <input name=\"porta\" type=\"text\" class=\"form-control\"/>
                        </div>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label>Username</label>
                            <input name=\"login\" type=\"text\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label>Password</label>
                            <input name=\"senha\" type=\"text\" placeholder=\"Mater senha atual\" class=\"form-control\"/>
                        </div>
                    </div>
                    <div class=\"col-md-2\">
                        <div class=\"form-group\">
                            <label>Autenticar</label>
                            <select name=\"autenticar\" class=\"form-control\">
                                <option value=\"1\">Sim</option>
                                <option value=\"0\">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-2\">
                        <div class=\"form-group\">
                            <label>Protocolo</label>
                            <select name=\"protocolo\" class=\"form-control\">
                                <option value=\"\">Nenhum</option>
                                <option value=\"ssl\">SSL</option>
                                <option value=\"tls\">TLS</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"panel-footer\">
            <div>
                <div class=\"row\">
                    <div class=\"col-md-12 text-right\">
                        <div class=\"btn-group\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"\" value=\"\">
                                <i class=\"fa fa-save\"></i> Salvar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

";
    }

    // line 91
    public function block_script($context, array $blocks = array())
    {
        // line 92
        echo "
<script>

    \$('.admpage-form')
        .setValues(";
        // line 96
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["smtp"] ?? null))), "html", null, true);
        echo ")
        .adminPage({
            autoSearch: false,
            autoReset: false,
            alertSuccess: true,
        })
        .on(\"success\", function (event, e) {
            if (e.result) {
                \$(this).find(\"[name=senha]\").val(\"\");
            }
        });

</script>

";
    }

    public function getTemplateName()
    {
        return "admin/configuracoes/smtp.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 96,  128 => 92,  125 => 91,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/configuracoes/smtp.twig", "/home2/bets01/public_html/app/views/admin/configuracoes/smtp.twig");
    }
}
