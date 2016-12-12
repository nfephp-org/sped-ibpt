<?php

namespace NFePHP\Ibpt\Tests;

use NFePHP\Ibpt\HttpCode;

class HttpCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testInfo()
    {
        $resp = HttpCode::info(100);
        $expected = "Informational";
        $this->assertEquals($expected, $resp['level']);
    }
}
