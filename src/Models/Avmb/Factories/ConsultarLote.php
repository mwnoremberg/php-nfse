<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class ConsultarLote extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $IM,
        $protocolo
    ) {
        $xsd = 'nfse';
        $method = "ConsultarLoteRpsEnvio";
        $content = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $content .= "<Prestador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>$CNPJ</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>$IM</InscricaoMunicipal>";
        $content .= "</Prestador>";
        $content .= "<Protocolo>$protocolo</Protocolo>";
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
