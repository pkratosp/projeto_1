<?php 

ob_start();
include('templateFinancero.php');
$conteudo = ob_get_contents();
ob_end_clean();

$mdpf = new \Mpdf\Mpdf();
$mdpf->WriteHTML($conteudo);
$mdpf->Output();

?>  