<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Ibpt\Ibpt;

$token = "<coloque seu token>";
$cnpj = "<indique seu CNPJ sem formatação>";


$ncm = "60063210"; //coloque o NCM do produto
$uf = 'SP'; //coloque o estado que deseja saber os dados
$extarif = 0; //indique o numero da exceção tarifaria, se existir ou deixe como zero
$codigoInterno = '';
$descricao = 'Tecido';
$unidadeMedida = 'kg';
$valor = '60.00';
$gtin = 'SEM GTIN';


$ibpt = new Ibpt($cnpj, $token);

//executa a consulta ao IBPT, o retorno é em JSON
$resp = $ibpt->productTaxes(
    $uf,
    $ncm,
    $extarif,
    $descricao,
    $unidadeMedida,
    $valor,
    $gtin,
    $codigoInterno
);
//$resp = $ibpt->serviceTaxes($uf, $code);
//caso não haja um retorno o erro e outras informações serão retornadas no JSON
echo "<pre>";
print_r($resp); //aqui mostra o retorno em um stdClass
echo "</pre>";
