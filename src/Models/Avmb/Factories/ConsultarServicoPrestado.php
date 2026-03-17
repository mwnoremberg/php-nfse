<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class ConsultarServicoPrestado extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $IM,
        $numeronfse=null,
        $data_inicio=null,
        $data_fim=null,
        $pagina=1
    ) {
        $xsd = 'nfse';
        $method = "ConsultarNfseServicoPrestadoEnvio";
        $content = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $content .= "<Prestador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>$CNPJ</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>$IM</InscricaoMunicipal>";
        $content .= "</Prestador>";
        if($numeronfse){
          $content .= "<NumeroNfse>$numeronfse</NumeroNfse>";
        }
        if($data_inicio && $data_fim){
          $content .= "<PeriodoEmissao>";
          $content .= "<DataInicial>$data_inicio</DataInicial>";
          $content .= "<DataFinal>$data_fim</DataFinal>";
          $content .= "</PeriodoEmissao>";
        }
        $content .= "<Pagina>$pagina</Pagina>";
        $content .= "</$method>";

        $content = \NFePHP\Common\Strings::clearXmlString($content);
        // dd($content);
        // $body = \NFePHP\NFSe\Common\Signer::sign(
        //     $this->certificate,
        //     $content,
        //     $method,
        //     '',
        //     $this->algorithm,
        //     [false,false,null,null]
        // );
        $this->validar($versao, $content, 'Avmb', $xsd, '');

        return $content;
    }
}
