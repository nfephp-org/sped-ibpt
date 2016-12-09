<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Ibpt;

$token = "<Aqui voce coloca seu token do IBPT>";
$cnpj = "<seu CNPJ>";
$ncm = "60063100"; //coloque o NCM do produto
$uf = 'MG'; //coloque o estado que deseja saber os dados
$extarif = 0; //indique o numero da exceção tarifaria, se existir ou deixe como zero

//instancia a classe Ibpt
$ibpt = new Ibpt($cnpj, $token);

//executa a consulta ao IBPT, o retorno é em stdClass
$resp = $ibpt->productTaxes($uf, $ncm, $extarif);

//caso não haja um retorno o erro e outras informações serão retornadas no JSON
echo "<pre>";
print_r($resp); //aqui mostra o retorno em um stdClass
echo "</pre>";

/*
 Em caso de SUCESSO irá retornar:

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

Em caso de não encontrar o produto pelo NCM, ou qualquer outro erro na comunicação, retornará:

   stdClass Object
   (
        [error] => SUCESSO
        [response] => "Produto não encontrado"
        [httpcode] => 404
        [level] => Client ERROR
        [description] => Não encontrado
        [means] => O recurso requisitado não foi encontrado, mas pode ser disponibilizado novamente no futuro. As solicitações subsequentes pelo cliente são permitidas
    )
 */
