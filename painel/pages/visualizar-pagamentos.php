<div class="box-content">

    <?php 

        if(isset($_GET['email'])){
            $parcela_id = (int)$_GET['parcela'];
            $cliente_id = (int)$_GET['email'];
            if(isset($_COOKIE['cliente_'.$cliente_id])){
                //nao vaamos enviar o email de aviso do novo
                Painel::AtualizarAlerta('erro','O email já foi enviado porfavor espere 7 dias antes de enviar de novo.');
            }else{
                //fazer o envio do email 
                Painel::AtualizarAlerta('sucesso','O email foi enviado com sucesso.');
                setcookie('cliente_'.$cliente_id,'true',time()+30,'/');
            }
        }

        if(isset($_GET['pago'])){
            $pagar = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = ? WHERE id = ?");
            $pagar->execute([1,$_GET['pago']]);
            Painel::AtualizarAlerta('sucesso','O pagamento foi concluído com sucesso!');
        }
    ?>
    
    <div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Pagamentos Pendentes</h2>
            <a class="gerar-pdf" target="_blank" class="" href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamentos=pendentes">Gerar PDF</a>
	</div><!--info-empresa-->

        
    <table>
        <tr>
            <td>Nome do Pagamento</td>
            <td>cliente</td>
            <td>Valor</td>
            <td>Vencimento</td>
            <td>Enviar Email</td>
            <td>Marcar como pago</td>
        </tr>

        <?php 
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = ? ORDER BY vencimento ASC");
            $sql->execute([0]);
            $pendentes = $sql->fetchAll();

            
            foreach ($pendentes as $key => $value) {
            $cliente_nome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = ?");
            $cliente_nome->execute([$value['cliente_id']]);
            $cliente_nome = $cliente_nome->fetch()['nome'];
            

            $info = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = ?");
            $info->execute([$value['cliente_id']]);
            $info = $info->fetch();


            $style = "";
            if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
                $style = 'style="background-color:#ff7070;font-weight:bold;"';
            }
        ?>


        <tr <?php echo $style; ?>>
            <td><?php echo $value['nome'] ?></td>
            <td><?php echo $cliente_nome ?></td>
            <td><?php echo $value['valor'] ?></td>
            <td><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></td>
            <td><a class="btn-options edit" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?email=<?php echo $info['id']  ?>&parcela=<?php echo $value['id'] ?>"><i class="fas fa-envelope"></i> Email</a></td>
            <td><a class="btn-options pago" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?pago=<?php echo $value['id'] ?>"><i class="far fa-check-circle"></i> Pago</a></td>
        </tr>

        <?php } ?>

    </table>


    <div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Pagamentos Concluidos</h2>
            <div><a class="gerar-pdf" target="_blank" href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamentos=concluidos">Gerar PDF</a></div>
	</div><!--info-empresa-->

    <table>
        <tr>
            <td>Nome do Pagamento</td>
            <td>cliente</td>
            <td>Valor</td>
            <td>Vencimento</td>
        </tr>

        <?php 
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = ? ORDER BY vencimento ASC");
            $sql->execute([1]);
            $pendentes = $sql->fetchAll();

            
            foreach ($pendentes as $key => $value) {
            $cliente_nome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = ?");
            $cliente_nome->execute([$value['cliente_id']]);
            @$cliente_nome = $cliente_nome->fetch()['nome'];
        ?>


        <tr>
            <td><?php echo $value['nome'] ?></td>
            <td><?php echo $cliente_nome ?></td>
            <td><?php echo $value['valor'] ?></td>
            <td><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></td>
        </tr>

        <?php } ?>

    </table>

</div><!--box-content-->