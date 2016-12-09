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

    protected $url = 'http://iws.ibpt.org.br/';
    protected $cnpj;
    protected $token;
    protected $rest;

    /**
     * Constructor
     * @param string $cnpj
     * @param string $token
     * @param array $proxy
     * @param RestInterface $rest
     */
    public function __construct($cnpj, $token, $proxy = [], RestInterface $rest = null)
    {
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
     * @param string $ncm Mercosur Common Nomenclature
     * @param int $extarif
     * @return \stdClass
     */
    public function productTaxes($uf, $ncm, $extarif = 0)
    {
        $uri = $this->url
                . "api/Produtos?token="
                . $this->token
                . "&cnpj="
                . $this->cnpj
                . "&codigo=$ncm&uf=$uf&ex=$extarif";

        return $this->rest->pull($uri);
    }

    /**
     * Get informations about services taxes from IBPT restful service
     * @param string $uf state abbreviation
     * @param string $code Código da NBS ou da LC116 do serviço
     * @return \stdClass
     */
    public function servicesTaxes($uf, $code)
    {
        $uri = $this->url
                . "api/Servicos?token="
                . $this->token
                . "&cnpj="
                . $this->cnpj
                . "&codigo=$code&uf=$uf";

        return $this->rest->pull($uri);
    }
}
