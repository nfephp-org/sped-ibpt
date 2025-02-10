<?php

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 * @package   NFePHP\Ibpt\Rest
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 * @copyright 2016 NFePHP Copyright (c)
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibpt
 */

namespace NFePHP\Ibpt;

use NFePHP\Ibpt\RestInterface;

/**
 * Class to conect to restful services
 *
 * @category  Library
 * @package   NFePHP\Ibpt\Rest
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 * @copyright 2016 NFePHP Copyright (c)
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibpt
 */
class Rest implements RestInterface
{
    /**
     * Parametros do proxy
     *
     * @var array
     */
    protected $proxy = [];

    /**
     * Timeout para requisição
     *
     * @var int
     */
    protected $timeout;

    /**
     * Constructor
     *
     * @param array $proxy Parameter for proxy ['IP','PORT','USER','PASS']
     * @param int $timeout Timeout for request
     */
    public function __construct($proxy = [], $timeout = 40)
    {
        if (!empty($proxy)) {
            $this->proxy = $proxy;
        }
        $this->timeout = $timeout;
    }

    /**
     * Pull data form IBPT Restful service to obtain taxes values
     *
     * @param string $uri
     *
     * @return string
     *
     * @throws \Exception
     */
    public function pull($uri)
    {
        $oCurl = curl_init($uri);
        if (!empty($this->proxy)) {
            $this->setProxy($oCurl, $this->proxy);
        }
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, $this->timeout + 20);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 0);
        $response = curl_exec($oCurl);
        $soaperror = curl_error($oCurl);
        $soaperror_code = curl_errno($oCurl);
        $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        $ret = [];
        $ret['error'] = !empty(curl_error($oCurl)) ? curl_error($oCurl) : 'SUCESSO';
        $ret['response'] = $response;
        $ret['httpcode'] = $httpcode;
        curl_close($oCurl);
        if (intval($soaperror_code) != 0) {
            throw new \Exception("Erro cURL [{$soaperror_code}] {$soaperror}");
        }
        if ($httpcode != 200) {
            $response = json_encode($ret);
        }
        return $response;
    }

    /**
     * Set proxy parameters
     *
     * @param resource $oCurl
     * @param array $proxy
     *
     * @return resource
     */
    protected function setProxy(&$oCurl, $proxy)
    {
        curl_setopt($oCurl, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($oCurl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($oCurl, CURLOPT_PROXY, $proxy['IP'] . ':' . $proxy['PORT']);
        if ($proxy['PASS'] != '') {
            curl_setopt($oCurl, CURLOPT_PROXYUSERPWD, $proxy['USER'] . ':' . $proxy['PASS']);
            curl_setopt($oCurl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        }
        return $oCurl;
    }
}
