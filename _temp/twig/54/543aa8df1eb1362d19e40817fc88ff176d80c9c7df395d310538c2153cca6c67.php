<?php

/* admin/jogos/adicionar.twig */
class __TwigTemplate_2e63c4f81dcb5e34b88bbf38449a6fc6e1b4c3d42a4273a9dd0f5d51a9d475f7 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/jogos/adicionar.twig", 1);
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
<div class=\"text-right m-b-lg\">
    <a href=\"admin/jogos/adicionar/novo\" class=\"btn btn-success\">
        <i class=\"fa fa-plus\"></i> Novo
    </a>
</div>

<form class=\"admpage-form-search panel panel-default\">
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"col-md-3 col-sm-12 col-xs-12\">
                <label><b>Data de Cadastro</b></label>
                <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                      data-content=\"Digite ou selecione a data de cadastro.\"
                      data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                <input type=\"date\" name=\"datacadastro\" class=\"form-control\">
            </div>
            <div class=\"col-md-3 col-sm-12 col-xs-12\">
                <label><b>Data do Jogo</b></label>
                <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                      data-content=\"Digite ou selecione a data do jogo.\"
                      data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                <input type=\"date\" name=\"data\" class=\"form-control\">
            </div>
            <div class=\"col-md-3 col-sm-12 col-xs-12\">
                <label><b>Nome da Equipe</b></label>
                <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                      data-content=\"Digite o nome da equipe\"
                      data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                <input type=\"text\" name=\"search\" class=\"form-control\">
            </div>
            <div class=\"col-md-3 col-sm-12 col-xs-12\">
                <label><b>Campeonato</b></label>
                <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                      data-content=\"Selecione um campeonato\"
                      data-original-title=\"\" title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                <select name=\"campeonato\" class=\"form-control\" data-options=\"admin/cadastros/campeonatos/options\">
                    <option value> -- Selecione --</option>
                </select>
            </div>
        </div>
    </div>
    <div class=\"panel-footer text-right\">
        <button type=\"submit\" class=\"btn btn-primary\">
            <i class=\"fa fa-search\"></i> Buscar
        </button>
    </div>
</form>

";
        // line 53
        $this->loadTemplate("admin/helpers/info-jogos.twig", "admin/jogos/adicionar.twig", 53)->display($context);
        // line 54
        echo "
<div class=\"admpage-container\"></div>

";
    }

    // line 59
    public function block_script($context, array $blocks = array())
    {
        // line 60
        echo "
<script>

    \$
        .adminPage({
            formSearch: '.admpage-form-search',
            container: '.admpage-container',
            deleteAction: url('jogos/jogo/excluir'),
        });

</script>

";
    }

    public function getTemplateName()
    {
        return "admin/jogos/adicionar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 60,  96 => 59,  89 => 54,  87 => 53,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/jogos/adicionar.twig", "/home2/bets01/public_html/app/views/admin/jogos/adicionar.twig");
    }
}
