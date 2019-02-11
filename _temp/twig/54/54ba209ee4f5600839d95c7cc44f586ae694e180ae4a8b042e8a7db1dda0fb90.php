<?php

/* admin/helpers/pagina.twig */
class __TwigTemplate_0fba3d7879130597b9ba0d46c2f945d420d5db1969f32e22ba090d09515078ab extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/helpers/pagina.twig", 1);
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
    <form class=\"admpage-form panel panel-default\">
        <div class=\"panel-body p-b-10\">
            <div class=\"row\">

                ";
        // line 9
        if ((($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["vars"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["_titulo"] ?? null) : null)) {
            // line 10
            echo "                    <div class=\"form-group col-xs-12\">
                        <label>Título</label>
                        <input type=\"text\" name=\"title\" class=\"form-control\" required=\"\"/>
                    </div>
                ";
        }
        // line 15
        echo "
                ";
        // line 16
        if ((($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a = ($context["vars"] ?? null)) && is_array($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a) || $__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a instanceof ArrayAccess ? ($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a["_metatags"] ?? null) : null)) {
            // line 17
            echo "                    <div class=\"form-group col-xs-6\">
                        <label>Descrição</label>
                        <input type=\"text\" name=\"descricao\" class=\"form-control\" required=\"\"/>
                    </div>
                    <div class=\"form-group col-xs-6\">
                        <label>Keywords</label>
                        <input type=\"text\" name=\"keywords\" class=\"form-control\"/>
                    </div>
                ";
        }
        // line 26
        echo "
                ";
        // line 27
        if ((($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 = ($context["vars"] ?? null)) && is_array($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57) || $__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 instanceof ArrayAccess ? ($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57["_texto"] ?? null) : null)) {
            // line 28
            echo "                    <div class=\"form-group col-xs-12\">
                        <label>Texto</label>
                        <textarea name=\"texto\" class=\"form-control\" data-ckeditor></textarea>
                    </div>
                ";
        }
        // line 33
        echo "
            </div>
        </div>
        <div class=\"panel-footer text-right\">

            <div class=\"pull-left\">
                ";
        // line 39
        if ((($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 = ($context["vars"] ?? null)) && is_array($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9) || $__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 instanceof ArrayAccess ? ($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9["_galeria"] ?? null) : null)) {
            // line 40
            echo "                    <button type=\"button\" class=\"btn btn-success\"
                            onclick=\"galeria('";
            // line 41
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "getTable", array(), "method"), "html", null, true);
            echo "', ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "getId", array(), "method"), "html", null, true);
            echo ", 'Galeria de Imagens');\">
                        <i class=\"fa fa-image\"></i> Imagens
                    </button>
                ";
        }
        // line 45
        echo "            </div>

            <button type=\"submit\" class=\"btn btn-info\">
                <i class=\"fa fa-save\"></i> Salvar
            </button>

        </div>
    </form>

";
    }

    // line 56
    public function block_script($context, array $blocks = array())
    {
        // line 57
        echo "
    <script>

        \$('.admpage-form').adminPage({
            autoSearch: false,
            autoReset: false,
            alertSuccess: true,
            saveValues: {id: '";
        // line 64
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "getId", array(), "method"), "html", null, true);
        echo "', token: '";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["v"] ?? null), "getToken", array(), "method"), "html", null, true);
        echo "'}
        });

        \$(window)
            .load(function () {
                \$('.admpage-form')
                    .setValues(";
        // line 70
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["v"] ?? null))), "html", null, true);
        echo ");
            })

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/helpers/pagina.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 70,  127 => 64,  118 => 57,  115 => 56,  102 => 45,  93 => 41,  90 => 40,  88 => 39,  80 => 33,  73 => 28,  71 => 27,  68 => 26,  57 => 17,  55 => 16,  52 => 15,  45 => 10,  43 => 9,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/pagina.twig", "/home2/bets01/public_html/app/views/admin/helpers/pagina.twig");
    }
}
