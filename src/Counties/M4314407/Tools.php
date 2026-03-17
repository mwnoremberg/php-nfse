<?php

namespace NFePHP\NFSe\Counties\M4314407;

/**
 * Classe para a comunicação com os webservices da
 * Cidade de Cruz Alta RS
 * conforme o modelo ISSNET
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Counties\M4314407\Tools
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use NFePHP\NFSe\Models\Avmb\Tools as ToolsModel;

class Tools extends ToolsModel
{
    /**
     * Webservices URL
     * @var array
     */
    protected $url = [
        1 => 'https://ws.pelotas.rs.gov.br/wsnfse/NfseWSISAPI.dll/soap/INfse',
        2 => 'https://wshomo.pelotas.rs.gov.br/wsnfse/NfseWSISAPI.dll/soap/INfse'
    ];
    /**
     * County Namespace
     * @var string
     */
    protected $xmlns = 'http://nfse.abrasf.org.br/';

    /**
     * Soap Version
     * @var int
     */
    protected $soapversion = 1;
    /**
     * SIAFI County Cod
     * @var int
     */
    protected $codcidade = '4314407';
    /**
     * Indicates when use CDATA string on message
     * @var boolean
     */
    protected $withcdata = true;
    /**
     * Encription signature algorithm
     * @var string
     */
    protected $algorithm = OPENSSL_ALGO_SHA1;
    /**
     * Version of schemas
     * @var int
     */
    protected $versao = 1;
    /**
     * namespaces for soap envelope
     * @var array
     */
    protected $namespaces = [
        1 => [
            'xmlns:xsi'=>"http://www.w3.org/2001/XMLSchema-instance",
            'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema",
            'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/",
            'xmlns:nfse'=>"http://nfse.abrasf.org.br/"
        ],
        2  => [
            'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/"
        ]
    ];

    public $link_nfse = "https://pelotas.nfse.inf.br/?cod=";
    public $link_nfse_homo = "https://processoshmg.pelotas.rs.gov.br/?cod=";
    public $propertyToConcat = "autenticacao";
}
