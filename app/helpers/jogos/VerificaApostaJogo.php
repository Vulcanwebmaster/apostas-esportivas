<?php

namespace app\helpers\jogos;

use app\core\crud\Conn;
use app\models\ApostasModel;
use app\vo\ApostaJogoVO;

class VerificaApostaJogo
{

    /**
     * Verificando apostas
     * @var ApostaJogoVO $apostaJogo
     * @return boolean
     */
    public function verificaAposta(ApostaJogoVO $apostaJogo)
    {
        if (!$apostaJogo->getVerificado()) {

            $acertou = $this->verificar_placar($apostaJogo);

            $apostaJogo->setVerificado(1);
            $apostaJogo->setAcertou($acertou ? 1 : 0);
            $apostaJogo->Save();

            Conn::getConn()
                ->prepare("UPDATE `" . ApostasModel::getTable() . "` AS a "
                    . "SET "
                    . "a.jogosverificados = a.jogosverificados + 1, "
                    . "a.acertos = a.acertos + :acertou, "
                    . "a.erros = a.erros + :errou, "
                    . "a.possivelganhador = IF(a.erros = 0, 1, 0), "
                    . "a.ganhou = IF(a.jogos = a.acertos AND a.erros = 0, 1, 0), "
                    . "a.possivelganhador = IF(a.ganhou = 1 OR a.jogos = a.jogosverificados OR a.erros > 0, 0, a.possivelganhador), "
                    . "a.verificado = IF(a.jogos = a.jogosverificados, 1, 0) "
                    . "WHERE a.id = :aposta "
                    . "LIMIT 1")
                ->execute([
                    'aposta' => $apostaJogo->getAposta(),
                    'acertou' => $apostaJogo->getAcertou() ? 1 : 0,
                    'errou' => $apostaJogo->getAcertou() ? 0 : 1,
                ]);

            return $acertou;
        } else {
            return false;
        }
    }

    /**
     * Verifica o palpite pelo tipo
     * @var ApostaJogoVO $apostaJogo
     * @return boolean
     */
    private function verificar_placar(ApostaJogoVO $apostaJogo)
    {
        switch ($apostaJogo->getTipo()) {
            case 'casa':
                return $this->check_casa($apostaJogo);
                break;
            case 'empate':
                return $this->check_empate($apostaJogo);
                break;
            case 'fora':
                return $this->check_fora($apostaJogo);
                break;
            case 'gm':
                return $this->check_gm($apostaJogo);
                break;
            case 'gmcasa':
                return $this->check_gmcasa($apostaJogo);
                break;
            case 'gmfora':
                return $this->check_gmfora($apostaJogo);
                break;
            case 'dplcasa':
                return $this->check_dplcasa($apostaJogo);
                break;
            case 'dplfora':
                return $this->check_dplfora($apostaJogo);
                break;
            case 'amb':
                return $this->check_amb($apostaJogo);
                break;
            case 'namb':
                return $this->check_namb($apostaJogo);
                break;
            case 'mais2gm':
                return $this->check_mais2gm($apostaJogo);
                break;
            case 'menos2gm':
                return $this->check_menos2gm($apostaJogo);
                break;
            case 'cm':
                return $this->check_cm($apostaJogo);
                break;
            case 'fm':
                return $this->check_fm($apostaJogo);
                break;
            case 'pcerto':
                return $this->check_pcerto($apostaJogo);
                break;
            case 'penalty':
                return $this->check_penalty($apostaJogo);
                break;
            case 'placarzerado':
                return $this->check_placarzerado($apostaJogo);
                break;
            case 'umfaz':
                return $this->check_umfaz($apostaJogo);
                break;
            default:
                error_log("{$apostaJogo->getTipo()}: Tipo de jogo inválido.");
                return false;
        }
    }

    private function check_casa(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeCasaPlacar() > $jogo->getTimeForaPlacar();
    }

    private function check_empate(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeCasaPlacar() == $jogo->getTimeForaPlacar();
    }

    private function check_fora(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeCasaPlacar() < $jogo->getTimeForaPlacar();
    }

    private function check_gm(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return false;
    }

    private function check_gmcasa(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeCasaPlacar() - $jogo->getTimeForaPlacar()) >= 2;
    }

    private function check_gmfora(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeForaPlacar() - $jogo->getTimeCasaPlacar()) >= 2;
    }

    private function check_dplcasa(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeCasaPlacar() >= $jogo->getTimeForaPlacar();
    }

    private function check_dplfora(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeForaPlacar() >= $jogo->getTimeCasaPlacar();
    }

    private function check_amb(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeCasaPlacar() > 0 and $jogo->getTimeForaPlacar() > 0);
    }

    private function check_namb(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeCasaPlacar() == 0 or $jogo->getTimeForaPlacar() == 0);
    }

    private function check_mais2gm(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeCasaPlacar() + $jogo->getTimeForaPlacar()) >= 3;
    }

    private function check_menos2gm(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeForaPlacar() + $jogo->getTimeCasaPlacar()) <= 2;
    }

    private function check_cm(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeCasaPlacar() > 0 and $jogo->getTimeForaPlacar() == 0);
    }

    private function check_fm(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return ($jogo->getTimeForaPlacar() > 0 and $jogo->getTimeCasaPlacar() == 0);
    }

    private function check_pcerto(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        $casa = $jogo->getTimeCasaPlacar() == $apostaJogo->getCasa();
        $fora = $jogo->getTimeForaPlacar() == $apostaJogo->getFora();
        return ($casa and $fora);
    }

    private function check_penalty()
    {
        return false;
    }

    private function check_placarzerado(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        return $jogo->getTimeCasaPlacar() == 0 and $jogo->getTimeForaPlacar() == 0;
    }

    private function check_umfaz(ApostaJogoVO $apostaJogo)
    {
        $jogo = $apostaJogo->voJogo();
        $total = $jogo->getTimeCasaPlacar() + $jogo->getTimeForaPlacar();
        $zerado = ($jogo->getTimeCasaPlacar() == 0 or $jogo->getTimeForaPlacar() == 0);
        return ($total > 0 and $zerado);
    }

}
    