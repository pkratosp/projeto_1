<?php 
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $cliente = Painel::select('tb_admin.clientes','id=?',array($id));
    }else{
        echo '<script>alert("Você não pode acessar está pagina")</script>';
        die();
    }

?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar Cliente</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php 
            //editar cliente
            if(isset($_POST['atualizar'])){
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $tipo = $_POST['tipo_cliente'];
                $cpf = $_POST['cpf'];
                $cnpj = $_POST['cnpj'];
                $infoFinal = $cpf == '' ? $cnpj : $cpf;
                $imagem = $_FILES['image'];
                $imagem_atual = $_POST['image_atual'];

                if($imagem['name'] != ''){
                    //temos que atualizar a imagem

                    if(Painel::imagemValida($imagem)){
                        Painel::deleteImagem($imagem_atual);
                        $imagem = Painel::updateImage($imagem);
                        
                        $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_admin.clientes'];
                        Painel::update($arr);
                        $cliente = Painel::select('tb_admin.clientes','id=?',array($id));

                        Painel::AtualizarAlerta('sucesso','O cliente foi atualizado com uma nova imagem!');
                    }else{
                        Painel::AtualizarAlerta('erro','O cliente não pode ser atualizado');
                    }

                }else{
                    if($cpf == ''){
                        
                    }
                    $imagem = $imagem_atual;
                    $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_admin.clientes'];
                    Painel::update($arr);
                    $cliente = Painel::select('tb_admin.clientes','id=?',array($id));
                    Painel::AtualizarAlerta('sucesso','O cliente foi atualizado com sucesso!');
                }

            }


        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo $cliente['nome'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $cliente['email'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Tipo:</label>
            <select name="tipo_cliente">
                <option <?php if('fisico' == $cliente['tipo']) echo 'selected'; ?> value="fisico">Físico</option>
                <option <?php if('juridico' == $cliente['tipo']) echo 'selected'; ?> value="juridico">Jurídico</option>
            </select>
        </div><!--alinhe-inputs-->

        <div <?php if($cliente['tipo'] != 'fisico'){ ?> style="display:none;" <?php } ?> rel="cpf" class="alinhe-inputs">
            <label>CPF:</label>
            <input type="text" name="cpf" value="<?php echo $cliente['cpf_cnpj'] ?>">
        </div><!--alinhe-inputs-->

        <div <?php if($cliente['tipo'] != 'juridico'){ ?> style="display:none;" <?php } ?> rel="cnpj" class="alinhe-inputs">
            <label>CNPJ:</label>
            <input type="text" name="cnpj" value="<?php echo $cliente['cpf_cnpj'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="hidden" name="image_atual" value="<?php echo $cliente['image'] ?>"> 
            <input type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="atualizar" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

    <div class="info-empresa">
			<h2><i class="fas fa-pencil-alt"></i> Adicionar Pagamentos</h2>
	</div><!--info-empresa-->

    <form method="post">

        <?php 

            if(isset($_POST['pagar'])){
                $cliente_id = $id;
                $nome_pagamento = $_POST['nome_pagamento'];
                $valor = $_POST['pagamento'];
                $parcelas = $_POST['parcelas'];
                $intervalo = $_POST['intervalo'];
                $vencimentoOriginal = $_POST['vencimento'];

                if(strtotime($vencimentoOriginal) < strtotime(date('Y-m-d'))){
                    Painel::AtualizarAlerta('erro','Você não pode cadastrar datas negativas!');
                }else{
                    for($i = 0; $i < $parcelas; $i++){
                        $vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo) * (60*60*24));
                        $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.financero` VALUES(null,?,?,?,?,?)");
                        $sql->execute([$cliente_id,$nome_pagamento,$valor,date('Y-m-d',$vencimento),'0']);
                    }
                    Painel::AtualizarAlerta('sucesso','O(s) pagamento(s) foi(foram) adicionado(s) com sucesso!');
                }

            }
            
        ?>

        <div class="alinhe-inputs">
            <label>Nome do pagamento:</label>
            <input type="text" name="nome_pagamento">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Valor de Pagamento:</label>
            <input type="text" name="pagamento">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Número de Parcelas:</label>
            <input type="text" name="parcelas">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Intervalo:</label>
            <input type="text" name="intervalo">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Vencimento:</label>
            <input type="text" name="vencimento">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="pagar" value="Incerir Pagamento">
        </div><!--alinhe-inputs-->

    </form>

    <?php 

        if(isset($_GET['pago'])){
            $pagar = MySql::conectar()->prepare("UPDATE `tb_admin.financero` SET status = ? WHERE id = ?");
            $pagar->execute([1,$_GET['pago']]);
            Painel::AtualizarAlerta('sucesso','O pagamento foi concluído com sucesso!');
        }

    ?>


    <div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Pagamentos Pendentes</h2>
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
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financero` WHERE status = ? AND cliente_id = ? ORDER BY vencimento ASC");
            $sql->execute([0,$id]);
            $pendentes = $sql->fetchAll();

            
            foreach ($pendentes as $key => $value) {
            $cliente_nome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = ?");
            $cliente_nome->execute([$value['cliente_id']]);
            $cliente_nome = $cliente_nome->fetch()['nome'];

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
            <td><a class="btn-options edit" href=""><i class="fas fa-envelope"></i> Email</a></td>
            <td><a class="btn-options pago" href="<?php echo INCLUDE_PATH_PAINEL ?>edite-cliente?id=<?php echo $id ?>&pago=<?php echo $value['id'] ?>"><i class="far fa-check-circle"></i> Pago</a></td>
        </tr>

        <?php } ?>

    </table>

    <div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Pagamentos Concluidos</h2>
	</div><!--info-empresa-->

    <table>
        <tr>
            <td>Nome do Pagamento</td>
            <td>cliente</td>
            <td>Valor</td>
            <td>Vencimento</td>
        </tr>

        <?php 
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financero` WHERE status = ? AND cliente_id = ? ORDER BY vencimento ASC");
            $sql->execute([1,$id]);
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