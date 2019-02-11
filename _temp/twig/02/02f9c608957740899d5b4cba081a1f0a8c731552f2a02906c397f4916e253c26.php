<?php

/* admin/inc/modal-saque.twig */
class __TwigTemplate_48eb22b80de8add0c1e284b12d4139fb02db3921cb1f019f71090033294a425a extends Twig_Template
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
        echo "<form class=\"modal fade modal-saque\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 style=\"display: inline-block;font-size: 18px;margin-top: -4px;\" class=\"modal-title\">
                    Solicitar saque
                </h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <div class=\"modal-body\">

                <div class=\"row\">
                    <div class=\"col-md-6 col-sm-12 col-xs-12\">
                        <div class=\"form-group\">
                            <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">Valor (R\$)</label>
                            <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                  data-content=\"Digite o valor a ser resgatado. Ex.: 20,50\"
                                  data-original-title=\"\"
                                  title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                            <input type=\"text\" class=\"form-control mask-valor\" name=\"valor\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">
                        <label>Tipo de saque</label>
                        <select name=\"tipo\" class=\"form-control\" required>
                            <option value=\"banco\">Conta bancária</option>
                            <option value=\"picpay\">Picpay</option>
                        </select>
                    </div>
                </div>

                <div class=\"tipos\">
                    <div class=\"tipo-banco\">
                        <div class=\"row\">
                            <div class=\"col-md-12 col-sm-12 col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">Banco</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Selecione uma das opções.\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <select name=\"banco\" class=\"form-control\">
                                        <option value> -- Selecione --</option>
                                        ";
        // line 45
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('optBancos')->getCallable(), array()), "html", null, true);
        echo "
                                       </select>
                                </div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">N.º da
                                        Agência</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Digite o número da agência. Ex.: 001\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <input type=\"text\" class=\"form-control\" name=\"agencia\">
                                </div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">N.º da conta</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Digite o número da conta.\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <input type=\"text\" class=\"form-control\" name=\"conta\">
                                </div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">
                                <label><b>Tipo de conta</b></label>
                                <select name=\"contatipo\" class=\"form-control\">
                                    <option>Poupança</option>
                                    <option>Corrente</option>
                                </select>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">
                                <label><b>Variação</b></label>
                                <input type=\"text\" name=\"variacao\" class=\"form-control\" maxlength=\"10\"/>
                            </div>
                            <div class=\"col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">Nome do
                                        titular</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Digite o seu nome\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <input type=\"text\" class=\"form-control\" name=\"nomecompleto\">
                                </div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">CPF</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Digite o seu CPF.\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <input type=\"text\" class=\"form-control mask-cpf\" name=\"cpf\">
                                </div>
                            </div>
                            <div class=\"col-md-6 col-sm-12 col-xs-12\">
                                <div class=\"form-group\">
                                    <label style=\"font-weight : bold;margin-bottom : 6px;\" class=\"\">CNPJ (somente, se a
                                        conta for jurídica)</label>
                                    <span class=\"pointer\" data-toggle=\"popover\" data-trigger=\"hover\"
                                          data-content=\"Digite o seu CNPJ.\" data-original-title=\"\"
                                          title=\"\">[<i class=\"fa fa-question\"></i>]</span>
                                    <input type=\"text\" class=\"form-control mask-cnpj\" name=\"cnpj\">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=\"tipo-picpay hide\">
                        <div class=\"form-group\">
                            <label>Usuário Picpay</label>
                            <input type=\"text\" name=\"picpay\" class=\"form-control\"/>
                        </div>
                    </div>
                </div>

                <div class=\"checkbox\">
                    <label>
                        <input type=\"checkbox\" name=\"principal\" value=\"1\"> Salvar como principal
                    </label>
                </div>

            </div>
            <div class=\"modal-footer text-right\">
                <button type=\"reset\" class=\"btn btn-danger\">
                    <i class=\"fa fa-trash\" style=\"margin-right : 4px;\"></i>Limpar
                </button>
                <button type=\"submit\" class=\"btn btn-primary\">
                    <i class=\"fa fa-usd\" style=\"margin-right : 4px;\"></i> Sacar
                </button>
            </div>
        </div>
    </div>
</form>";
    }

    public function getTemplateName()
    {
        return "admin/inc/modal-saque.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 45,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/inc/modal-saque.twig", "/home2/bets01/public_html/app/views/admin/inc/modal-saque.twig");
    }
}
