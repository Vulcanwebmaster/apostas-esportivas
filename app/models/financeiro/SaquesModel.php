<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 04/08/2017
 * Time: 17:14
 */

namespace app\models\financeiro;


use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\models\DadosModel;
use app\models\HistoricoBancarioModel;
use app\models\IndicacoesModel;
use app\models\UsersModel;
use app\vo\financeiro\SaqueVO;
use app\vo\UserVO;

class SaquesModel extends Model
{

    const STATUS_AGUARDANDO = 1;
    const STATUS_APROVADO = 2;
    const STATUS_DESAPROVADO = 0;

    const STATUS = [
        self::STATUS_AGUARDANDO => 'Em processamento',
        self::STATUS_APROVADO => 'Aprovado',
        self::STATUS_DESAPROVADO => 'Rejeitado',
    ];

    function __construct()
    {
        $this->table = 'sis_saques';
        $this->valueObject = SaqueVO::class;
    }

    /**
     * @param array $parans
     * @param int $page
     * @param int $perpage
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $perpage = 10)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];
        $orderby = 'a.insert DESC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $sinal = $key == 'dataInicial' ? '>=' : '<=';
                                $termos .= " AND a.data {$sinal} :{$key}";
                                $places[$key] = $data;
                            }
                            break;
                        case 'id':
                        case 'token':
                        case 'user':
                        case 'status':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $perpage);
    }

    /**
     * Adiciona um saque
     * @param SaqueVO $saque
     */
    public static function addSaque(SaqueVO $saque)
    {

        $configuracao = DadosModel::get();
        $taxa = $configuracao->getTaxaSaque();

        $user = $saque->voUser();

        # Usuário
        if (!$user instanceof UserVO) {
            throw new \Exception('Usuário inválido');
        } # Em dia
        else if (!$user->estaEmDia()) {
            throw new \Exception("Para solicitar um saque é necessário que esteja em dia com sua mensalidade");
        } # Indicados
        else if ($configuracao->getSaqueIndicados() > 0 and IndicacoesModel::getIndicados($user, 1, true, true) < $configuracao->getSaqueIndicados()) {
            throw new \Exception("É necessário que tenha no mínimo {$configuracao->getSaqueIndicados()} indicados diretos para solicitar um saque");
        } # Saldo
        else if ($saque->getValor() > $user->getCredito()) {
            throw new \Exception('Saldo insuficiente para saque. Seu saldo atual é de R$ ' . $user->getCredito(true));
        } # Saque mínimo
        else if ($saque->getValor() < 100) {
            throw new \Exception('Saque mínimo de R$ 100,00 (cem reais)');
        }

        if ($taxa > 0) {
            $saque->setTaxa($taxa);
            if (($saque->getValor() + $taxa) > $user->getCredito()) {
                $saque->setValor($saque->getValor() - $taxa);
            }
        }

        $saque->save();

        HistoricoBancarioModel::add($user, -$saque->getValor(), "<b>SAQUE</b> - Saque (#{$saque->getId()}) - Realizado com sucesso", $saque);

        if ($taxa) {
            HistoricoBancarioModel::add($user, -$taxa, "<b>TARIFA</b> - Tarifa referente ao Saque (#{$saque->getId()})", $saque, 'taxa');
        }

    }

    /**
     * @return string
     */
    public static function optionsBancos()
    {
        $bancos = array(
            array('code' => '001', 'name' => 'Banco do Brasil'),
            array('code' => '003', 'name' => 'Banco da Amazônia'),
            array('code' => '004', 'name' => 'Banco do Nordeste'),
            array('code' => '021', 'name' => 'Banestes'),
            array('code' => '025', 'name' => 'Banco Alfa'),
            array('code' => '027', 'name' => 'Besc'),
            array('code' => '029', 'name' => 'Banerj'),
            array('code' => '031', 'name' => 'Banco Beg'),
            array('code' => '033', 'name' => 'Banco Santander Banespa'),
            array('code' => '036', 'name' => 'Banco Bem'),
            array('code' => '037', 'name' => 'Banpará'),
            array('code' => '038', 'name' => 'Banestado'),
            array('code' => '039', 'name' => 'BEP'),
            array('code' => '040', 'name' => 'Banco Cargill'),
            array('code' => '041', 'name' => 'Banrisul'),
            array('code' => '044', 'name' => 'BVA'),
            array('code' => '045', 'name' => 'Banco Opportunity'),
            array('code' => '047', 'name' => 'Banese'),
            array('code' => '062', 'name' => 'Hipercard'),
            array('code' => '063', 'name' => 'Ibibank'),
            array('code' => '065', 'name' => 'Lemon Bank'),
            array('code' => '066', 'name' => 'Banco Morgan Stanley Dean Witter'),
            array('code' => '069', 'name' => 'BPN Brasil'),
            array('code' => '070', 'name' => 'Banco de Brasília – BRB'),
            array('code' => '072', 'name' => 'Banco Rural'),
            array('code' => '073', 'name' => 'Banco Popular'),
            array('code' => '074', 'name' => 'Banco J. Safra'),
            array('code' => '075', 'name' => 'Banco CR2'),
            array('code' => '076', 'name' => 'Banco KDB'),
            array('code' => '096', 'name' => 'Banco BMF'),
            array('code' => '104', 'name' => 'Caixa Econômica Federal'),
            array('code' => '107', 'name' => 'Banco BBM'),
            array('code' => '116', 'name' => 'Banco Único'),
            array('code' => '151', 'name' => 'Nossa Caixa'),
            array('code' => '175', 'name' => 'Banco Finasa'),
            array('code' => '184', 'name' => 'Banco Itaú BBA'),
            array('code' => '204', 'name' => 'American Express Bank'),
            array('code' => '208', 'name' => 'Banco Pactual'),
            array('code' => '212', 'name' => 'Banco Matone'),
            array('code' => '213', 'name' => 'Banco Arbi'),
            array('code' => '214', 'name' => 'Banco Dibens'),
            array('code' => '217', 'name' => 'Banco Joh Deere'),
            array('code' => '218', 'name' => 'Banco Bonsucesso'),
            array('code' => '222', 'name' => 'Banco Calyon Brasil'),
            array('code' => '224', 'name' => 'Banco Fibra'),
            array('code' => '225', 'name' => 'Banco Brascan'),
            array('code' => '229', 'name' => 'Banco Cruzeiro'),
            array('code' => '230', 'name' => 'Unicard'),
            array('code' => '233', 'name' => 'Banco GE Capital'),
            array('code' => '237', 'name' => 'Bradesco'),
            array('code' => '241', 'name' => 'Banco Clássico'),
            array('code' => '243', 'name' => 'Banco Stock Máxima'),
            array('code' => '246', 'name' => 'Banco ABC Brasil'),
            array('code' => '248', 'name' => 'Banco Boavista Interatlântico'),
            array('code' => '249', 'name' => 'Investcred Unibanco'),
            array('code' => '250', 'name' => 'Banco Schahin'),
            array('code' => '252', 'name' => 'Fininvest'),
            array('code' => '254', 'name' => 'Paraná Banco'),
            array('code' => '263', 'name' => 'Banco Cacique'),
            array('code' => '265', 'name' => 'Banco Fator'),
            array('code' => '266', 'name' => 'Banco Cédula'),
            array('code' => '300', 'name' => 'Banco de la Nación Argentina'),
            array('code' => '318', 'name' => 'Banco BMG'),
            array('code' => '320', 'name' => 'Banco Industrial e Comercial'),
            array('code' => '356', 'name' => 'ABN Amro Real'),
            array('code' => '341', 'name' => 'Itau'),
            array('code' => '347', 'name' => 'Sudameris'),
            array('code' => '351', 'name' => 'Banco Santander'),
            array('code' => '353', 'name' => 'Banco Santander Brasil'),
            array('code' => '366', 'name' => 'Banco Societe Generale Brasil'),
            array('code' => '370', 'name' => 'Banco WestLB'),
            array('code' => '376', 'name' => 'JP Morgan'),
            array('code' => '389', 'name' => 'Banco Mercantil do Brasil'),
            array('code' => '394', 'name' => 'Banco Mercantil de Crédito'),
            array('code' => '399', 'name' => 'HSBC'),
            array('code' => '409', 'name' => 'Unibanco'),
            array('code' => '412', 'name' => 'Banco Capital'),
            array('code' => '422', 'name' => 'Banco Safra'),
            array('code' => '453', 'name' => 'Banco Rural'),
            array('code' => '456', 'name' => 'Banco Tokyo Mitsubishi UFJ'),
            array('code' => '464', 'name' => 'Banco Sumitomo Mitsui Brasileiro'),
            array('code' => '477', 'name' => 'Citibank'),
            array('code' => '479', 'name' => 'Itaubank (antigo Bank Boston)'),
            array('code' => '487', 'name' => 'Deutsche Bank'),
            array('code' => '488', 'name' => 'Banco Morgan Guaranty'),
            array('code' => '492', 'name' => 'Banco NMB Postbank'),
            array('code' => '494', 'name' => 'Banco la República Oriental del Uruguay'),
            array('code' => '495', 'name' => 'Banco La Provincia de Buenos Aires'),
            array('code' => '505', 'name' => 'Banco Credit Suisse'),
            array('code' => '600', 'name' => 'Banco Luso Brasileiro'),
            array('code' => '604', 'name' => 'Banco Industrial'),
            array('code' => '610', 'name' => 'Banco VR'),
            array('code' => '611', 'name' => 'Banco Paulista'),
            array('code' => '612', 'name' => 'Banco Guanabara'),
            array('code' => '613', 'name' => 'Banco Pecunia'),
            array('code' => '623', 'name' => 'Banco Panamericano'),
            array('code' => '626', 'name' => 'Banco Ficsa'),
            array('code' => '630', 'name' => 'Banco Intercap'),
            array('code' => '633', 'name' => 'Banco Rendimento'),
            array('code' => '634', 'name' => 'Banco Triângulo'),
            array('code' => '637', 'name' => 'Banco Sofisa'),
            array('code' => '638', 'name' => 'Banco Prosper'),
            array('code' => '643', 'name' => 'Banco Pine'),
            array('code' => '652', 'name' => 'Itaú Holding Financeira'),
            array('code' => '653', 'name' => 'Banco Indusval'),
            array('code' => '654', 'name' => 'Banco A.J. Renner'),
            array('code' => '655', 'name' => 'Banco Votorantim'),
            array('code' => '707', 'name' => 'Banco Daycoval'),
            array('code' => '719', 'name' => 'Banif'),
            array('code' => '721', 'name' => 'Banco Credibel'),
            array('code' => '734', 'name' => 'Banco Gerdau'),
            array('code' => '735', 'name' => 'Banco Pottencial'),
            array('code' => '738', 'name' => 'Banco Morada'),
            array('code' => '739', 'name' => 'Banco Galvão de Negócios'),
            array('code' => '740', 'name' => 'Banco Barclays'),
            array('code' => '741', 'name' => 'BRP'),
            array('code' => '743', 'name' => 'Banco Semear'),
            array('code' => '745', 'name' => 'Banco Citibank'),
            array('code' => '746', 'name' => 'Banco Modal'),
            array('code' => '747', 'name' => 'Banco Rabobank International'),
            array('code' => '748', 'name' => 'Banco Cooperativo Sicredi'),
            array('code' => '749', 'name' => 'Banco Simples'),
            array('code' => '751', 'name' => 'Dresdner Bank'),
            array('code' => '752', 'name' => 'BNP Paribas'),
            array('code' => '753', 'name' => 'Banco Comercial Uruguai'),
            array('code' => '755', 'name' => 'Banco Merrill Lynch'),
            array('code' => '756', 'name' => 'Banco Cooperativo do Brasil'),
            array('code' => '757', 'name' => 'KEB'),
        );

        $html = '';

        foreach ($bancos as $banco) {
            $html .= formOption("{$banco['code']} - {$banco['name']}");
        }

        return $html;
    }

}