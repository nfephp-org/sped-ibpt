# sped-ibpt
Este repositório faz parte do framework [NFePHP](http://www.nfephp.org).

[![Chat][ico-gitter]][link-gitter]

Esta é uma API simples para permitir o acesso ao recursos providos pelos serviços RestFul do [IBPT "Instituto Brasileiro de Planejamento e Tributação"](https://deolhonoimposto.ibpt.org.br/).

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

##Pré Requisitos

Antes de poder utilizar esta classe é necessário que você obtenha um TOKEN de acesso cadastrando a empresa no IBPT [página de Cadastro](https://deolhonoimposto.ibpt.org.br/Usuario/CriarConta)

- PHP >= 5.6
- php-curl

##Intalação

```
composer require nfephp-org/sped-ibpt
```

Ou adicione ao seu composer.json:
```
{
    "require": {
        "nfephp-org/sped-mail": "^0.1"
    }
}
```

#NFePHP\Ibpt\Ibpt::class

##Forma de Uso

Existe um exemplo comentado na pasta **"examples"**.

```php
//indica o caminho da classe conforme PSR4
//para usar dessa forma é necessário utlizar o autoload do composer.
use NFePHP\Ibpt\Ibpt;

$token = "<Aqui voce coloca seu token do IBPT>";
$cnpj = "<seu CNPJ>";
$ncm = "60063100"; //coloque o NCM do produto
$uf = 'MG'; //coloque o estado que deseja saber os dados
$extarif = 0; //indique o numero da exceção tarifaria, se existir ou deixe como zero

//instancia a classe Ibpt
$ibpt = new Ibpt($cnpj, $token);

//executa a consulta ao IBPT, o retorno é em stdClass
$resp = $ibpt->productTaxes($uf, $ncm, $extarif);

//caso não haja um retorno o erro e outras informações serão retornadas
echo "<pre>";
print_r($resp); //aqui mostra o retorno em um stdClass
echo "</pre>";

```

#Métodos

##productTaxes
Este método consulta o webservice do IBPT e solicita os dados referentes aos impostos do produto solicitado.
Sendo:
```php

$uf = 'SP'; //A sigla da unidade da federação
$ncm = '60063110'; //numero do NCM do produto
$extarif = 0; //numero da exceção tarifária

public function productTaxes(
      $uf,
      $ncm,
      $extarif = 0,
)
```
Em caso de SUCESSO e com a localização do Produto solicitado irá retornar:
```php
stdClass Object
(
	[Codigo] => 60063110
    [UF] => MG
    [EX] => 0
    [Descricao] => Tecidos de malha de fibras sinteticas, crus ou branqueados, de náilon ou de outras poliamidas
    [Nacional] => 13.45
    [Estadual] => 18
    [Importado] => 19.72
    [Municipal] => 0
    [Tipo] => 0
    [VigenciaInicio] => 26/10/2016
    [VigenciaFim] => 31/12/2016
    [Chave] => E13pH1
    [Versao] => 16.2.B
    [Fonte] => IBPT
)
```
Em caso de não encontrar o produto pelo NCM, ou qualquer outro erro na comunicação, retornará algo como:
```php
stdClass Object
(
    [error] => SUCESSO
    [response] => "Produto não encontrado"
    [httpcode] => 404
    [level] => Client ERROR
    [description] => Não encontrado
    [means] => O recurso requisitado não foi encontrado, mas pode ser disponibilizado novamente no futuro. As solicitações subsequentes pelo cliente são permitidas
)
```

##Credits
- Roberto L. Machado (owner)

##Change log

Acompanhe o [CHANGELOG](CHANGELOG.md) para maiores informações sobre as alterações recentes.

##Contributing

Para contribuir por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) parea detalhes.

##Security

Caso você encontre algum problema relativo a segurança, por favor envie um email diretamente aos mantenedores do pacote ao invés de abrir um ISSUE.

##Credits

##License

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
[ico-gitter]: https://img.shields.io/badge/GITTER-4%20users%20online-green.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nfephp-org/sped-ibpt
[link-travis]: https://travis-ci.org/nfephp-org/sped-ibpt
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibpt/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibpt
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-ibpt
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-ibpt/issues
[link-forks]: https://github.com/nfephp-org/sped-ibpt/network
[link-stars]: https://github.com/nfephp-org/sped-ibpt/stargazers
[link-gitter]: https://gitter.im/nfephp-org/sped-ibpt?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge
