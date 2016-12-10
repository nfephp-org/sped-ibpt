<?php

namespace NFePHP\Ibpt\Tests;

use NFePHP\Ibpt\Ibpt;

class IbptTest extends \PHPUnit_Framework_TestCase
{
    public $ibpt;
    public $dummyRest;
    public $expected = [
        'Codigo]' => 60063110,
        'UF' => 'MG',
        'EX' => 0,
        'Descricao' => 'Tecidos de malha de fibras sinteticas, crus ou branqueados, de náilon ou de outras poliamidas',
        'Nacional' => 13.45,
        'Estadual' => 18,
        'Importado' => 19.72,
        'Municipal' => 0,
        'Tipo' => 0,
        'VigenciaInicio' => '26/10/2016',
        'VigenciaFim' => '31/12/2016',
        'Chave' => 'E13pH1',
        'Versao' => '16.2.B',
        'Fonte' => 'IBPT'
    ];
    
    
    public function setUp()
    {
        $this->dummyRest = $this->getMockBuilder('\NFePHP\Ibpt\RestInterface')
            ->setMethods(['pull'])    
            ->getMock();
        
        $this->dummyRest->method('pull')->willReturn(json_encode($this->expected));
                
        $this->ibpt = new Ibpt('12345678901234', 'a5354bf3890s0849', [], $this->dummyRest);
    }
    
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(Ibpt::class, $this->ibpt);
    }
    
    public function testProductTaxes()
    {
       $expected = json_decode(json_encode($this->expected)); 
       $resp = $this->ibpt->productTaxes('MG', 60063110);
       $this->assertEquals($expected, $resp);
    }
    
    public function testServiceTaxes()
    {
       $expected = json_decode(json_encode($this->expected)); 
       $resp = $this->ibpt->serviceTaxes('MG', 60063110);
       $this->assertEquals($expected, $resp);
    }

}
