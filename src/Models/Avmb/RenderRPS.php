<?php
namespace NFePHP\NFSe\Models\Avmb;

/**
 * Classe para a renderização dos RPS em XML
 * conforme o modelo ISSNET
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Models\Infisc\RenderRPS
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */
use NFePHP\NFSe\Common\DOMImproved as Dom;
use NFePHP\NFSe\Models\Avmb\Rps;
use NFePHP\Common\Certificate;

class RenderRPS
{

    /**
     * @var DOMImproved
     */
    protected static $dom;

    /**
     * @var Certificate
     */
    protected static $certificate;

    /**
     * @var int
     */
    protected static $algorithm;

    public static function toXml($data, $algorithm = OPENSSL_ALGO_SHA1)
    {
        self::$algorithm = $algorithm;
        $xml = '';
        if (is_object($data)) {
            return self::render($data);
        } elseif (is_array($data)) {
            foreach ($data as $rps) {
                $xml .= self::render($rps);
            }
        }
        return $xml;
    }

    /**
     * Monta o xml com base no objeto Rps
     * @param Rps $rps
     * @return string
     */
    private static function render(Rps $rps)
    {
        self::$dom = new Dom('1.0', 'utf-8');

        $InfDeclaracaoPrestacaoServico = self::$dom->createElement('InfDeclaracaoPrestacaoServico');
        $InfDeclaracaoPrestacaoServico->setAttribute("Id", "");

        if($rps->usarRps){
          $Rps = self::$dom->createElement('Rps');
          $Rps->setAttribute("Id", "1");
          $IdentificacaoRps = self::$dom->createElement('IdentificacaoRps');
          self::$dom->addChild(
              $IdentificacaoRps,
              'Numero',
              $rps->numero,
              true,
              "Numero do RPS",
              true
          );
          self::$dom->addChild(
              $IdentificacaoRps,
              'Serie',
              $rps->serie,
              true,
              "Série do RPS",
              true
          );
          self::$dom->addChild(
              $IdentificacaoRps,
              'Tipo',
              $rps->tipo,
              true,
              "Tipo do NFSe",
              true
          );
          self::$dom->appChild($Rps, $IdentificacaoRps, 'Adiciona tag IdentificacaoRPS ao RPS');

          self::$dom->addChild(
              $Rps,
              'DataEmissao',
              $rps->dataEmissao,
              true,
              "Adiciona Data de emissao da NFSe ao RPS",
              true
          );
          self::$dom->addChild(
              $Rps,
              'Status',
              $rps->status,
              true,
              "Adiciona Status da NFSe ao RPS",
              true
          );

          if(isset($rps->RpsSubstituido)){
            $RpsSubstituido = self::$dom->createElement('RpsSubstituido');
            self::$dom->addChild(
                $RpsSubstituido,
                'Numero',
                $rps->RpsSubstituido->Numero,
                true,
                "Numero do RPS substituído",
                true
            );
            self::$dom->addChild(
                $RpsSubstituido,
                'Serie',
                $rps->RpsSubstituido->serie,
                true,
                "Série do RPS",
                true
            );
            self::$dom->addChild(
                $RpsSubstituido,
                'Tipo',
                $rps->RpsSubstituido->tpNF,
                true,
                "Tipo do NFSe",
                true
            );
            self::$dom->appChild($Rps, $RpsSubstituido, 'Adicionando tag RpsSubstituido ao RPS');
          }
          self::$dom->appChild($InfDeclaracaoPrestacaoServico, $Rps, 'Adicionando tag RPS ao InfDeclaracaoPrestacaoServico');
        }

        self::$dom->addChild(
            $InfDeclaracaoPrestacaoServico,
            'Competencia',
            $rps->dataCompetencia,
            true,
            "Adiciona Competencia da NFSe a InfDeclaracaoPrestacaoServico",
            true
        );

        $Servico = self::$dom->createElement('Servico');

        $Valores = self::$dom->createElement('Valores');
        self::$dom->addChild(
            $Valores,
            'ValorServicos',
            $rps->servico->valorServico,
            true,
            "ValorServicos da NFSe",
            true
        );
        if($rps->servico->valorDeducoes>0){
          self::$dom->addChild(
              $Valores,
              'ValorDeducoes',
              $rps->servico->valorDeducoes,
              true,
              "ValorDeducoes da NFSe",
              true
          );
        }

        if($rps->servico->valorPis>0){
          self::$dom->addChild(
              $Valores,
              'ValorPis',
              $rps->servico->valorPis,
              true,
              "ValorPis da NFSe",
              true
          );
        }

        if($rps->servico->valorCOFINS>0){
          self::$dom->addChild(
              $Valores,
              'ValorCofins',
              $rps->servico->valorCOFINS,
              true,
              "ValorCofins da NFSe",
              true
          );
        }
        if($rps->servico->valorINSS>0){
          self::$dom->addChild(
              $Valores,
              'ValorInss',
              $rps->servico->valorINSS,
              true,
              "ValorInss da NFSe",
              true
          );
        }
        if($rps->servico->valorIR>0){
          self::$dom->addChild(
              $Valores,
              'ValorIr',
              $rps->servico->valorIR,
              true,
              "ValorIr da NFSe",
              true
          );
        }
        if($rps->servico->valorCSLL>0){
          self::$dom->addChild(
              $Valores,
              'ValorCsll',
              $rps->servico->valorCSLL,
              true,
              "ValorCsll da NFSe",
              true
          );
        }
        if($rps->servico->outrasRetencoes>0){
          self::$dom->addChild(
              $Valores,
              'OutrasRetencoes',
              $rps->servico->outrasRetencoes,
              true,
              "OutrasRetencoes da NFSe",
              true
          );
        }

        if($rps->prestador->endereco->codigoMunicipio!=$rps->servico->localTributacao){
          if($rps->servico->valorISS>0){
            self::$dom->addChild(
                $Valores,
                'ValorIss',
                $rps->servico->valorISS,
                true,
                "ValorIss da NFSe",
                true
            );
          }

          if($rps->servico->valorPis>0){
            self::$dom->addChild(
                $Valores,
                'Aliquota',
                $rps->servico->aliquota,
                true,
                "Aliquota da NFSe",
                true
            );
          }
        }

        if($rps->servico->descontoIncondicionado>0){
          self::$dom->addChild(
              $Valores,
              'DescontoIncondicionado',
              $rps->servico->descontoIncondicionado,
              true,
              "DescontoIncondicionado da NFSe",
              true
          );
        }
        if($rps->servico->descontoCondicionado>0){
          self::$dom->addChild(
              $Valores,
              'DescontoCondicionado',
              $rps->servico->descontoCondicionado,
              true,
              "DescontoCondicionado da NFSe",
              true
          );
        }
        self::$dom->appChild($Servico, $Valores, 'Adiciona tag Valores ao Servico');

        self::$dom->addChild(
            $Servico,
            'IssRetido',
            $rps->servico->ISSRetido,
            true,
            "IssRetido da NFSe SIM OU NAO",
            true
        );
        self::$dom->addChild(
            $Servico,
            'ResponsavelRetencao',
            $rps->servico->responsavelRetencao,
            true,
            "Responsavel pela Retencao da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'ItemListaServico',
            $rps->servico->codigo,
            true,
            "ItemListaServico da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'CodigoCnae',
            $rps->servico->CNAE,
            true,
            "CodigoCnae da NFSe",
            true
        );
        if($rps->servico->codigoTributacaoMunicípio){
          self::$dom->addChild(
              $Servico,
              'CodigoTributacaoMunicipio',
              $rps->servico->codigoTributacaoMunicípio,
              true,
              "CodigoTributacaoMunicipio da NFSe",
              true
          );
        }
        self::$dom->addChild(
            $Servico,
            'Discriminacao',
            $rps->servico->discriminacao,
            true,
            "Discriminacao da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'CodigoMunicipio',
            $rps->prestador->endereco->codigoMunicipio,
            true,
            "CodigoMunicipio da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'CodigoPais',
            $rps->prestador->endereco->codigoPais,
            true,
            "CodigoPais da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'ExigibilidadeISS',
            $rps->servico->exigibilidadeISS,
            true,
            "ExigibilidadeISS da NFSe",
            true
        );
        self::$dom->addChild(
            $Servico,
            'MunicipioIncidencia',
            $rps->servico->localTributacao,
            true,
            "MunicipioIncidencia da NFSe",
            true
        );

        // self::$dom->addChild(
        //     $servico,
        //     'NumeroProcesso',
        //     '1',
        //     true,
        //     "NumeroProcesso da NFSe",
        //     true
        // );
        self::$dom->appChild($InfDeclaracaoPrestacaoServico, $Servico, 'Adiciona tag Servico ao InfDeclaracaoPrestacaoServico');
        $Prestador = self::$dom->createElement('Prestador');
        $CpfCnpj = self::$dom->createElement('CpfCnpj');
        self::$dom->addChild(
            $CpfCnpj,
            'Cnpj',
            $rps->prestador->CNPJ,
            true,
            "Cnpj Prestador da NFSe",
            true
        );
        self::$dom->appChild($Prestador, $CpfCnpj, 'Adiciona tag CpfCnpj ao Prestador');

        self::$dom->addChild(
            $Prestador,
            'InscricaoMunicipal',
            $rps->prestador->IM,
            true,
            "IM do Prestador da NFSe",
            true
        );
        
        if($rps->prestador->token){
          self::$dom->addChild(
              $Prestador,
              'Token',
              $rps->prestador->token,
              true,
              "Token do prestador",
              true
          );
        }
        self::$dom->appChild($InfDeclaracaoPrestacaoServico, $Prestador, 'Adicionando tag prestador ao InfDeclaracaoPrestacaoServico');

        if($rps->tomador){
          $Tomador = self::$dom->createElement('Tomador');
          $IdentificacaoTomador = self::$dom->createElement('IdentificacaoTomador');
          $CpfCnpjTomador = self::$dom->createElement('CpfCnpj');

          self::$dom->appChild($IdentificacaoTomador, $CpfCnpjTomador, 'Adiciona tag CpfCnpjTomador ao IdentificacaoTomador');

          if(isset($rps->tomador->CNPJ)){
            self::$dom->addChild(
                $CpfCnpjTomador,
                'Cnpj',
                $rps->tomador->CNPJ,
                true,
                "CNPJ do Tomador da NFSe",
                true
            );

            if (!empty($rps->tomador->IM)) {
                self::$dom->addChild(
                    $IdentificacaoTomador,
                    'InscricaoMunicipal',
                    $rps->tomador->IM,
                    true,
                    "IM do Tomador da NFSe",
                    true
                );
            }
          }
          elseif(isset($rps->tomador->CPF)){
            self::$dom->addChild(
                $CpfCnpjTomador,
                'Cpf',
                $rps->tomador->CPF,
                true,
                "CPF do Tomador da NFSe",
                true
            );
          }

          self::$dom->appChild($Tomador, $IdentificacaoTomador, 'Adiciona tag IdentificacaoTomador ao tomador');

          self::$dom->addChild(
              $Tomador,
              'RazaoSocial',
              $rps->tomador->nome,
              true,
              "Nome do Tomador da NFSe",
              true
          );

          $EnderecoTomador = self::$dom->createElement('Endereco');
          self::$dom->addChild(
              $EnderecoTomador,
              'Endereco',
              $rps->tomador->endereco->logradouro,
              true,
              "Endereco do Tomador da NFSe",
              true
          );
          self::$dom->addChild(
              $EnderecoTomador,
              'Numero',
              $rps->tomador->endereco->numero,
              true,
              "Numero do Tomador da NFSe",
              true
          );
          if($rps->tomador->endereco->complemento){
            self::$dom->addChild(
                $EnderecoTomador,
                'Complemento',
                $rps->tomador->endereco->complemento,
                true,
                "Complemento do Tomador da NFSe",
                true
            );
          }
          self::$dom->addChild(
              $EnderecoTomador,
              'Bairro',
              $rps->tomador->endereco->bairro,
              true,
              "Bairro do Tomador da NFSe",
              true
          );
          
          if ($rps->tomador->endereco->codigoMunicipio) {
            self::$dom->addChild(
                $EnderecoTomador,
                'CodigoMunicipio',
                $rps->tomador->endereco->codigoMunicipio,
                true,
                "CodigoMunicipio do Tomador da NFSe",
                true
            );
          }
          self::$dom->addChild(
              $EnderecoTomador,
              'Uf',
              $rps->tomador->endereco->UF,
              true,
              "Uf do Tomador da NFSe",
              true
          );
          self::$dom->addChild(
              $EnderecoTomador,
              'CodigoPais',
              $rps->tomador->endereco->codigoPais,
              true,
              "CodigoPais do Tomador da NFSe",
              true
          );
          self::$dom->addChild(
              $EnderecoTomador,
              'Cep',
              $rps->tomador->endereco->CEP,
              true,
              "Cep do Tomador da NFSe",
              true
          );

          self::$dom->appChild($Tomador, $EnderecoTomador, 'Adicionando tag EnderecoTomador ao tomador');

          $contatoTomador = self::$dom->createElement('Contato');

          self::$dom->addChild(
              $contatoTomador,
              'Telefone',
              $rps->tomador->contato->telefone,
              true,
              "Telefone do Tomador da NFSe",
              true
          );
          self::$dom->addChild(
              $contatoTomador,
              'Email',
              $rps->tomador->contato->email,
              true,
              "Email do Tomador da NFSe",
              true
          );

          self::$dom->appChild($Tomador, $contatoTomador, 'Adicionando tag contatoTomador ao tomador');

          self::$dom->appChild($InfDeclaracaoPrestacaoServico, $Tomador, 'Adicionando tag tomador ao InfDeclaracaoPrestacaoServico');
        }
        self::$dom->addChild(
            $InfDeclaracaoPrestacaoServico,
            'RegimeEspecialTributacao',
            $rps->prestador->regimeTributacao,
            true,
            "RegimeEspecialTributacao da NFSe",
            true
        );
        self::$dom->addChild(
            $InfDeclaracaoPrestacaoServico,
            'OptanteSimplesNacional',
            $rps->prestador->optanteSimplesNacional,
            true,
            "OptanteSimplesNacional da NFSe",
            true
        );
        self::$dom->addChild(
            $InfDeclaracaoPrestacaoServico,
            'IncentivoFiscal',
            $rps->prestador->incentivoFiscal,
            true,
            "IncentivoFiscal da NFSe",
            true
        );

        self::$dom->appendChild($InfDeclaracaoPrestacaoServico);
        $xml = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', self::$dom->saveXML());
        // $xml = self::$dom->saveXML();
        $xml = str_replace("\n","",$xml);

        return $xml;
    }
}
