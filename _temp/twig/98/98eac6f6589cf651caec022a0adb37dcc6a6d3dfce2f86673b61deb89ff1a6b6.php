<?php

/* admin/sys/principal.twig */
class __TwigTemplate_e5cd29863e9dd264b7f7faeab8c42b9b444331778d0015fe4880ea24bcb19840 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/sys/principal.twig", 1);
        $this->blocks = array(
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
    public function block_main($context, array $blocks = array())
    {
        // line 4
        echo "
    <div class=\"row\">
        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-white\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 10
        echo twig_escape_filter($this->env, (((($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 = ($context["apostasInfos"] ?? null)) && is_array($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5) || $__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5 instanceof ArrayAccess ? ($__internal_7cd7461123377b8c9c1b6a01f46c7bbd94bd12e59266005df5e93029ddbc0ec5["totalApostas"] ?? null) : null)) ? ((($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a = ($context["apostasInfos"] ?? null)) && is_array($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a) || $__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a instanceof ArrayAccess ? ($__internal_3e28b7f596c58d7729642bcf2acc6efc894803703bf5fa7e74cd8d2aa1f8c68a["totalApostas"] ?? null) : null)) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\">Total de apostas hoje</span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-line-chart\"></i>
                    </div>
                    <div class=\"info-box-progress\">
                        <div class=\"progress progress-xs progress-squared bs-n\">
                            <div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"40\"
                                 aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-white\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p>R\$
                            <span class=\"counter\">";
        // line 31
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["apostasInfos"] ?? null), "valorApostas", array()), 2, ",", "."), "html", null, true);
        echo "</span>
                        </p>
                        <span class=\"info-box-title\">Total apostado hoje</span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-money\"></i>
                    </div>
                    <div class=\"info-box-progress\">
                        <div class=\"progress progress-xs progress-squared bs-n\">
                            <div class=\"progress-bar progress-bar-info\" role=\"progressbar\" aria-valuenow=\"80\"
                                 aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-white\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p>R\$
                            <span class=\"counter\">";
        // line 53
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["apostasInfos"] ?? null), "retorno", array()), 2, ",", "."), "html", null, true);
        echo "</span>
                        </p>
                        <span class=\"info-box-title\">Possível retorno de hoje</span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-money\"></i>
                    </div>
                    <div class=\"info-box-progress\">
                        <div class=\"progress progress-xs progress-squared bs-n\">
                            <div class=\"progress-bar progress-bar-warning\" role=\"progressbar\" aria-valuenow=\"60\"
                                 aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row linha-cadastros\">

        <div class=\"col-md-15 col-sm-12 col-xs-12 width-ipad-pro width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 78
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "noDia", array(), "any", true, true) &&  !(null === twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "noDia", array())))) ? (twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "noDia", array())) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"
                              style=\"font-size : 13px !important\"> Total de cadastros do dia </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-15 col-sm-12 col-xs-12 width-ipad-pro width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 93
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "ontem", array(), "any", true, true) &&  !(null === twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "ontem", array())))) ? (twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "ontem", array())) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"
                              style=\"font-size : 13px !important\"> Total de cadastros de ontem </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-15 col-sm-12 col-xs-12 width-ipad-pro width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 108
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "7dias", array(), "array", true, true) &&  !(null === (($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57) || $__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57 instanceof ArrayAccess ? ($__internal_b0b3d6199cdf4d15a08b3fb98fe017ecb01164300193d18d78027218d843fc57["7dias"] ?? null) : null)))) ? ((($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9) || $__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9 instanceof ArrayAccess ? ($__internal_81ccf322d0988ca0aa9ae9943d772c435c5ff01fb50b956278e245e40ae66ab9["7dias"] ?? null) : null)) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\" style=\"font-size : 13px !important\"> Total de cadastros dos últimos 7 dias </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-15 col-sm-12 col-xs-12 width-ipad-pro width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 122
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "noMes", array(), "array", true, true) &&  !(null === (($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217) || $__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217 instanceof ArrayAccess ? ($__internal_add9db1f328aaed12ef1a33890510da978cc9cf3e50f6769d368473a9c90c217["noMes"] ?? null) : null)))) ? ((($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105) || $__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105 instanceof ArrayAccess ? ($__internal_128c19eb75d89ae9acc1294da2e091b433005202cb9b9351ea0c5dd5f69ee105["noMes"] ?? null) : null)) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"
                              style=\"font-size : 13px !important\"> Total de cadastros do mês </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-15 col-sm-12 col-xs-12 width-ipad-pro width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">";
        // line 137
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, ($context["resumoCadastros"] ?? null), "total", array(), "array", true, true) &&  !(null === (($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779) || $__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779 instanceof ArrayAccess ? ($__internal_921de08f973aabd87ecb31654784e2efda7404f12bd27e8e56991608c76e7779["total"] ?? null) : null)))) ? ((($__internal_3e040fa9f9bcf48a8b054d0953f4fffdaf331dc44bc1d96f1bb45abb085e61d1 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_3e040fa9f9bcf48a8b054d0953f4fffdaf331dc44bc1d96f1bb45abb085e61d1) || $__internal_3e040fa9f9bcf48a8b054d0953f4fffdaf331dc44bc1d96f1bb45abb085e61d1 instanceof ArrayAccess ? ($__internal_3e040fa9f9bcf48a8b054d0953f4fffdaf331dc44bc1d96f1bb45abb085e61d1["total"] ?? null) : null)) : (0)), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"
                              style=\"font-size : 13px !important\"> Total de cadastros geral </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-users\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-12 col-sm-12 col-xs-12 width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">R\$ ";
        // line 152
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (($__internal_bd1cf16c37e30917ff4f54b7320429bcc2bb63615cd8a735bfe06a3f1b5c82a0 = ($context["resumoCadastros"] ?? null)) && is_array($__internal_bd1cf16c37e30917ff4f54b7320429bcc2bb63615cd8a735bfe06a3f1b5c82a0) || $__internal_bd1cf16c37e30917ff4f54b7320429bcc2bb63615cd8a735bfe06a3f1b5c82a0 instanceof ArrayAccess ? ($__internal_bd1cf16c37e30917ff4f54b7320429bcc2bb63615cd8a735bfe06a3f1b5c82a0["creditos"] ?? null) : null), 2, ",", "."), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"> Crédito total do sistema </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-12 col-sm-12 col-xs-12 width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">R\$ ";
        // line 166
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["resumoMes"] ?? null), "valor", array()), 2, ",", "."), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"> Total apostado no mês </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-angle-double-up text-success\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-12 col-sm-12 col-xs-12 width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\">R\$ ";
        // line 180
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["resumoMes"] ?? null), "premio", array()), 2, ",", "."), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"> Prêmios no mês </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-angle-double-down text-danger\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-12 col-sm-12 col-xs-12 width-note\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats ";
        // line 193
        echo (((twig_get_attribute($this->env, $this->source, ($context["resumoMes"] ?? null), "liquido", array()) > 0)) ? ("text-info") : ("text-danger"));
        echo "\">
                        <p class=\"counter\">R\$ ";
        // line 194
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["resumoMes"] ?? null), "liquido", array()), 2, ",", "."), "html", null, true);
        echo "</p>
                        <span class=\"info-box-title\"> Saldo do mês </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class=\"row hide\">
        <div class=\"col-md-3 col-sm-6 col-xs-12\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\" style=\"font-size : 24px !important\">R\$ 100,00</p>
                        <span class=\"info-box-title\"> Depósitos do dia </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-3 col-sm-6 col-xs-12\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\" style=\"font-size : 24px !important\">R\$ 100,00</p>
                        <span class=\"info-box-title\"> Saques do dia </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-3 col-sm-6 col-xs-12\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\" style=\"font-size : 24px !important\">R\$ 100,00</p>
                        <span class=\"info-box-title\"> Lucro do dia </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-md-3 col-sm-6 col-xs-12\">
            <div class=\"panel info-box panel-white\" style=\"border-bottom: 2px solid #2D384A  !important;\">
                <div class=\"panel-body\">
                    <div class=\"info-box-stats\">
                        <p class=\"counter\" style=\"font-size : 24px !important\">R\$ 100,00</p>
                        <span class=\"info-box-title\"> Comissões do dia </span>
                    </div>
                    <div class=\"info-box-icon\">
                        <i class=\"fa fa-usd\"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row hide\">

        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-default\">
                <div class=\"panel-heading\">
                    <h4 class=\"panel-title\">Pesquisar Aposta</h4>
                </div>
                <div class=\"panel-body\">
                    <form method=\"\" class=\"form-inline\" action=\"\">

                        <div class=\"form-group\">
                            <input class=\"form-control\" name=\"search\" placeholder=\"Código da aposta...\"/>

                        </div>

                        <div class=\"form-group\">
                            <button class=\"btn btn-danger\" name=\"serachSubmit\"><i class=\"fa fa-search\"></i> Pesquisar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-default\">
                <div class=\"panel-heading\">
                    <h4 class=\"panel-title\">Encontrar Cambista</h4>
                </div>
                <div class=\"panel-body\">
                    <form method=\"\" class=\"form-inline\" action=\"\">

                        <div class=\"form-group\">
                            <input class=\"form-control\" name=\"search\" placeholder=\"Código do Cambista...\"/>

                        </div>

                        <div class=\"form-group\">
                            <button class=\"btn btn-info\" name=\"serachSubmit\"><i class=\"fa fa-search\"></i> Pesquisar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class=\"col-md-4 col-xs-12\">
            <div class=\"panel info-box panel-default\">
                <div class=\"panel-heading\">
                    <h4 class=\"panel-title\">Encontrar Jogo</h4>
                </div>
                <div class=\"panel-body\">
                    <form method=\"\" class=\"form-inline\" action=\"\">

                        <div class=\"form-group\">
                            <input class=\"form-control\" name=\"search\" placeholder=\"Código do Jogo...\"/>

                        </div>

                        <div class=\"form-group\">
                            <button class=\"btn btn-warning\" name=\"serachSubmit\"><i class=\"fa fa-search\"></i> Pesquisar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class=\"row\">
        <div class=\"col-md-6 col-xs-12 width-ipad-pro\">
            <div class=\"panel info-box panel-default\">
                <div class=\"panel-heading\">
                    <h4 class=\"panel-title\">Possíveis ganhadores</h4>
                    <div class=\"pull-right\">
                        <label class=\"badge badge-default\">Hoje</label>
                    </div>
                </div>
                <div class=\"panel-body panel-table\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-minified table-bordered table-striped list-table\">
                            <thead>
                            <tr>
                                <th>Cod. Aposta</th>
                                <th>Apostador</th>
                                <th>Valor</th>
                                <th>Valor de Retorno</th>
                            </tr>
                            </thead>
                            <tbody>
                            ";
        // line 358
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["possiveisGanhadores"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
            // line 359
            echo "                                <tr>
                                    <td class=\"text-center\">";
            // line 360
            echo twig_escape_filter($this->env, (($__internal_602f93ae9072ac758dc9cd47ca50516bbc1210f73d2a40b01287f102c3c40866 = $context["v"]) && is_array($__internal_602f93ae9072ac758dc9cd47ca50516bbc1210f73d2a40b01287f102c3c40866) || $__internal_602f93ae9072ac758dc9cd47ca50516bbc1210f73d2a40b01287f102c3c40866 instanceof ArrayAccess ? ($__internal_602f93ae9072ac758dc9cd47ca50516bbc1210f73d2a40b01287f102c3c40866["id"] ?? null) : null), "html", null, true);
            echo "</td>
                                    <td>";
            // line 361
            echo twig_escape_filter($this->env, (($__internal_de222b1ef20cf829a938a4545cbb79f4996337944397dd43b1919bce7726ae2f = $context["v"]) && is_array($__internal_de222b1ef20cf829a938a4545cbb79f4996337944397dd43b1919bce7726ae2f) || $__internal_de222b1ef20cf829a938a4545cbb79f4996337944397dd43b1919bce7726ae2f instanceof ArrayAccess ? ($__internal_de222b1ef20cf829a938a4545cbb79f4996337944397dd43b1919bce7726ae2f["apostador"] ?? null) : null), "html", null, true);
            echo "</td>
                                    <td class=\"text-center\">R\$ ";
            // line 362
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (($__internal_517751e212021442e58cf8c5cde586337a42455f06659ad64a123ef99fab52e7 = $context["v"]) && is_array($__internal_517751e212021442e58cf8c5cde586337a42455f06659ad64a123ef99fab52e7) || $__internal_517751e212021442e58cf8c5cde586337a42455f06659ad64a123ef99fab52e7 instanceof ArrayAccess ? ($__internal_517751e212021442e58cf8c5cde586337a42455f06659ad64a123ef99fab52e7["valor"] ?? null) : null), 2, ",", "."), "html", null, true);
            echo "</td>
                                    <td class=\"text-center\">R\$ ";
            // line 363
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (($__internal_89dde7175ba0b16509237b3e9e7cf99ba9e1b72bd3e7efcbe667781538aca289 = $context["v"]) && is_array($__internal_89dde7175ba0b16509237b3e9e7cf99ba9e1b72bd3e7efcbe667781538aca289) || $__internal_89dde7175ba0b16509237b3e9e7cf99ba9e1b72bd3e7efcbe667781538aca289 instanceof ArrayAccess ? ($__internal_89dde7175ba0b16509237b3e9e7cf99ba9e1b72bd3e7efcbe667781538aca289["retorno"] ?? null) : null), 2, ",", "."), "html", null, true);
            echo "</td>
                                </tr>
                            ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 366
            echo "                                <tr>
                                    <td colspan=\"5\" class=\"no-padding\">
                                        <div class=\"alert alert-info no-margin\">
                                            Nenhum possível ganhador até o momento.
                                        </div>
                                    </td>
                                </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 374
        echo "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-md-6 col-xs-12 width-ipad-pro\">
            <div class=\"panel info-box panel-default\">
                <div class=\"panel-heading\">
                    <h4 class=\"panel-title\">Jogos mais apostados</h4>
                    <div class=\"pull-right\">
                        <label class=\"badge badge-default\">Em aberto</label>
                    </div>
                </div>
                <div class=\"panel-body panel-table\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-minified table-bordered table-striped list-table\">
                            <thead>
                            <tr>
                                <th>Jogo</th>
                                <th>Apostas</th>
                                <th>Valor</th>
                            </tr>
                            </thead>
                            <tbody>
                            ";
        // line 399
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["jogosMaisApostados"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
            // line 400
            echo "                                <tr>
                                    <td>";
            // line 401
            echo twig_escape_filter($this->env, (($__internal_869a4b51bf6f65c335ddd8115360d724846983ee5a04751d683ca60a03391d18 = $context["v"]) && is_array($__internal_869a4b51bf6f65c335ddd8115360d724846983ee5a04751d683ca60a03391d18) || $__internal_869a4b51bf6f65c335ddd8115360d724846983ee5a04751d683ca60a03391d18 instanceof ArrayAccess ? ($__internal_869a4b51bf6f65c335ddd8115360d724846983ee5a04751d683ca60a03391d18["times"] ?? null) : null), "html", null, true);
            echo "</td>
                                    <td class=\"text-center\">";
            // line 402
            echo twig_escape_filter($this->env, (($__internal_90d913d778d5b09eba503796cc624cad16d1bef853f6e54f02eb01d7ed891018 = $context["v"]) && is_array($__internal_90d913d778d5b09eba503796cc624cad16d1bef853f6e54f02eb01d7ed891018) || $__internal_90d913d778d5b09eba503796cc624cad16d1bef853f6e54f02eb01d7ed891018 instanceof ArrayAccess ? ($__internal_90d913d778d5b09eba503796cc624cad16d1bef853f6e54f02eb01d7ed891018["apostas"] ?? null) : null), "html", null, true);
            echo "</td>
                                    <td class=\"text-center\">R\$ ";
            // line 403
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (($__internal_5c0169d493d4872ad26d34703fc2ce22459eddaa09bc03024c8105160dc27413 = $context["v"]) && is_array($__internal_5c0169d493d4872ad26d34703fc2ce22459eddaa09bc03024c8105160dc27413) || $__internal_5c0169d493d4872ad26d34703fc2ce22459eddaa09bc03024c8105160dc27413 instanceof ArrayAccess ? ($__internal_5c0169d493d4872ad26d34703fc2ce22459eddaa09bc03024c8105160dc27413["valor"] ?? null) : null), 2, ",", "."), "html", null, true);
            echo "</td>
                                </tr>
                            ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 406
            echo "                                <tr>
                                    <td colspan=\"3\" class=\"no-padding\">
                                        <div class=\"alert alert-warning no-margin\">
                                            Nenhuma aposta até o momento.
                                        </div>
                                    </td>
                                </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 414
        echo "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ";
        // line 421
        if (($context["isMaster"] ?? null)) {
            // line 422
            echo "        <div class=\"row\">

            <div class=\"col-md-8 col-sm-8 col-xs-12\">
                <div class=\"panel info-box panel-default\">
                    <div class=\"panel-heading\">
                        <h4 class=\"panel-title\">Dados para Pagamento</h4>
                    </div>
                    <div class=\"panel-body\">
                        <div class=\"row\">
                            <div class=\"col-xs-12\">
                                ";
            // line 432
            echo ($context["informacoes"] ?? null);
            echo "
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-sm-4 col-xs-12\">
                <div class=\"panel info-box panel-default\">
                    <div class=\"panel-heading\">
                        <h4 class=\"panel-title\">Informações</h4>
                    </div>
                    <div class=\"panel-body\">
                        <div class=\"row\">
                            <div class=\"col-xs-12\">
                                <div class=\"b-b p-v-xs\"><strong>Período:</strong> ";
            // line 447
            echo twig_escape_filter($this->env, ($context["periodo"] ?? null), "html", null, true);
            echo "</div>
                                <div class=\"b-b p-v-xs\"><strong>Valor do Período:</strong> ";
            // line 448
            echo twig_escape_filter($this->env, ($context["valor"] ?? null), "html", null, true);
            echo "</div>
                                <div class=\"b-b p-v-xs\"><strong>Usuários:</strong> ";
            // line 449
            echo twig_escape_filter($this->env, ($context["usuarios"] ?? null), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, ($context["limite"] ?? null), "html", null, true);
            echo "
                                </div>
                                <div class=\"p-v-xs\"><strong>Apostas:</strong> ";
            // line 451
            echo twig_escape_filter($this->env, ($context["apostas"] ?? null), "html", null, true);
            echo "</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    ";
        }
        // line 460
        echo "
";
    }

    public function getTemplateName()
    {
        return "admin/sys/principal.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  603 => 460,  591 => 451,  584 => 449,  580 => 448,  576 => 447,  558 => 432,  546 => 422,  544 => 421,  535 => 414,  522 => 406,  514 => 403,  510 => 402,  506 => 401,  503 => 400,  498 => 399,  471 => 374,  458 => 366,  450 => 363,  446 => 362,  442 => 361,  438 => 360,  435 => 359,  430 => 358,  263 => 194,  259 => 193,  243 => 180,  226 => 166,  209 => 152,  191 => 137,  173 => 122,  156 => 108,  138 => 93,  120 => 78,  92 => 53,  67 => 31,  43 => 10,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/sys/principal.twig", "/home2/bets01/public_html/app/views/admin/sys/principal.twig");
    }
}
