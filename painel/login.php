<?php 
	if(isset($_COOKIE['lembrar'])){
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ? ");
		$sql->execute(array($user,$password));

		if($sql->rowCount() == 1){

			$info = $sql->fetch();

			$_SESSION['login'] = true;
			$_SESSION['user'] = $user;
			$_SESSION['password'] = $password;
			$_SESSION['nome'] = $info['nome'];
			$_SESSION['cargo'] = $info['cargo'];
			$_SESSION['img'] = $info['img'];
			header('Location: '.INCLUDE_PATH_PAINEL);
			die();

		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Painel de Controle</title>
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css">
	<script src="https://kit.fontawesome.com/e603a9b5dc.js" crossorigin="anonymous"></script>
</head>
<body>

	<div class="box-login">
		<form method="post">

			<?php

				if(isset($_POST['acao'])){
					$user = $_POST['user'];
					$password = $_POST['password'];
					$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
					$sql->execute(array($user,$password));
					
					if($sql->rowCount() == 1){
						//se for true vai logar

						$info = $sql->fetch();//para pegar o cargo

						$_SESSION['login'] = true;
						$_SESSION['user'] = $user;
						$_SESSION['password'] = $password;
						$_SESSION['cargo'] = $info['cargo'];
						$_SESSION['nome'] = $info['nome'];
						$_SESSION['img'] = $info['img'];

						if(isset($_POST['lembrar'])){
							setcookie('lembrar',true, time()+(60*60*24), '/');//da um dia
							setcookie('user',$user, time()+(60*60*24), '/');
							setcookie('password',$password, time()+(60*60*24), '/');
						}

						header('Location: '.INCLUDE_PATH_PAINEL);

						die();//morre o script
					}else{
						//se for false nao vai logar e vai ficar na pagina
						echo'<div class="atualizado-erro"><i class="fas fa-times"></i> O nome de usuario ou senha está incorreto</div>';
					}

				}

			?>

			<h2>Pagina de controle</h2>
			<input type="text" name="user" placeholder="Nome..." required>
			<input type="password" name="password" placeholder="Digite sua senha" required>
			<div class="lembrar-group">
				<label>Lembrar-me</label>
				<input type="checkbox" name="lembrar">
			</div>
			<div style="clear: both;"></div>
			<input type="submit" name="acao" value="logar">
		</form>
	</div><!--box-login-->

</body>
</html>