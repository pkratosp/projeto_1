<?php 

include('../../includeConstants.php');

if(Painel::logado() == false){
    die('Você não está logado.');
}


if(isset($_POST['acao']) && $_POST['acao'] == 'ordenar_empreendimento'){
    $ids = $_POST['item'];
    $i = 1;
    foreach ($ids as $key => $value) {
        $pdo = MySql::conectar()->prepare("UPDATE `tb_admin.empreendimentos` SET order_id = ? WHERE id = ?");
        $pdo->execute([$i,$value]);
        $i++;
    }
}

?>