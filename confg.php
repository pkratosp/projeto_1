<?php 

	/*
		var o conflito que esta acontecendo quando o usuario nao é adm
		e ver pq se eu dou um die() nao renderiza o que eu preciso

		ver o pq que as listas do depoimentos e dos servicos nao parace todas dependendo de como sao cadastradas
	*/

	session_start();

	date_default_timezone_set('America/Sao_Paulo');

	require('vendor/autoload.php');

	$autoload = function($class){
		if($class == 'Email'){
			include('classes/phpmailer/PHPMailerAutoload.php');
		}
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);
	

	define('INCLUDE_PATH','http://localhost/projeto_1/');
	define('INCLUDE_PATH_PAINEL', INCLUDE_PATH.'painel/');
	define('BASE_DIR_PAINEL',__DIR__.'/painel');
	define('INCLUDE_PATH_NOTICIAS', INCLUDE_PATH.'/noticias');

	//MYSQL A VARIAVEL ESTA NA PASTA classes
	define('HOST','localhost');
	define('DATABASE','cusro_projeto_01');
	define('USER','root');
	define('PASSWORD','');

	//nome da empresa
	define('Nome_Empresa','Miflin');

	//verficação de cargos pode fazer tbm permisoes

	function pegaCargo($cargo){
		return Painel::$cargos[$cargo];
	}

	function SelecioneMenu($par){
		$url = explode('/',@$_GET['url'])[0];
		if($url == $par){
			echo 'class="menu-active"';
		}
	}

	function verificaPermissaoMenu($permissao){
		if($_SESSION['cargo'] >= $permissao){
			return;
		}else{
			echo 'style="display:none;"';
		}
	}

	function verificaPermissaoPagina($permissao){
		if($_SESSION['cargo'] >= $permissao){
			return;
		}else{
			include('painel/pages/acesso-negado.php');
			//lembrar de matar o script
		}
	}

	function recoverPost($post){
		if(isset($_POST[$post])){
			echo $_POST[$post];
		}
	}

?>