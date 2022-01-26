<?php 
	include_once('../confg.php');

    $assunto = 'Nova mensagem do site';
    $corpo = '';

    $data = array();

    foreach ($_POST as $key => $value) {
        $corpo.= ucfirst($key)." : ".$value;
        $corpo.= "<hr>";
    }

    $info = array('assunto'=>$assunto, 'corpo'=>$corpo);
    $mail = new Email('smtp.titan.email','teste@painel.deliciasdanega.com','pedro84269713','pedro');
    $mail->addAdress('contato@deliciasdanega.com','pedro');

    $mail->formatarEmail($info);

    if($mail->enviarEmail()){
       $data['sucesso'] = true;
    }else{
       $data['erro'] = true;
    }


    //$data['retorno'] = 'sucesso';

    die(json_encode($data));//json_encode serve para o javascript entender
?>