<?php

namespace NFePHP\Ibpt;

/**
 * Class to conect to restful services
 *
 * @category  NFePHP
 * @package   NFePHP\Ibpt\Rest
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\Common\Soap\SoapCode;
use NFePHP\Ibpt\RestInterface;

class Rest implements RestInterface
{

    protected $proxy = [];

    /**
     * Constructor
     * @codeCoverageIgnore
     * @param array $proxy Parameter for proxy ['IP','PORT','USER','PASS']
     */
    public function __construct($proxy = [])
    {
        if (!empty($proxy)) {
            $this->proxy = $proxy;
        }
    }

    /**
     * Pull data form IBPT Restful service to obtain taxes values
     * @codeCoverageIgnore
     * @param string $uri
     * @return \stdClass
     */
    public function pull($uri)
    {
        $oCurl = curl_init($uri);
        if (!empty($this->proxy)) {
            $oCurl = $this->setProxy($oCurl, $this->proxy);
        }
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 30);
        $response = curl_exec($oCurl);
        $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($oCurl);
        $ret['error'] = !empty(curl_error($oCurl)) ? curl_error($oCurl) : 'SUCESSO';
        $ret['response'] = $response;
        $ret['httpcode'] = $httpcode;
        curl_close($oCurl);
        if ($httpcode != 200) {
            $resp = SoapCode::info($httpcode);
            $ret = array_merge($ret, $resp);
            $response = json_encode($ret);
        }
        return $response;
    }

    /**
     * Set proxy parameters
     * @codeCoverageIgnore
     * @param object $oCurl
     * @param array $proxy
     * @return object
     */
    protected function setProxy($oCurl, $proxy)
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
