<?php

/* admin/helpers/banners.twig */
class __TwigTemplate_4209780e8fd5d0ee7861f209b16908b424da626f202100c20fd735803294f035 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/helpers/banners.twig", 1);
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
        echo "<form class='admpage-form panel panel-default' enctype=\"multipart/form-data\" onsubmit=\"return false\">

    <input type=\"hidden\" name=\"id\" />

    <div class='panel-body p-b-10'>

        <div class='row'>

            <div class=\"form-group col-md-3 col-xs-12\">
                <label>Ordem</label>
                <input type=\"number\" min=\"0\" max=\"100\" name=\"ordem\" class=\"form-control\" />
            </div>

        </div>

        <div class=\"row\">

            ";
        // line 21
        if ((($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["vars"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["_periodo"] ?? null) : null)) {
            // line 22
            echo "                <div class=\"form-group col-md-3 col-xs-6\">
                    <label>Data inícial</label>
                    <input type=\"date\" name=\"inicio\" class=\"form-control\" />
                </div>
                <div class=\"form-group col-md-3 col-xs-6\">
                    <label>Data final</label>
                    <input type=\"date\" name=\"fim\" class=\"form-control\" />
                </div>
            ";
        }
        // line 31
        echo "
            ";
        // line 32
        if ((($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a = ($context["vars"] ?? null)) && is_array($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a) || $__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a instanceof ArrayAccess ? ($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a["_title"] ?? null) : null)) {
            // line 33
            echo "            <div class=\"form-group col-md-";
            echo (((($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 = ($context["vars"] ?? null)) && is_array($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57) || $__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 instanceof ArrayAccess ? ($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57["_periodo"] ?? null) : null)) ? (6) : (12));
            echo " col-xs-12\">
                <label>Título</label>
                <input type=\"text\" name=\"title\" class=\"form-control\" required/>
            </div>
            ";
        }
        // line 38
        echo "
            ";
        // line 39
        if ((($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 = ($context["vars"] ?? null)) && is_array($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9) || $__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 instanceof ArrayAccess ? ($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9["_descricao"] ?? null) : null)) {
            // line 40
            echo "            <div class=\"form-group col-xs-12\">
                <label>Descrição</label>
                <input type=\"text\" name=\"descricao\" class=\"form-control\" />
            </div>
            ";
        }
        // line 45
        echo "
            ";
        // line 46
        if ((($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217 = ($context["vars"] ?? null)) && is_array($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217) || $__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217 instanceof ArrayAccess ? ($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217["_link"] ?? null) : null)) {
            // line 47
            echo "            <div class=\"form-group col-md-9 col-xs-12\">
                <label>Link</label>
                <input type=\"text\" name=\"link\" class=\"form-control\" />
            </div>
            <div class=\"form-group col-md-3 col-xs-12\">
                <label>Link (target)</label>
                <select class=\"form-control\" name=\"linktarget\">
                    <option value=\"_self\">Mesma página</option>
                    <option value=\"_blank\">Nova página</option>
                </select>
            </div>
            ";
        }
        // line 59
        echo "
            ";
        // line 60
        if ((($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105 = ($context["vars"] ?? null)) && is_array($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105) || $__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105 instanceof ArrayAccess ? ($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105["_dias"] ?? null) : null)) {
            // line 61
            echo "            <div class=\"form-group col-xs-12\">
                <label>Dias de exibição</label>
                <select name=\"dias\" class=\"form-control chosen\" multiple>
                    <option value=\"0\">Domingo</option>
                    <option value=\"1\">Segunda</option>
                    <option value=\"2\">Terça</option>
                    <option value=\"3\">Quarta</option>
                    <option value=\"4\">Quinta</option>
                    <option value=\"5\">Sexta</option>
                    <option value=\"6\">Sábado</option>
                </select>
            </div>
            ";
        }
        // line 74
        echo "
            ";
        // line 75
        if ((($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779 = ($context["vars"] ?? null)) && is_array($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779) || $__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779 instanceof ArrayAccess ? ($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779["_texto"] ?? null) : null)) {
            // line 76
            echo "            <div class='form-group col-xs-12'>
                <label>Texto</label>
                <textarea name=\"texto\" class=\"form-control\" data-ckeditor></textarea>
            </div>
            ";
        }
        // line 81
        echo "
        </div>
    </div>
    <div class='panel-footer text-right'>
        <div class='pull-left'>
            ";
        // line 86
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array("<i class=\"fa fa-image\"></i> Desktop", "updesktop", "image/*")), "html", null, true);
        echo "
            ";
        // line 87
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('inputFile')->getCallable(), array("<i class=\"fa fa-image\"></i> Mobile", "upmobile", "image/*")), "html", null, true);
        echo "
        </div>
        <button type=\"submit\" class=\"btn btn-info\">
            <i class='fa fa-save'></i> Salvar
        </button>
    </div>
</form>
";
    }

    // line 96
    public function block_script($context, array $blocks = array())
    {
        // line 97
        echo "<script>

    \$('.admpage-form').adminPage({
        saveValues: ";
        // line 100
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
        searchValues: ";
        // line 101
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
    });

</script>
";
    }

    public function getTemplateName()
    {
        return "admin/helpers/banners.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  180 => 101,  176 => 100,  171 => 97,  168 => 96,  156 => 87,  152 => 86,  145 => 81,  138 => 76,  136 => 75,  133 => 74,  118 => 61,  116 => 60,  113 => 59,  99 => 47,  97 => 46,  94 => 45,  87 => 40,  85 => 39,  82 => 38,  73 => 33,  71 => 32,  68 => 31,  57 => 22,  55 => 21,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/helpers/banners.twig", "/home2/bets01/public_html/app/views/admin/helpers/banners.twig");
    }
}
