<?php

namespace NFePHP\NFSe\Models\Avmb;

/**
 * Classe para a comunicação com os webservices da
 * conforme o modelo ISSNET
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Models\Infisc\Tools
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use NFePHP\NFSe\Models\Avmb\Rps;
use NFePHP\NFSe\Models\Avmb\Factories;
use NFePHP\NFSe\Common\Tools as ToolsBase;
use NFePHP\Common\Soap\SoapCurl;

class Tools extends ToolsBase
{

     /**
     * Pedido de teste de envio de lote
     * @param array $rpss
     */
    public function envioLote(array $rpss)
    {
        // RecepcionarLoteRps
        $this->method = 'nfse:RecepcionarLoteRps';
        $fact = new Factories\EnviarLoteNotas($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->remetenteCNPJCPF,
            $this->remetenteIM,
            $this->numLote,
            $rpss
        );
        // dd($message);
        return $this->sendRequest('', $message);
    }

    public function envioLoteSincrono(array $rpss)
    {
        // RecepcionarLoteRps
        $this->method = 'nfse:RecepcionarLoteRpsSincrono';
        $fact = new Factories\EnviarLoteNotasSincrono($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $this->numLote,
            $rpss
        );
        // dd($message);
        return $this->sendRequest('', $message);
    }

    /**
    * Gera uma NFSe
    * @param NFePHP\NFSe\Models\Avmb\Rps $rps
    */
    public function geraNfse($rps)
    {
        $this->method = 'nfse:GerarNfse';
        $fact = new Factories\GerarNfse($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $rps
        );
        return $this->sendRequest('', $message);
    }

    public function substituirNfse($rps)
    {
        // RecepcionarLoteRps
        $this->method = 'nfse:SubstituirNfse';
        $fact = new Factories\SubstituirNfse($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->remetenteCNPJCPF,
            $this->remetenteIM,
            $this->config->token,
            $this->config->cmun,
            $rps
        );
        return $this->sendRequest('', $message);
    }

    /**
     * Consulta de um lote NFS-e
     *
     * Esse serviço permite que o contribuinte obtenha a crítica de um lote de NFS-e já enviado.
     *
     * @param type $protocolo Número do protocolo
     * @return type
     */
    public function consultaLote($protocolo)
    {
        $this->method = 'nfse:ConsultarLoteRps';
        $fact = new Factories\ConsultarLote($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $protocolo
        );
        return $this->sendRequest('', $message);
    }

    public function consultaFaixa($inicio,$fim,$pagina)
    {
        $this->method = 'nfse:ConsultarNfsePorFaixa';
        $fact = new Factories\ConsultarFaixa($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->remetenteCNPJCPF,
            $this->remetenteIM,
            $this->config->token,
            $inicio,
            $fim,
            $pagina
        );
        return $this->sendRequest('', $message);
    }

    public function consultaRPS($rps)
    {
        $this->method = 'nfse:ConsultarNfsePorRps';
        $fact = new Factories\ConsultarRPS($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $rps
        );
        return $this->sendRequest('', $message);
    }

    public function consultaServicoPrestado($numeronfse, $data_inicio, $data_fim, $pagina)
    {
        $this->method = 'nfse:ConsultarNfseServicoPrestado';
        $fact = new Factories\ConsultarServicoPrestado($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $numeronfse,
            $data_inicio,
            $data_fim,
            $pagina
        );
        return $this->sendRequest('', $message);
    }

    public function consultaServicoTomado($numeronfse, $data_inicio, $data_fim, $pagina)
    {
        $this->method = 'nfse:ConsultarNfseServicoTomado';
        $fact = new Factories\ConsultarServicoTomado($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $numeronfse,
            $data_inicio,
            $data_fim,
            $pagina
        );
        return $this->sendRequest('', $message);
    }

    /**
     * Esse serviço permite que o contribuinte solicite o cancelamento de uma NFS-e já submetida
     *
     * @param type $chave
     * @param type $motivo
     * @return type
     */
    public function cancelaNfse($numeroNFSe, $motivo)
    {
        $this->method = 'nfse:CancelarNfse';
        $fact = new Factories\CancelarNfse($this->certificate);
        $fact->setSignAlgorithm($this->algorithm);
        $message = $fact->render(
            $this->versao,
            $this->CNPJ,
            $this->inscMuni,
            $this->codMuni,
            $numeroNFSe,
            $motivo
        );
        return $this->sendRequest('', $message);
    }

    protected function sendRequest($url, $message)
    {

        $url = $this->url[$this->config->tpAmb];

        $this->soap = new SoapCurl($this->certificate);

        //formata o xml da mensagem para o padão esperado pelo webservice
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($message);
        $message = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="UTF-8"?>', $dom->saveXML());

        $messageText = $message;
        if ($this->withcdata) {
            $messageText = ($message);
        }
        $request = "<{$this->method} soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\" >"
        ."<parameters xsi:type=\"nfse:input\">
           <nfseCabecMsg xsi:type=\"xsd:string\"><cabecalho xmlns=\"http://www.abrasf.org.br/nfse.xsd\" xmlns:dsig=\"http://www.w3.org/2000/09/xmldsig#\" versao=\"2.02\">
           <versaoDados>2.02</versaoDados>
           </cabecalho></nfseCabecMsg>"
            . "<nfseDadosMsg xsi:type=\"xsd:string\">$messageText</nfseDadosMsg>"
            ."</parameters>"
            . "</{$this->method}>";
        $params = [
            'xml' => $message
        ];

        $action = "\"". $this->xmlns ."/". $this->method ."\"";

        $xml = \NFePHP\Common\Strings::clearXmlString($request);
        $request = preg_replace("/<\?xml.*\?>/", "", $xml);

        return $this->soap->send(
            $url,
            $this->method,
            $action,
            $this->soapversion,
            $params,
            $this->namespaces[$this->soapversion],
            $request
        );
    }
}
