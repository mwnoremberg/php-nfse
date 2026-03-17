<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class ConsultarRPS extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $IM,
        $rps
    ) {
        $xsd = 'nfse';
        $method = "ConsultarNfseRpsEnvio";
        $content = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $content .= "<IdentificacaoRps>";
        $content .= "<Numero>$rps</Numero>";
        $content .= "<Serie>NFSe</Serie>";
        $content .= "<Tipo>1</Tipo>";
        $content .= "</IdentificacaoRps>";
        $content .= "<Prestador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>$CNPJ</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>$IM</InscricaoMunicipal>";
        $content .= "</Prestador>";
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
