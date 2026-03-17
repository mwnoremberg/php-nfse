<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;

class CancelarNfse extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $inscMuni,
        $codMuni,
        $numeroNFSe,
        $motivo
    ) {
        $xsd = 'nfse';
        $method = "CancelarNfseEnvio";
        $content  = "<Pedido>";
        $content .= "<InfPedidoCancelamento Id=\"1\">";
        $content .= "<IdentificacaoNfse>";
        $content .= "<Numero>$numeroNFSe</Numero>";
        $content .= "<CpfCnpj>";
        $content .= "<Cnpj>$CNPJ</Cnpj>";
        $content .= "</CpfCnpj>";
        $content .= "<InscricaoMunicipal>$inscMuni</InscricaoMunicipal>";
        $content .= "<CodigoMunicipio>$codMuni</CodigoMunicipio>";
        $content .= "</IdentificacaoNfse>";
        $content .= "<CodigoCancelamento>$motivo</CodigoCancelamento>";
        $content .= "</InfPedidoCancelamento>";
        $content .= "</Pedido>";

        $body = \NFePHP\NFSe\Common\Signer::sign(
            $this->certificate,
            $content,
            'Pedido',
            '',
            $this->algorithm,
            [false,false,null,null]
        );
        $body=str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$body);
        $body = \NFePHP\Common\Strings::clearXmlString($body);
        $body = "<$method xmlns:ns=\"http://www.w3.org/2000/09/xmldsig#\" xmlns=\"http://www.abrasf.org.br/nfse.xsd\">".$body."</$method>";
        $this->validar($versao, $body, 'Avmb', $xsd, '');
        return $body;
    }
}
