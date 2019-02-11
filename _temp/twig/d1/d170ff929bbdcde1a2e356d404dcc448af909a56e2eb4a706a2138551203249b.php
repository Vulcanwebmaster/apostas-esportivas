<?php

/* admin/configuracoes/configuracoes.twig */
class __TwigTemplate_d4594d2f9f0ab7a967a94b7ca8f0d347d13dcf604bbf2578da39eed0eae63d49 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("admin/layout.twig", "admin/configuracoes/configuracoes.twig", 1);
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
    <form class=\"admpage-form\" enctype=\"multipart/form-data\">
        <div class=\"panel info-box panel-default\">
            <div class=\"panel-heading\">
                <h4 class=\"panel-title\">Configurações</h4>
            </div>
            <div class=\"panel-body\">
                <div class=\"row\">

                    <div class=\"col-md-5 col-sm-5 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Nome</label>
                            <input type=\"text\" name=\"banca\" placeholder=\"Nome da banca...\" class=\"form-control text\">
                        </div>
                    </div>

                    <div class=\"form-group col-md-2 col-xs-12\">
                        <label>UF</label>
                        <select name=\"estado\" class=\"form-control\" required=\"\">
                            ";
        // line 23
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('optEstados')->getCallable(), array()), "html", null, true);
        echo "
                        </select>
                    </div>

                    <div class=\"form-group col-md-5 col-xs-12\">
                        <label>Cidade</label>
                        <select name=\"cidade\" class=\"form-control\" required=\"\"></select>
                    </div>

                    <div class=\"form-group col-xs-12\">
                        <label>E-mail</label>
                        <input type=\"email\" class=\"form-control\" name=\"email\" />
                    </div>

                    <div class=\"form-group col-md-3 col-xs-12\">
                        <label>Máximo de apostas/usuário/dia</label>
                        <input type=\"text\" name=\"maxapostasdia\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Valor Pré Cadastro</label>
                        <input type=\"text\" name=\"valorprecadastro\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Aposta mínima</label>
                        <input type=\"text\" name=\"apostaminima\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Aposta máxima</label>
                        <input type=\"text\" name=\"apostamaxima\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Retorno máximo</label>
                        <input type=\"text\" name=\"retornomaximo\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Cotação mínima</label>
                        <input type=\"text\" name=\"cotacaominima\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-6\">
                        <label>Cotação máxima</label>
                        <input type=\"text\" name=\"cotacaomaxima\" class=\"mask-valor form-control\">
                    </div>

                    <div class=\"form-group col-md-3 col-xs-12\">
                        <label>Depósito mínimo</label>
                        <input type=\"text\" name=\"depositominimo\" class=\"mask-valor form-control\">
                    </div>

                </div>

                <div class=\"row\">
                    <div class=\"col-md-9 col-xs-12\">
                        <div class=\"form-group\">
                            <label>APP</label>
                            <input type=\"text\" name=\"app\" class=\"form-control text\">
                            <small class=\"help-block\">Link para o aplicativo de impressão.</small>
                        </div>
                    </div>

                    <div class=\"col-md-3 col-xs-6\">
                        <div class=\"form-group\">
                            <label>Taxa transferência</label>
                            <div class=\"input-group\">
                                <div class=\"input-group-addon\">
                                    %
                                </div>
                                <input type=\"text\" name=\"taxatransferencia\" class=\"form-control mask-valor\"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"row\">

                    <div class=\"col-md-3 col-xs-6\">
                        <div class=\"form-group\">
                            <label>Indicados saque</label>
                            <input type=\"number\" min=\"0\" max=\"200\" name=\"saqueindicados\" class=\"form-control\"/>
                        </div>
                    </div>

                    <div class=\"col-md-3 col-xs-6\">
                        <div class=\"form-group\">
                            <label>Taxa saque R\$</label>
                            <input type=\"text\" name=\"taxasaque\" class=\"form-control mask-valor\"/>
                        </div>
                    </div>

                    <div class=\"col-md-3 col-xs-6\">
                        <div class=\"form-group\">
                            <label>Imprimir regras</label>
                            <select class=\"form-control\" name=\"imprimirregras\">
                                <option value=\"1\">Sim</option>
                                <option value=\"0\">Não</option>
                            </select>
                        </div>
                    </div>

                    <div class=\"col-md-3 col-xs-12\">
                        <div class=\"form-group\">
                            <label>Logo na impressão</label>
                            <select class=\"form-control\" name=\"imprimirlogo\">
                                <option value=\"1\">Sim</option>
                                <option value=\"0\">Não</option>
                            </select>
                        </div>
                    </div>

                    <div class=\"col-xs-12\">
                        <h3>Limites de Jogos</h3>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label>
                                Max. Apostas
                            </label>
                            <input type=\"number\" min=\"0\" max=\"99999999999\" name=\"maxapostas\" placeholder=\"Ilimitado\"
                                   class=\"form-control\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label for=\"time_foraLabel\">
                                Limite 1 Jogo
                            </label>
                            <input type=\"text\" name=\"limite1\" placeholder=\"Ilimitado\" class=\"form-control mask-valor\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label for=\"time_foraLabel\">
                                Limite 2 Jogos
                            </label>
                            <input type=\"text\" name=\"limite2\" placeholder=\"Ilimitado\" class=\"form-control mask-valor\">
                        </div>
                    </div>

                    <div class=\"col-md-3 col-sm-6 col-xs-12\">
                        <div class=\"form-group\">
                            <label for=\"time_foraLabel\">
                                Limite 3 Jogos
                            </label>
                            <input type=\"text\" name=\"limite3\" placeholder=\"Ilimitado\" class=\"form-control mask-valor\">
                        </div>
                    </div>

                    <div class=\"col-xs-12\">
                        <div class=\"form-group\">
                            <label class=\"\" for=\"informacoesLabel\">
                                Informações
                            </label>
                            <textarea name=\"informacoes\" data-ckeditor height=\"300\"></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class=\"panel-footer\">
                <div>
                    <div class=\"row\">
                        <div class=\"text-left col-md-8 col-xs-12\">
                            <label for=\"background\" class=\"btn-info btn btn-inputfile\">
                                <span><i class=\"fa fa-camera\"></i> Background <span></span></span>
                                <input type=\"file\" name=\"background\" id=\"background\" accept=\"image/jpeg\"/>
                            </label>
                            <label for=\"logotipo\" class=\"btn-success btn btn-inputfile\">
                                <span><i class=\"fa fa-camera\"></i> Logotipo <span></span></span>
                                <input type=\"file\" name=\"logo\" id=\"logotipo\" accept=\"image/*\"/>
                            </label>
                        </div>
                        <div class=\"text-right col-md-4 col-xs-12\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"\" value=\"\">
                                <i class=\"fa fa-save\"></i> Salvar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

";
    }

    // line 216
    public function block_script($context, array $blocks = array())
    {
        // line 217
        echo "
    <script>

        \$('.admpage-form')
            .setValues(";
        // line 221
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('json')->getCallable(), array(($context["config"] ?? null), true)), "html", null, true);
        echo ")
            .adminPage({
                autoSearch: false,
                autoReset: false,
                alertSuccess: true,
            });

        \$('.color-picker')
            .colorpicker({
                format: 'hex',
            });

    </script>

";
    }

    public function getTemplateName()
    {
        return "admin/configuracoes/configuracoes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  262 => 221,  256 => 217,  253 => 216,  57 => 23,  36 => 4,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/configuracoes/configuracoes.twig", "/home2/bets01/public_html/app/views/admin/configuracoes/configuracoes.twig");
    }
}
