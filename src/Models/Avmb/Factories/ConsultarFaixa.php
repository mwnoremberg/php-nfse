<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class ConsultarFaixa extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $IM,
        $token,
        $inicio,
        $fim,
        $pagina=1
    ) {
        $xsd = 'nfse';
        $method = "ConsultarNfseFaixaEnvio";
        $content = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">";
        $content .= "<Prestador>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>$CNPJ</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>$IM</InscricaoMunicipal>";
        $content .= "<Token>$token</Token>";
        $content .= "</Prestador>";
        $content .= "<Faixa>";
        $content .= "<NumeroNfseInicial>$inicio</NumeroNfseInicial>";
        $content .= "<NumeroNfseFinal>$fim</NumeroNfseFinal>";
        $content .= "</Faixa>";
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
