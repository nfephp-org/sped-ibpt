<?php

namespace NFePHP\Ibpt\Tests;

use NFePHP\Ibpt\Ibpt;
use PHPUnit\Framework\TestCase;

class IbptTest extends TestCase
{
    public $ibpt;
    public $dummyRest;
    public $expectedProd = [
        'Codigo' => '60063210',
        'UF' => 'SP',
        'EX' => 0,
        'Descricao' => 'Tecidos de malha de fibras sinteticas, tintos, de náilon ou de outras poliamidas',
        'Nacional' => 13.45,
        'Estadual' => 18,
        'Importado' => 36.08,
        'Municipal' => 0,
        'Tipo' => 0,
        'VigenciaInicio' => '01/04/2018',
        'VigenciaFim' => '30/06/2018',
        'Chave' => 'F3W1D7',
        'Versao' => '18.1.B',
        'Fonte' => 'IBPT/empresometro.com.br',
        'Valor' => 60,
        'ValorTributoNacional' => 8.07,
        'ValorTributoEstadual' => 10.8,
        'ValorTributoImportado' => 21.65,
        'ValorTributoMunicipal' => 0
    ];
    
    public $expectedServ = [
        'Codigo' => '0107',
        'UF' => 'SP',
        'Descricao' => 'Suporte técnico em informática, inclusive instalação, '
        . 'configuração e manutenção de programas de computação e bancos de dados.',
        'Tipo' => 2,
        'Nacional' => 13.45,
        'Estadual' => 0,
        'Municipal' => 2.7,
        'Importado' => 15.45,
        'VigenciaInicio' => '01/04/2018',
        'VigenciaFim' => '30/06/2018',
        'Chave' => 'F3W1D7',
        'Versao' => '18.1.B',
        'Fonte' => 'IBPT/empresometro.com.br',
        'Valor' => 500,
        'ValorTributoNacional' => 67.25,
        'ValorTributoEstadual' => 0,
        'ValorTributoImportado' => 77.25,
        'ValorTributoMunicipal' => 13.5
    ];
    
    
    public function setUp()
    {
        $this->dummyRest = $this->getMockBuilder('\NFePHP\Ibpt\RestInterface')
            ->setMethods(['pull'])
            ->getMock();
        
        $this->dummyRest->method('pull')->willReturn(json_encode($this->expectedProd));
                
        $this->ibpt = new Ibpt('12345678901234', 'a5354bf3890s0849', [], $this->dummyRest);
    }
    
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(Ibpt::class, $this->ibpt);
    }
    
    public function testProductTaxes()
    {
        $expected = json_decode(json_encode($this->expectedProd));
        $resp = $this->ibpt->productTaxes(
            'SP',
            '60063210',
            0,
            'Tecidos de malha',
            'kg',
            '60.00',
            'SEM GTIN'
        );
        $this->assertEquals($expected, $resp);
    }
    
    public function testServiceTaxes()
    {
        $this->dummyRest = $this->getMockBuilder('\NFePHP\Ibpt\RestInterface')
            ->setMethods(['pull'])
            ->getMock();
        
        $this->dummyRest->method('pull')->willReturn(json_encode($this->expectedServ));
                
        $this->ibpt = new Ibpt('12345678901234', 'a5354bf3890s0849', [], $this->dummyRest);
        
        $expected = json_decode(json_encode($this->expectedServ));
        $resp = $this->ibpt->serviceTaxes(
            'SP',
            '0107',
            'Suporte técnico em informática',
            'un',
            '500.00'
        );
        $this->assertEquals($expected, $resp);
    }
}
