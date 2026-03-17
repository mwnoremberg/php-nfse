<?php

namespace NFePHP\NFSe\Counties\M4314407;

/**
 * Classe a construção do xml da NFSe para a
 * Cidade de Cruz Alta RS
 * conforme o modelo ISSNET
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Counties\M4306106\Rps
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use NFePHP\NFSe\Models\Avmb\Rps as RpsModel;

class Rps extends RpsModel
{
  const PERMITE_CANCELAR = false;
  const PERMITE_SUBSTITUIR = true;
  const PERMITE_SUBSTITUIR_OUTRO_MES = false;
  const PERMITE_SUBSTITUIR_SUBSTITUTA = false;

  public function permiteCancelar(){
    return self::PERMITE_CANCELAR;
  }

  public function permiteSubstituir(){
    return self::PERMITE_SUBSTITUIR;
  }

  public function permiteSubstituirSubstituta(){
    return self::PERMITE_SUBSTITUIR_SUBSTITUTA;
  }

  public function permiteSubstituirOutroMes(){
    return self::PERMITE_SUBSTITUIR_SUBSTITUTA;
  }

}
