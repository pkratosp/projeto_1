<?php 
include('../../includeConstants.php');

$data['sucesso'] = true;
$data['mensagem'] = "";

if(Painel::logado() == false){
    die('Você não está logado.');
}

if($_POST['acao'] && $_POST['acao'] == 'inserir_mensagem'){
    $mensagem = $_POST['mensagem'];
    $id_user = $_SESSION['id_user'];
    $nome = $_SESSION['nome'];

    $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.chat` VALUES (null,?,?)");
    $sql->execute([$id_user,$mensagem]);

    echo'<div class="chat-mensagem">
        <span>'.$nome.'</span>
        <p>'.$mensagem.'</p>
    </div><!--chat-mensagem-->';

    $_SESSION['lastIdChat'] = MySql::conectar()->lastInsertId();

}else if($_POST['acao'] && $_POST['acao'] == 'recuperar_mensagem'){

    @$lastId = $_SESSION['lastIdChat'];
    
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.chat` WHERE id > ?");
    $sql->execute([$lastId]);
    $mensagem = $sql->fetchAll();
    $mensagem = array_reverse($mensagem);

    foreach ($mensagem as $key => $value) {
        
        $nomeUsuario = MySql::conectar()->prepare("SELECT nome FROM `tb_admin.usuarios` WHERE id = ?");
        $nomeUsuario->execute([$value['user_id']]);
        $nomeUsuario = $nomeUsuario->fetch()['nome'];

        echo'<div class="chat-mensagem">
            <span>'.$nomeUsuario.'</span>
            <p>'.$value['mensagem'].'</p>
        </div><!--chat-mensagem-->';

        $_SESSION['lastIdChat'] = $value['id'];

    }

}


?>