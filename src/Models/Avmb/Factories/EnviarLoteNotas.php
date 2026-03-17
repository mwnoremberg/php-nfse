<?php

namespace NFePHP\NFSe\Models\Avmb\Factories;

use NFePHP\NFSe\Models\Avmb\Factories\Factory;
use NFePHP\NFSe\Models\Avmb\RenderRPS;

class EnviarLoteNotas extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $inscMuni,
        $numLote,
        $rpss
    ) {
        $xsd = 'nfse';
        $content ='';
        $method = "Rps";
        $content.='<EnviarLoteRpsEnvio xmlns:ns="http://www.w3.org/2000/09/xmldsig#" xmlns="http://www.abrasf.org.br/nfse.xsd">';
        $content.=  '<LoteRps Id="1" versao="2.02">';
        $content.=    '<NumeroLote>'.$numLote.'</NumeroLote>';
        $content.=    '<CpfCnpj>';
        $content.=      '<Cnpj>'.$CNPJ.'</Cnpj>';
        $content.=    '</CpfCnpj>';
        $content.=    '<InscricaoMunicipal>'.$inscMuni.'</InscricaoMunicipal>';
        $content.=    '<QuantidadeRps>'.count($rpss).'</QuantidadeRps>';
        $content.=    '<ListaRps>';

         //    $content .= "<CNPJ>$CNPJ</CNPJ>";
         //    $content .= "<dhTrans>$dhTrans</dhTrans>";
         foreach ($rpss as $rps) {
            $contentt="<Rps>";
            $contenttt = RenderRPS::toXml($rps, $this->algorithm);
            $contentt.=$contenttt;
            $contentt.="</Rps>";
            $contentt = \NFePHP\NFSe\Common\Signer::sign(
                $this->certificate,
                $contentt,
                'Rps',
                '',
                $this->algorithm,
                [false,false,null,null]
            );
            $contentt=str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$contentt);
             $content .=$contentt;

         }
         $content .= '</ListaRps>';
         $content.=  '</LoteRps>';
         $content.=  '</EnviarLoteRpsEnvio>';

        $content = \NFePHP\Common\Strings::clearXmlString($content);
        //dd($content);
        $body = \NFePHP\NFSe\Common\Signer::sign(
            $this->certificate,
            $content,
            'EnviarLoteRpsEnvio',
            '',
            $this->algorithm,
            [false,false,null,null]
        );
        // dd($body);

        // $body = $this->clear($body);
        //error_log(print_r($body, TRUE) . PHP_EOL, 3, '/var/www/tests/sped-nfse/post.xml');
        // dd($body);
        $this->validar($versao, $body, 'Avmb', $xsd, '');
        return $body;
    }
}
