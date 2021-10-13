<?php

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 * @package   NFePHP\Ibpt\Ibpt
 * @copyright 2016 NFePHP Copyright (c)
 * @license   https://opensource.org/licenses/MIT MIT
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 * @link      http://github.com/nfephp-org/sped-ibpt
 */

namespace NFePHP\Ibpt;

use NFePHP\Ibpt\RestInterface;
use NFePHP\Ibpt\Rest;

/**
 * Class to get taxes informations for consumers from IBPT
 *
 * @category  Library
 * @package   NFePHP\Ibpt\Ibpt
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 * @copyright 2016 NFePHP Copyright (c)
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibpt
 */
class Ibpt
{
    /**
     * URL
     *
     * @var string
     */
    protected $url = 'https://apidoni.ibpt.org.br/api/v1/';
    /**
     * CNPJ do autorizado a fazer a cunsulta no IBPT
     *
     * @var string
     */
    private $cnpj;
    /**
     * Token do IBPT
     *
     * @var string
     */
    private $token;
    /**
     * Classe Rest Client
     *
     * @var object|null
     */
    protected $rest;

    /**
     * Constructor
     *
     * @param string $cnpj  cnpj do autorizado
     * @param string $token token do autorizado
     * @param array $proxy dados para proxy
     * @param object|null $rest interface
     */
    public function __construct(
        $cnpj,
        $token,
        $proxy = [],
        $rest = null
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
     *
     * @param string $uf sigla do estado
     * @param string $ncm numero do ncm
     * @param int    $extarif numero do ex tarifario
     * @param string $descricao descrição
     * @param string $unidadeMedida unidade de medida
     * @param number $valor valor
     * @param string $gtin codigo gtin
     * @param string $codigoInterno codigo interno
     *
     * @return \stdClass
     *
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
     *
     * @param string $uf uf
     * @param string $codigo codigo do serviço
     * @param string $descricao descricao
     * @param string $unidadeMedida unidade de medida
     * @param number $valor valor
     *
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
