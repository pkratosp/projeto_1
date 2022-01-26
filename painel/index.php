<?php 

	include('../confg.php');


	if(Painel::logado() == false){
		include('login.php');
	}else{
		include('main.php');
	}
?>