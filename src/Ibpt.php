<?php

namespace NFePHP\Ibpt;

/**
 * Class to get taxes informations for consumers from IBPT
 *
 * @category  NFePHP
 * @package   NFePHP\Ibpt\Ibpt
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */
use NFePHP\Ibpt\RestInterface;
use NFePHP\Ibpt\Rest;

class Ibpt
{
    public $url = 'https://apidoni.ibpt.org.br/api/v1/';
    public $cnpj;
    public $token;
    public $rest;

    /**
     * Constructor
     * @codeCoverageIgnore
     * @param string $cnpj
     * @param string $token
     * @param array $proxy
     * @param RestInterface $rest
     */
    public function __construct(
        $cnpj,
        $token,
        $proxy = [],
        RestInterface $rest = null
    ) {
        $this->cnpj = $cnpj;
        $this->token = $token;
        $this->rest = $rest;
        if (empty($rest)) {
            $this->rest = new Rest($proxy);
        }
    }

    /**
     * Get informations about produtcts taxes from IBPT restful service
     * @param string $uf state abbreviation
     * @param string $ncm
     * @param int $extarif
     * @param string $descricao
     * @param string $unidadeMedida
     * @param number $valor
     * @param string $gtin
     * @param string $codigoInterno
     * @return \stdClass
     * @throws \Exception
     */
    public function productTaxes(
        $uf,
        $ncm,
        $extarif,
        $descricao,
        $unidadeMedida,
        $valor,
        $gtin,
        $codigoInterno = ''
    ) {
        $uri = $this->url
            . "produtos?token=" . $this->token
            . "&cnpj=" . $this->cnpj
            . "&codigo=$ncm"
            . "&uf=$uf"
            . "&ex=$extarif";
        
          $uri .= !empty($codigoInterno) ? "&codigoInterno=" . rawurlencode($codigoInterno) : "";
          $uri .= '&descricao=' . rawurlencode($descricao);
          $uri .= '&unidadeMedida=' . rawurlencode($unidadeMedida);
          $uri .= "&valor=$valor";
          $uri .= '&gtin=' . rawurlencode($gtin);
        return json_decode($this->rest->pull($uri));
    }

    /**
     * Get informations about services taxes from IBPT restful service
     * @param string $uf
     * @param string $codigo
     * @param string $descricao
     * @param string $unidadeMedida
     * @param number $valor
     * @return \stdClass
     */
    public function serviceTaxes(
        $uf,
        $codigo,
        $descricao,
        $unidadeMedida,
        $valor
    ) {
        $uri = $this->url
            . "servicos?token="
            . $this->token
            . "&cnpj="
            . $this->cnpj
            . "&codigo=$codigo"
            . "&uf=$uf";
        $uri .= "&descricao=" . rawurlencode($descricao);
        $uri .= "&unidadeMedida=" . rawurlencode($unidadeMedida);
        $uri .= "&valor=$valor";
        return json_decode($this->rest->pull($uri));
    }
}
