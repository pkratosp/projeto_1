<?php 
    include('../confg.php');
    $nome = (isset($_GET['pagamentos']) && $_GET['pagamentos'] == 'concluidos') ? 'concluidos' : 'pendetes';
?>

    <style>
        .box{
            width: 900px;
            margin: 0 auto;
        }

        .info-empresa{
            background-color:#263238;
            padding:4px 0;
            color:white;
        }

        table{
            width:900px;
            margin:0 auto;
            border-collapse: collapse;
        }

        tr,td{
            border:2px solid #ccc;
            padding:4px 0;
        }

        .bold{
            font-weight: bolder;
            font-size:17px;
        }

    </style>

    <div class="box">

        <div class="info-empresa">
                <h2><i class="fas fa-pen-square"></i> Pagamentos <?php echo $nome ?></h2>
        </div><!--info-empresa-->

        <table>
            <tr class="bold">
                <td>Nome do Pagamento</td>
                <td>cliente</td>
                <td>Valor</td>
                <td>Vencimento</td>
            </tr>

            <?php 
                if($nome == 'concluidos'){
                    $nome = 1;
                }else if($nome == 'pendetes'){
                    $nome = 0;
                }

                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financero` WHERE status = ? ORDER BY vencimento ASC");
                $sql->execute([$nome]);
                $pendentes = $sql->fetchAll();

                
                foreach ($pendentes as $key => $value) {
                $cliente_nome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = ?");
                $cliente_nome->execute([$value['cliente_id']]);
                $cliente_nome = $cliente_nome->fetch()['nome'];
            ?>


            <tr>
                <td><?php echo $value['nome'] ?></td>
                <td><?php echo $cliente_nome ?></td>
                <td><?php echo $value['valor'] ?></td>
                <td><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>