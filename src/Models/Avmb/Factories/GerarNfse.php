<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

/**
 * Classe para a construção do XML relativo ao serviço de
 * Pedido de Envio de NFSe dos webservices da
 * Cidade de Caxias Do Sul Infisc
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Models\Infisc\Factories\EnvioRPS
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use NFePHP\NFSe\Models\Avmb\Rps;
use NFePHP\NFSe\Models\Avmb\Factories\Factory;
use NFePHP\NFSe\Models\Avmb\RenderRPS;

class GerarNfse extends Factory
{
    /**
     * Renderiza o pedido em seu respectivo xml e faz
     * a validação com o xsd
     * @param int $versao
     * @param int $remetenteTipoDoc
     * @param string $remetenteCNPJCPF
     * @param string $transacao
     * @param NFePHP\NFSe\Models\Avmb\Rps|array|null $data
     * @return string
     */
    public function render(
      $rps
    ) {
        $xsd = 'nfse';
        $method = "GerarNfseEnvio";
        $versao = "1";

        $content =  "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $xmlRPS = "<Rps>";
        $xmlRPS .= RenderRPS::toXml($rps, $this->algorithm);
        $xmlRPS .="</Rps>";

        $content = \NFePHP\Common\Strings::clearXmlString($content);
        $body = \NFePHP\NFSe\Models\Avmb\Factories\Signer::sign(
            $this->certificate,
            $xmlRPS,
            'Rps',
            '',
            $this->algorithm,
            [false,false,null,null]
        );
        $body = str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$body);
        $body = \NFePHP\Common\Strings::clearXmlString($body);
        $content .= $body;
        $content .= "</$method>";

        $content=str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$content);
        $this->validar($versao, $content, 'Avmb', $xsd, '');
        return $content;
    }

    /**
     * Processa quando temos apenas um RPS
     * @param NFePHP\NFSe\Models\Infisc\Rps $data
     * @return string
     */
    private function individual(Rps $data)
    {
        return RenderRPS::toXml($data, $this->certificate, $this->algorithm);
    }

    /**
     * Processa vários Rps dentro de um array
     * @param array $data
     * @return string
     */
    private function lote(array $data)
    {
        $xmlRPS = '';
        $this->totalizeRps($data);
        foreach ($data as $rps) {
            $xmlRPS .= RenderRPS::toXml($data, $this->certificate, $this->algorithm);
        }
        return $xmlRPS;
    }

    /**
     * Totaliza os campos necessários para a montagem do cabeçalho
     * quando envio de Lote de RPS
     * @param array $rpss
     */
    private function totalizeRps(array $rpss)
    {
        $this->valorTotalServicos = 0;
        $this->valorTotalDeducoes = 0;
        foreach ($rpss as $rps) {
            $this->valorTotalServicos += $rps->valorServicosRPS;
            $this->valorTotalDeducoes += $rps->valorDeducoesRPS;
            $this->qtdRPS++;
            if (is_null($this->dtIni)) {
                $this->dtIni = $rps->dtEmiRPS;
            }
            if (is_null($this->dtFim)) {
                $this->dtFim = $rps->dtEmiRPS;
            }
            if ($rps->dtEmiRPS <= $this->dtIni) {
                $this->dtIni = $rps->dtEmiRPS;
            }
            if ($rps->dtEmiRPS >= $this->dtFim) {
                $this->dtFim = $rps->dtEmiRPS;
            }
        }
    }
}
