<?php

/* admin/usuarios/form.twig */
class __TwigTemplate_440baa77cd240a47efa57aeb56a78c3ade9c380e00e4cf4ece3f14d0dacc1d36 extends Twig_Template
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
        echo "<form class=\"admpage-form modal fade\" method=\"post\" accept-charset=\"utf-8\" enctype=\"multipart/form-data\">
    <input name=\"id\" type=\"hidden\" value=\"\" id=\"input_59987e4d5f45a\"/>
    <input name=\"zoom\" type=\"hidden\" value=\"\" id=\"input_59987e4d5f466\"/>
    <input name=\"latitude\" type=\"hidden\" value=\"\" id=\"input_59987e4d5f472\"/>
    <input name=\"longitude\" type=\"hidden\" value=\"\" id=\"input_59987e4d5f47e\"/>
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h3 class=\"modal-title\"><i class=\"fa fa-user\"></i> Usuário</h3>
            </div>
            <div class=\"modal-body\">
                <div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <h3 class=\"m-t-0 m-b-30\">
                                <i class=\"fa fa-id-card\"></i>
                                Dados Pessoais
                            </h3>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-3 col-xs-6 form-group\">
                            <label>Graduação</label>
                            <select name=\"graduacao\" class=\"form-control\">
                                <option value=\"0\">Não graduado</option>
                                ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["graduacoes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["v"]) {
            // line 27
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getId", array(), "method"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["v"], "getTitle", array(), "method"), "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['v'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "                            </select>
                        </div>
                        ";
        // line 31
        if ((twig_get_attribute($this->env, $this->source, ($context["vars"] ?? null), "type", array()) == 5)) {
            // line 32
            echo "                            <div class=\"col-md-3 col-xs-6 form-group\">
                                <label>Comissão sobre cambistas</label>
                                <input type=\"text\" name=\"comissao\" class=\"form-control mask-valor\"/>
                            </div>
                        ";
        }
        // line 37
        echo "                        <div class=\"col-md-";
        echo (((twig_get_attribute($this->env, $this->source, ($context["vars"] ?? null), "type", array()) == 5)) ? (6) : (9));
        echo " col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dbbc\" class=\"caption \">Nome Completo</label>
                                <input name=\"nome\" type=\"text\" value=\"\" required=\"\" id=\"input_59987e4d5dbbc\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dbfc\" class=\"caption \">CPF</label>
                                <input name=\"cpf\" type=\"text\" value=\"\" required=\"\" class=\"mask-cpf form-control\"
                                       id=\"input_59987e4d5dbfc\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"select_59987e4d5dc48\" class=\"caption \">Sexo</label>
                                <select name=\"sexo\" required=\"\" id=\"select_59987e4d5dc48\" class=\"form-control\">
                                    <option value=\"m\">Masculino</option>
                                    <option value=\"f\">Feminino</option>
                                </select>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dc6f\" class=\"caption \">Data Nascimento</label>
                                <input name=\"nascimento\" type=\"date\" value=\"\" required=\"\" id=\"input_59987e4d5dc6f\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <h3 style=\"margin-bottom : 30px !important;\"><i class=\"fa fa-map-marker\"
                                                                            style=\"margin-right : 6px;\"></i>Localização
                            </h3>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-3 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dc9e\" class=\"caption \">CEP</label>
                                <input name=\"cep\" type=\"text\" value=\"\" required=\"\" class=\"mask-cep form-control\"
                                       id=\"input_59987e4d5dc9e\"/>
                            </div>
                        </div>
                        <div class=\"col-md-6 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dcc8\" class=\"caption \">Logradouro</label>
                                <input name=\"logradouro\" type=\"text\" value=\"\" id=\"input_59987e4d5dcc8\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                        <div class=\"col-md-3 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dcea\" class=\"caption \">Número</label>
                                <input name=\"numero\" type=\"text\" value=\"\" id=\"input_59987e4d5dcea\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dd0a\" class=\"caption \">Complemento</label>
                                <input name=\"complemento\" type=\"text\" value=\"\" id=\"input_59987e4d5dd0a\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5dd38\" class=\"caption \">Bairro</label>
                                <input name=\"bairro\" type=\"text\" value=\"\" id=\"input_59987e4d5dd38\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                        <div class=\"col-md-3 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"select_59987e4d5eabf\" class=\"caption \">Estado</label>
                                <select name=\"estado\" required=\"\" id=\"select_59987e4d5eabf\" class=\"form-control\">
                                    ";
        // line 121
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('optEstados')->getCallable(), array()), "html", null, true);
        echo "
                                </select>
                            </div>
                        </div>
                        <div class=\"col-md-5 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"select_59987e4d5eafe\" class=\"caption \">Cidade</label>
                                <select name=\"cidade\" required=\"\" id=\"select_59987e4d5eafe\"
                                        class=\"form-control\"></select>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <h3 style=\"margin-bottom : 30px !important;\">
                                <i class=\"fa fa-phone\" style=\"margin-right : 6px;\"></i>Telefones de Contato
                            </h3>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5eb40\" class=\"caption \">Telefone</label>
                                <input name=\"telefone\" type=\"text\" value=\"\" class=\"mask-telefone form-control\"
                                       id=\"input_59987e4d5eb40\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5eb76\" class=\"caption \">Celular</label>
                                <input name=\"celular\" type=\"text\" value=\"\" class=\"mask-telefone form-control\"
                                       required=\"\"
                                       id=\"input_59987e4d5eb76\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5eba0\" class=\"caption \">Whatsapp</label>
                                <input name=\"whatsapp\" type=\"text\" value=\"\" class=\"mask-telefone form-control\"
                                       id=\"input_59987e4d5eba0\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <h3 style=\"margin-bottom : 30px !important;\"><i class=\"fa fa-lock\"
                                                                            style=\"margin-right : 6px;\"></i>Dados de
                                acesso
                            </h3></div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5f3bc\" class=\"caption \">E-mail</label>
                                <input name=\"email\" type=\"email\" value=\"\" placeholder=\"example@email.com\" required=\"\"
                                       id=\"input_59987e4d5f3bc\" class=\"form-control\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-6\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5ebf2\" class=\"caption \">Login/Usuário</label>
                                <input name=\"login\" type=\"text\" value=\"\" placeholder=\"Seu usuário\"
                                       pattern=\"[A-Za-z0-9_]{5,20}\" required=\"1\" id=\"input_59987e4d5ebf2\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5f3f2\" class=\"caption \">Senha</label>
                                <input name=\"senha\" type=\"password\" value=\"\" placeholder=\"Mínimo 5 caracteres\"
                                       pattern=\"[A-Za-z0-9]{5,20}\" maxlength=\"20\" id=\"input_59987e4d5f3f2\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                        <div class=\"col-md-4 col-xs-12\">
                            <div class=\"form-group\">
                                <label for=\"input_59987e4d5f421\" class=\"caption \">Confirmar Senha</label>
                                <input name=\"confirmar-senha\" type=\"password\" value=\"\" placeholder=\"Repita a senha\"
                                       pattern=\"[A-Za-z0-9]{5,20}\" maxlength=\"20\" id=\"input_59987e4d5f421\"
                                       class=\"form-control\"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <div>
                    <div class=\"row\">
                        <div class=\"col-xs-6 text-left\">
                            <label for=\"inputfile_59987e4d5f71e\" class=\"btn-success btn btn-inputfile\"
                                   style=\"width: auto; overflow: hidden;\"><span><i
                                            class=\"fa fa-camera\"></i> Foto <span></span></span>
                                <input type=\"file\" name=\"filefoto\" id=\"inputfile_59987e4d5f71e\" accept=\"image/jpeg\"
                                       style=\"position: absolute; top: 0; left: 0; opacity: 0; filter: alpha(opacity=0);\">
                            </label>
                        </div>
                        <div class=\"col-xs-6 text-right\">
                            <div class=\"btn-group\">
                                <button type=\"reset\" class=\"btn btn-danger\" name=\"\" value=\"\"><i class=\"fa fa-trash\"></i>
                                    Limpar
                                </button>
                                <button type=\"submit\" class=\"btn btn-primary\" name=\"\" value=\"\"><i
                                            class=\"fa fa-save\"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>";
    }

    public function getTemplateName()
    {
        return "admin/usuarios/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 121,  78 => 37,  71 => 32,  69 => 31,  65 => 29,  54 => 27,  50 => 26,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin/usuarios/form.twig", "/home2/bets01/public_html/app/views/admin/usuarios/form.twig");
    }
}
