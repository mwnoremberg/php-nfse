<?php

namespace NFePHP\NFSe\Models\Avmb;

/**
 * Classe a montagem do RPS para a Cidade de São Paulo
 * conforme o modelo Infisc
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Models\Infisc\Rps
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use InvalidArgumentException;
use NFePHP\Common\Strings;
use NFePHP\NFSe\Common\Rps as RpsBase;

class Rps extends RpsBase
{
  const TIPO_RPS = 1;
  const TIPO_MISTO = 2;
  const TIPO_CUPOM = 3;
  const CPF = 1;
  const CNPJ = 2;
  const STATUS_NORMAL = 1;
  const STATUS_CANCELADO = 2;
  const RESPONSAVEL_TOMADOR = 1;
  const RESPONSAVEL_INTERMEDIARIO = 2;
  const REGIME_MICROEMPRESA = 1; // Microempresa municipal
  const REGIME_ESTIMATIVA = 2; // Estimativa
  const REGIME_SOCIEDADE = 3; // Sociedade de profissionais
  const REGIME_COOPERATIVA = 4; // Cooperativa
  const REGIME_MEI = 5; // Microempresário Individual (MEI)
  const REGIME_ME_EPP = 6; //Microempresário e Empresa de Pequeno Porte
  const NATUREZA_EXIGIVEL = 1; // Exigível
  const NATUREZA_NAO_INCIDE = 2;  // Nãp incidência
  const NATUREZA_ISENTA = 3; // Isenção
  const NATUREZA_EXPORTACAO = 4; // Exportação
  const NATUREZA_IMUNE = 5; // Imune
  const NATUREZA_SUSPENSA_JUS = 6; // Exigibilidade suspensa por decisão judicial
  const NATUREZA_SUSPENSA_ADMIN = 7; // Exigibilidade suspensa por procedimento administrativo
  const SITUACAO_NAO_RECEBIDO = 1; // Não recebido
  const SITUACAO_NAO_PROCESSADO = 2; // Não processado
  const SITUACAO_COM_ERRO = 3; // Processado com erro
  const SITUACAO_PROCESSADO = 4; // Processado com Sucesso
  const CANCELAMENTO_ERRO_EMISSAO = 1;
  const CANCELAMENTO_SERVICO_NAO_PRESTADO = 2;
  const CANCELAMENTO_DUPLICIDADE = 4;
  const SIM = 1;
  const NAO = 2;

  public $numero;
  public $serie;
  public $tipo;
  public $status;
  public $dataEmissao;
  public $dataCompetencia;
  public $prestador;
  public $tomador;
  public $servico;

  public static $motivos_cancelamento = [
    self::CANCELAMENTO_ERRO_EMISSAO => "Erro na emissão",
    self::CANCELAMENTO_SERVICO_NAO_PRESTADO => "Serviço não prestado",
    self::CANCELAMENTO_DUPLICIDADE => "Emitido em duplicidade"
  ];

  public static $motivos_substituicao = [
    self::CANCELAMENTO_ERRO_EMISSAO => "Erro na emissão",
    // self::CANCELAMENTO_SERVICO_NAO_PRESTADO => "Serviço não prestado",
    // self::CANCELAMENTO_DUPLICIDADE => "Emitido em duplicidade"
  ];

  public function setPrestador($prestador)
  {
    $this->prestador = $prestador;
  }

  public function setTomador($tomador)
  {
    $this->tomador = $tomador;
  }

  public function setServico($servico){
    $this->servico = $servico;
  }

}
