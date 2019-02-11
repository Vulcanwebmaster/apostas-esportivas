<?php

/* admin/usuarios/lista.twig */
class __TwigTemplate_366fe0c882a96b6cb69fe1c4b404f8dbba2e3a421caf62447886f3c1f0f404a7 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/usuarios/lista.twig", 1);
        $this->blocks = array(
            'links' => array($this, 'block_links'),
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
    public function block_links($context, array $blocks = array())
    {
        // line 4
        echo "

    ";
        // line 6
        if (twig_test_empty((($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["vars"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["type"] ?? null) : null))) {
            // line 7
            echo "        <button type=\"button\" class=\"btn-csv btn btn-primary\">
            <i class=\"fa fa-\"></i> Baixar CSV
        </button>
    ";
        }
        // line 11
        echo "
    <button type=\"button\" onclick=\"\$('.admpage-form').setValues({});\" class=\"btn btn-success\">
        <i class=\"fa fa-plus\"></i> Novo
    </button>

";
    }

    // line 18
    public function block_main($context, array $blocks = array())
    {
        // line 19
        echo "
    ";
        // line 20
        $this->loadTemplate("admin/usuarios/form.twig", "admin/usuarios/lista.twig", 20)->display($context);
        // line 21
        echo "
    <div class=\"modal fade modal-credito\" onsubmit=\"return false;\">
        <input type=\"hidden\" name=\"user\" required/>
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                    <h3 class=\"modal-title\">Crédito</h3>
                </div>
                <div class=\"modal-body\">
                    <div class=\"form-group\">
                        <label>Créditos</label>
                        <input type=\"text\" name=\"credito\" class=\"form-control input-lg mask-valor\"/>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <div class=\"pull-left\">
                        <button class=\"btn btn-danger btn-remover\">
                            Remover
                        </button>
                    </div>
                    <button class=\"btn btn-primary btn-adicionar\">
                        Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>

    ";
        // line 50
        if (twig_test_empty((($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a = ($context["vars"] ?? null)) && is_array($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a) || $__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a instanceof ArrayAccess ? ($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a["type"] ?? null) : null))) {
            // line 51
            echo "        <form class=\"admpage-form-search panel panel-default\">
            <div class=\"panel-body\">
                <div class=\"row\">
                    <div class=\"form-group col-md-9 col-sm-12 col-xs-12\">
                        <label>Nome, login, cpf, cidade ou e-mail</label><span class=\"pointer\" data-toggle=\"popover\"
                                                                               data-trigger=\"hover\"
                                                                               data-content=\"Digite o nome, cidade, cpf, login ou e-mail\"
                                                                               data-original-title=\"\"
                                                                               title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <input type=\"text\" name=\"search\" class=\"form-control\"/>
                    </div>
                    <div class=\"form-group col-md-3 col-sm-6 col-xs-6\">
                        <label>Telefone</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                     data-content=\"Digite o telefone Ex.: (87) 99999-9999\"
                                                     data-original-title=\"\"
                                                     title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <input type=\"text\" name=\"telefone\" class=\"form-control mask-telefone\"/>
                    </div>
                    <div class=\"form-group col-md-3 col-sm-6 col-xs-6\">
                        <label>Licença</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                    data-content=\"Selecione se o usuário pagou o plano ou não o plano\"
                                                    data-original-title=\"\"
                                                    title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <select type=\"text\" name=\"pagouplano\" class=\"form-control\">
                            <option value>-- Ambos --</option>
                            <option value=\"1\">Ativa</option>
                            <option value=\"0\">Inativa</option>
                        </select>
                    </div>
                    <div class=\"form-group col-md-3 col-sm-6 col-xs-12\">
                        <label>Recarga mínima</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                           data-content=\"Selecione se está em dia com a recarga mensal\"
                                                           data-original-title=\"\"
                                                           title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <select name=\"emdia\" class=\"form-control\">
                            <option value>-- Ambos --</option>
                            <option value=\"1\">Pago</option>
                            <option value=\"0\">Pendente</option>
                        </select>
                    </div>
                    <div class=\"form-group col-md-3 col-sm-6 col-xs-12\">
                        <label>Licença</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                    data-content=\"Selecione o tipo de licença\"
                                                    data-original-title=\"\"
                                                    title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <select name=\"type\" class=\"form-control\">
                            <option value>-- Ambos --</option>
                            <option value=\"8\">Jogador</option>
                            <option value=\"9\">Consultor</option>
                            <option value=\"4\">Franqueado</option>
                        </select>
                    </div>
                    <div class=\"form-group col-md-3 col-sm-6 col-xs-12\">
                        <label>Data de cadastro</label><span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                             data-content=\"Selecione ou digite a data\"
                                                             data-original-title=\"\"
                                                             title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                        <input type=\"date\" name=\"datacadastro\" class=\"form-control\"/>
                    </div>
                </div>
            </div>
            <div class=\"panel-footer text-right\">
                <button class=\"btn btn-primary\">
                    <i class=\"fa fa-filter\"></i> Filtrar
                </button>
            </div>
        </form>
    ";
        }
        // line 119
        echo "
    <div class=\"page-container\"></div>


";
    }

    // line 125
    public function block_script($context, array $blocks = array())
    {
        // line 126
        echo "
    <script>

        var container = \$('.page-container');
        var modalCredito = \$('.modal-credito');

        var formSearch = \$('.admpage-form-search');
        var page = \$('<div />')
            .adminPage({
                form: '.admpage-form',
                searchValues: ";
        // line 136
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
                saveValues: ";
        // line 137
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["vars"] ?? null))), "html", null, true);
        echo ",
                container: container,
                formSearch: formSearch,
            });

        modalCredito
            .on(\"click\", '.btn-remover, .btn-adicionar', function () {
                if (!\$(\"html\").hasClass('page-loading')) {

                    var values = {};

                    values.user = modalCredito.attr('data-user');
                    values.credito = modalCredito.find('[name=credito]').val();
                    values.pontos = modalCredito.find('[name=pontos]').val();
                    values.acao = \$(this).hasClass('btn-remover') ? 'remover' : 'adicionar';

                    \$('html').addClass('page-loading');

                    \$.post(url('users/users/credito'), values, function (e) {

                        swal(
                            'Aviso',
                            e.message,
                            'success'
                        );

                        if (e.result == 1) {
                            modalCredito.modal(\"hide\").find(\"input\").val('');
                            page.reloadSearch();
                        }
                    }, 'json')
                        .always(function () {
                            \$('html').removeClass('page-loading');
                        });

                }
            });

        container
            .on('click', '[data-credito]', function () {
                modalCredito.attr(\"data-user\", \$(this).attr('data-credito'));
                modalCredito.modal('show');
            });

        \$('.btn-csv')
            .click(function () {
                window.location.href = url('users/users/csv') + '?' + \$.param(formSearch.getValues());
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/usuarios/lista.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  196 => 137,  192 => 136,  180 => 126,  177 => 125,  169 => 119,  99 => 51,  97 => 50,  66 => 21,  64 => 20,  61 => 19,  58 => 18,  49 => 11,  43 => 7,  41 => 6,  37 => 4,  34 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/usuarios/lista.twig", "/home2/bets01/public_html/app/views/admin/usuarios/lista.twig");
    }
}
