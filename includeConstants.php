<?php 

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

	//MYSQL A VARIAVEL ESTA NA PASTA classes
	define('HOST','localhost');
	define('DATABASE','projeto_1');
	define('USER','root');
	define('PASSWORD','');

	//nome da empresa
	define('Nome_Empresa','Miflin');

?>