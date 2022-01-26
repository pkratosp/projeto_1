<?php 

class Site
{
    
    public static function updateUsuarioOnline(){
        if(isset($_SESSION['online'])){
            $horarioAtual = date('Y-m-d H:i:s');
            $token = $_SESSION['online'];

            $check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ?");
            $check->execute(array($_SESSION['online']));

            if($check->rowCount() == 1){

                $sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ? ");
                $sql->execute(array($horarioAtual,$token));

            }else{

                if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }else{
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

                $token = $_SESSION['online'];
                $horarioAtual = date('Y-m-d H:i:s');
    
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
                $sql->execute(array($ip,$horarioAtual,$token));

            }
            


        }else{

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}

            $_SESSION['online'] = uniqid();
            $token = $_SESSION['online'];
            $horarioAtual = date('Y-m-d H:i:s');

            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
            $sql->execute(array($ip,$horarioAtual,$token));
            
        }
    }

    public static function Contador(){
        //setcookie('visitas','true', time() - 1);//para limpa o cookie
        if(!isset($_COOKIE['visitas'])){
            setcookie('visitas','true', time() + (60*60*7));//cria o cookie e vai durar 7 dias
            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES (null,?,?)");
            $sql->execute(array($_SERVER['REMOTE_ADDR'],date('Y-m-d')));
        }
    }

}


?>