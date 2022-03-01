<?php 
include('../../includeConstants.php');

$data['sucesso'] = true;
$data['mensagem'] = "";

if(Painel::logado() == false){
    die('Você não está logado.');
}

echo $_POST['mensagem'];


?>