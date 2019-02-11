<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 12/07/2017
 * Time: 16:42
 */

namespace app\helpers\pagamento;


use app\helpers\ItauHelper;
use app\helpers\Number;

class ItauShopLinePagamento extends Pagamento
{


    public function cobrar()
    {

        $cripto = new ItauHelper();

        $codEmp = 'J0182254970001010000026079';
        $chave = strtoupper('qwertyuiop172839');

        $pagamento = $this->getPagamento();
        $cliente = $pagamento->voUser();

        if (!$pagamento->getId()) {
            $pagamento->save();
        }

        $taxa = $pagamento->getValor() * 0.01;
        $valor = Number::real($pagamento->getValor() + $taxa);
        $pedido = $pagamento->getId(); // Identificação do pedido - máximo de 8 dígitos (12345678) - Obrigatório
        $valor = str_replace('.', '', $valor); // Valor do pedido - máximo de 8 dígitos + vírgula + 2 dígitos - 99999999,99 - Obrigatório
        $observacao = $pagamento->getDescricao(); // Observações - máximo de 40 caracteres
        $nomeSacado = substr($cliente->getNome(), 0, 30); // Nome do sacado - máximo de 30 caracteres
        $codigoInscricao = '01'; // Código de Inscrição: 01->CPF, 02->CNPJ
        $numeroInscricao = preg_replace('/[^0-9]/', null, $cliente->getCpf()); // Número de Inscrição: CPF ou CNPJ - até 14 caracteres
        $enderecoSacado = "{$cliente->getLogradouro()}, {$cliente->getNumero()}"; // Endereco do Sacado - máximo de 40 caracteres
        $bairroSacado = $cliente->getBairro(); // Bairro do Sacado - máximo de 15 caracteres
        $cepSacado = preg_replace('/[^0-9]/', null, $cliente->getCep()); // Cep do Sacado - máximo de 8 dígitos
        $cidadeSacado = $cliente->getCidadeTitle(); // Cidade do sacado - máximo 15 caracteres
        $estadoSacado = $cliente->getUf(); // Estado do Sacado - 2 caracteres
        $dataVencimento = str_replace('/', '', $pagamento->getDataVencimento(true)); // Vencimento do título - 8 dígitos - ddmmaaaa
        $urlRetorna = url('itaushopline', [$pagamento->getToken()], 'notificacoes'); // URL do retorno - máximo de 60 caracteres
        $obsAdicional1 = $pagamento->getDescricao(); // ObsAdicional1 - máximo de 60 caracteres
        $obsAdicional2 = "Taxa R$ {$taxa} shopline"; // ObsAdicional2 - máximo de 60 caracteres
        $obsAdicional3 = ''; // ObsAdicional3 - máximo de 60 caracteres

        $dados_criptografados = $cripto->geraDados(
            $codEmp, $pedido, $valor, $observacao, $chave, $nomeSacado,
            $codigoInscricao, $numeroInscricao, $enderecoSacado, $bairroSacado,
            $cepSacado, $cidadeSacado, $estadoSacado, $dataVencimento,
            $urlRetorna, $obsAdicional1, $obsAdicional2, $obsAdicional3);

        $url = url('itaushopline/redireciona', [$this->getPagamento()->getToken()], 'notificacoes');

        $this
            ->getPagamento()
            ->setLink($url)
            ->setDados($dados_criptografados)
            ->save();

    }

    public function redirect()
    {
        echo <<<HTML
<form id="shopline" method="post" onsubmit="javascript:return _submit();" action="https://shopline.itau.com.br/shopline/shopline.aspx" target="_self">
    <input type="hidden" name="DC" value="{$this->getPagamento()->getDados()}">
    <input type="hidden" name="Shopline" value="Itaú Shopline">
</form>
<script>
    
    function _submit(){
        window.open('SHOPLINE', 'toolbar=yes,menubar=yes,resizable=yes,status=no,scrollbars=yes,width=815,height=575');
        return false;
    }
    
    document.getElementById("shopline").submit();
</script>
HTML;
    }


}