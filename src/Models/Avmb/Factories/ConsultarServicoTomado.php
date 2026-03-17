<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class ConsultarServicoTomado extends Factory
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
        $method = "ConsultarNfseServicoTomadoEnvio";
        $content = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $content .= "<Consulente>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>01629238000143</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>576461</InscricaoMunicipal>";
        $content .= "</Consulente>";
        if($numeronfse){
          $content .= "<NumeroNfse>$numeronfse</NumeroNfse>";
        }
        if($data_inicio && $data_fim){
          $content .= "<PeriodoEmissao>";
          $content .= "<DataInicial>$data_inicio</DataInicial>";
          $content .= "<DataFinal>$data_fim</DataFinal>";
          $content .= "</PeriodoEmissao>";
        }
        $content .= "<Prestador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>91557041000139</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>519071</InscricaoMunicipal>";
        $content .= "</Prestador>";
        $content .= "<Tomador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>01629238000143</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>576461</InscricaoMunicipal>";
        $content .= "</Tomador>";
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
