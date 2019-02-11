<?php

/* website/modals/login.twig */
class __TwigTemplate_5d2ab62da25b0a72e776677aadeb3f6fd25e8f833b4a98a022f403dc9ea8a2c2 extends Twig_Template
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
        echo "<form id=\"modal-login\" class=\"modal fade\">
    <div class=\"modal-dialog modal-sm\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h3 class=\"modal-title\">
                    Entrar
                </h3>
                <div class=\"close\" data-dismiss=\"modal\">&times;</div>
            </div>
            <div class=\"modal-body\">
                <div class=\"form-group\">
                    <label>Login/E-mail</label>
                    <input type=\"text\" class=\"form-control\" name=\"username\" required/>
                </div>
                <div class=\"form-group\">
                    <label>Senha</label>
                    <input type=\"password\" class=\"form-control\" name=\"password\" required/>
                </div>
                <button type=\"submit\" class=\"btn btn-danger btn-block\">
                    <i class=\"fa fa-check\"></i> Entrar
                </button>
            </div>
        </div>
    </div>
</form>

<script>

    \$('#modal-login')
        .adminPage({
            autoSearch: false,
            controller: 'login',
            module: 'entrar',
            alertSuccess: true,
        })
        .on(\"success\", function (event, e) {
            if (e.result == 1) {
                window.location.href = e.url;
            }
        });

</script>";
    }

    public function getTemplateName()
    {
        return "website/modals/login.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/modals/login.twig", "/home2/bets01/public_html/app/views/website/modals/login.twig");
    }
}
