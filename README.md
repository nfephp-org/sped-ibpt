# sped-ibpt

Esta é uma API simples para permitir o acesso ao recursos providos pelos serviços RestFul do IBPT (Instituto Brasileiro de Planejamento e Tributação).

##Pré Requisitos

##Intalação

```
composer require sped-ibpt
```

#Class NFePHP\Ibpt\Ibpt

##Forma de Uso



#Métodos

##getTaxes

```php
public static function getTaxes(
      $cnpj,
      $token,
      $uf,
      $ncm,
      $extarif = 0,
      $proxy = [],
      RestInterface $rest = null
)
```
