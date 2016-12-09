# sped-ibpt

Esta é uma API simples para permitir o acesso ao recursos providos pelos serviços RestFul do IBPT (Instituto Brasileiro de Planejamento e Tributação).

##Pré Requisitos

Antes de poder utilizar esta classe é necessário que você obtenha um TOKEN de acesso cadastrando a empresa no IBPT [página de Cadastro](https://deolhonoimposto.ibpt.org.br/Usuario/CriarConta)

- PHP >= 5.6
- php-curl

##Intalação

```
composer require nfephp-org/sped-ibpt
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
