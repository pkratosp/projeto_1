<?php 

ob_start();
include('templateFinancero.php');
$conteudo = ob_get_contents();
ob_end_clean();
echo $conteudo;
?>  