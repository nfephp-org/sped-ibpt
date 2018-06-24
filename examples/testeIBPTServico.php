<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Ibpt\Ibpt;

$token = "<coloque seu token>";
$cnpj = "<indique seu CNPJ sem formatação>";

$codigo = '0107';
$uf = 'SP';
$descricao = 'Suporte técnico em informática';
$unidadeMedida = 'un';
$valor = '500.00';

$ibpt = new Ibpt($cnpj, $token);

$resp = $ibpt->serviceTaxes(
    $uf,
    $codigo,
    $descricao,
    $unidadeMedida,
    $valor
);
//caso não haja um retorno o erro e outras informações serão retornadas no JSON
echo "<pre>";
print_r($resp); //aqui mostra o retorno em um stdClass
echo "</pre>";
