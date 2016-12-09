<?php

namespace NFePHP\Ibpt;

use NFePHP\Common\Soap\SoapCode;
use NFePHP\Ibpt\RestInterface;

class Rest implements RestInterface
{

    protected $proxy = [];

    /**
     * Constructor
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
        return json_decode($response);
    }

    /**
     * Set proxy parameters
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
