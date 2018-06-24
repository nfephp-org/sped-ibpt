# sped-ibpt

Este repositório faz parte do framework [NFePHP](http://www.nfephp.org), como um auxilio na busca dos impostos incidentes sobre um determinado produto, utilizando o recurso gratuito oferecido pelo [IBPT](https://ibpt.com.br/).

*A Lei do Imposto na Nota (Lei nº 12.741/12, de 8 de dezembro de 2012) nasceu com o intuito de informar ao cidadão o quanto representa a parcela dos tributos que paga a cada compra realizada.*

*Assim, todo estabelecimento que efetuar vendas diretamente ao consumidor final **está obrigado** a incluir nos documentos fiscais ou equivalentes os impostos pagos, valores aproximados e percentuais.*

*Como consumidores finais incluem-se as pessoas físicas ou jurídicas que adquirem produtos ou serviços, por exemplo, para consumo próprio, materiais de uso ou consumo e ativo imobilizado.*

*As Microempresas e Empresas de Pequeno Porte optantes do Simples Nacional podem informar apenas a alíquota a que se encontram sujeitas nos termos do referido regime. Além disso, devem somar eventual incidência tributária anterior (IPI, substituição tributária, por exemplo).*

[![Join the chat at https://gitter.im/nfephp-org/sped-ibpt](https://badges.gitter.im/nfephp-org/sped-ibpt.svg)](https://gitter.im/nfephp-org/sped-ibpt?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Esta é uma API simples para permitir o acesso ao recursos providos pelos serviços RestFul do [IBPT "Instituto Brasileiro de Planejamento e Tributação"](https://deolhonoimposto.ibpt.org.br/).

Para saber mais consulte a [documentação do IBPT](http://iws.ibpt.org.br/).

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

## Esclarecimentos

1. Os cupons (mod.65, ECF e SAT) e notas fiscais (mod.55) referentes à venda de mercadoria e serviços **devem informar o valor aproximado dos tributos federais, estaduais e municipais**, cuja incidência influencia na formação do preço final;

2. A apuração do valor dos impostos deverá ser feita em 3 campos (um por ente) com a soma das cargas tributárias aproximadas que incidem sobre cada mercadoria ou serviço, separadamente, inclusive nas hipóteses de regimes jurídicos tributários diferenciados dos respectivos fabricantes, varejistas e prestadores de serviços, quando couber.

3. Alternativemente, no caso de lojas físicas, as informações podem estar em painel afixado em local visível do estabelecimento comercial. Elas serão em percentual sobre o preço a ser pago, quando se tratar de tributo com alíquota *"ad valorem"* (sobre valor) ou em valores monetários (no caso de alíquota específica).

> NOTA: Para maiores detalhes vide [NT2013.003](https://www.nfe.fazenda.gov.br/portal/exibirArquivo.aspx?conteudo=RrvyORm641k=)

## Pré Requisitos

Antes de poder utilizar esta classe é necessário que você obtenha um TOKEN de acesso cadastrando a empresa no IBPT [página de Cadastro](https://deolhonoimposto.ibpt.org.br/Usuario/CriarConta)

- PHP >= 7.0
- php-curl
- php-json
- php-openssl

## Intalação

```
composer require nfephp-org/sped-ibpt
```

Ou adicione ao seu composer.json:
```
{
    "require": {
        "nfephp-org/sped-ibpt": "^2.0"
    }
}
```

# Métodos

## productTaxes
Este método consulta o webservice do IBPT e solicita os dados referentes aos impostos do produto solicitado.
Sendo:
```php

use NFePHP\Ibpt\Ibpt;

$token = "<indique seu token>"; //OBRIGATÓRIO
$cnpj = "<indique seu CNPJ>"; //OBRIGATÓRIO

$ncm = "60063210"; //OBRIGATÓRIO coloque o NCM do produto
$uf = 'SP'; //OBRIGATÓRIO coloque o estado que deseja saber os dados
$extarif = 0; //OBRIGATÓRIO indique o numero da exceção tarifaria, se existir ou deixe como zero
$codigoInterno = ''; //(OPCIONAL) indique o codigo interno do produto 
$descricao = 'Tecido';//OBRIGATÓRIO
$unidadeMedida = 'kg'; //OBRIGATÓRIO
$valor = '60.00'; //OBRIGATÓRIO
$gtin = 'SEM GTIN'; //OBRIGATÓRIO

//instancia a classe 
$ibpt = new Ibpt($cnpj, $token);

public function productTaxes(
    $uf,
    $ncm,
    $extarif,
    $descricao,
    $unidadeMedida,
    $valor,
    $gtin,
    $codigoInterno
)
```
Em caso de SUCESSO e com a localização do Produto solicitado irá retornar:
```php
stdClass Object
(
    [Codigo] => 60063210
    [UF] => SP
    [EX] => 0
    [Descricao] => Tecidos de malha de fibras sinteticas, tintos, de náilon ou de outras poliamidas
    [Nacional] => 13.45
    [Estadual] => 18
    [Importado] => 36.08
    [Municipal] => 0
    [Tipo] => 0
    [VigenciaInicio] => 01/04/2018
    [VigenciaFim] => 30/06/2018
    [Chave] => F3W1D7
    [Versao] => 18.1.B
    [Fonte] => IBPT/empresometro.com.br
    [Valor] => 60
    [ValorTributoNacional] => 8.07
    [ValorTributoEstadual] => 10.8
    [ValorTributoImportado] => 21.65
    [ValorTributoMunicipal] => 0
)
```
Em caso de não encontrar o produto pelo NCM, ou qualquer outro erro na comunicação, retornará algo como:
```php
stdClass Object
(
    [Codigo] => 
    [UF] => 
    [EX] => 0
    [Descricao] => 
    [Nacional] => 0
    [Estadual] => 0
    [Importado] => 0
    [Municipal] => 0
    [Tipo] => 
    [VigenciaInicio] => 
    [VigenciaFim] => 
    [Chave] => 
    [Versao] => 
    [Fonte] => 
    [Valor] => 60
    [ValorTributoNacional] => 0
    [ValorTributoEstadual] => 0
    [ValorTributoImportado] => 0
    [ValorTributoMunicipal] => 0
)
```

## serviceTaxes
Este método consulta o webservice do IBPT e solicita os dados referentes aos impostos do serviço solicitado.
Sendo:
```php

use NFePHP\Ibpt\Ibpt;

$token = "<indique seu token>"; //OBRIGATÓRIO
$cnpj = "<indique seu CNPJ>"; //OBRIGATÓRIO

$codigo = '0107';  //OBRIGATÓRIO numero LV116 ou NBM
$uf = 'SP'; // //OBRIGATÓRIO
$descricao = 'Suporte técnico em informática';  //OBRIGATÓRIO
$unidadeMedida = 'un';  //OBRIGATÓRIO
$valor = '500.00';  //OBRIGATÓRIO

//instancia a classe 
$ibpt = new Ibpt($cnpj, $token);

$resp = $ibpt->serviceTaxes(
    $uf,
    $codigo,
    $descricao,
    $unidadeMedida,
    $valor
);
```
Em caso de SUCESSO e com a localização do Serviço solicitado irá retornar:
```php
stdClass Object
(
    [Codigo] => 0107
    [UF] => SP
    [Descricao] => Suporte técnico em informática, inclusive instalação, configuração e manutenção de programas de computação e bancos de dados.
    [Tipo] => 2
    [Nacional] => 13.45
    [Estadual] => 0
    [Municipal] => 2.7
    [Importado] => 15.45
    [VigenciaInicio] => 01/04/2018
    [VigenciaFim] => 30/06/2018
    [Chave] => F3W1D7
    [Versao] => 18.1.B
    [Fonte] => IBPT/empresometro.com.br
    [Valor] => 500
    [ValorTributoNacional] => 67.25
    [ValorTributoEstadual] => 0
    [ValorTributoImportado] => 77.25
    [ValorTributoMunicipal] => 13.5
)
```
Em caso de não encontrar o produto pelo NCM, ou qualquer outro erro na comunicação, retornará algo como:
```php
stdClass Object
(
    [Codigo] => 
    [UF] => 
    [Descricao] => 
    [Tipo] => 
    [Nacional] => 0
    [Estadual] => 0
    [Municipal] => 0
    [Importado] => 0
    [VigenciaInicio] => 
    [VigenciaFim] => 
    [Chave] => 
    [Versao] => 
    [Fonte] => 
    [Valor] => 500
    [ValorTributoNacional] => 0
    [ValorTributoEstadual] => 0
    [ValorTributoImportado] => 0
    [ValorTributoMunicipal] => 0
)
```


## Credits
- Roberto L. Machado (owner)

## Change log

Acompanhe o [CHANGELOG](CHANGELOG.md) para maiores informações sobre as alterações recentes.

## Contributing

Para contribuir por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) parea detalhes.

## Security

Caso você encontre algum problema relativo a segurança, por favor envie um email diretamente aos mantenedores do pacote ao invés de abrir um ISSUE.

## License

Este pacote está diponibilizado sob LGPLv3 ou MIT License (MIT). Leia  [Arquivo de Licença](LICENSE.md) para maiores informações.


[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nfephp-org/sped-ibpt/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-ibpt.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nfephp-org/sped-ibpt
[link-travis]: https://travis-ci.org/nfephp-org/sped-ibpt
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibpt/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibpt
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-ibpt
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-ibpt/issues
[link-forks]: https://github.com/nfephp-org/sped-ibpt/network
[link-stars]: https://github.com/nfephp-org/sped-ibpt/stargazers
