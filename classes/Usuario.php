<?php 

class Usuario{

    //vai atualizar a imagem nome e senha 
    public function AtualizarUsuarios($nome,$senha,$imagem){
        $sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET nome = ?, password = ?, img = ? WHERE user = ?");
        if($sql->execute(array($nome,$senha,$imagem, $_SESSION['user']))){
            return true;
        }else{
            return false;
        }
    }

    public static function UsuarioExiste($user){
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user=?");
        $sql->execute(array($user));
        if($sql->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function CadastrarUsuario($user,$password,$imagem,$nome,$cargo){
        $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?)");
        $sql->execute(array($user,$password,$imagem,$nome,$cargo));
    }

}

?>