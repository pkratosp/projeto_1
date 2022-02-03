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
                    $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>$imagem,'nome_tabela'=>'tb_admin.clientes'];
                    Painel::update($arr);
                    Painel::AtualizarAlerta('sucesso','O cliente foi atualizado com uma nova imagem!');
                }else{
                    Painel::AtualizarAlerta('erro','O cliente não pode ser atualizado');
                }

            }else{

                $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>$imagem,'nome_tabela'=>'tb_admin.clientes'];
                Painel::update($arr);
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

        <div rel="cpf" class="alinhe-inputs">
            <label>CPF:</label>
            <input type="text" name="cpf" value="<?php echo $cliente['cpf_cnpj'] ?>">
        </div><!--alinhe-inputs-->

        <div style="display:none;" rel="cnpj" class="alinhe-inputs">
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


    <div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Pagamentos Pendentes</h2>
	</div><!--info-empresa-->

    <table>
        <tr>
            <td>Nome do Pagamento</td>
            <td>cliente</td>
            <td>Valor</td>
            <td>Vencimento</td>
            <td>#</td>
        </tr>

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
            <td>#</td>
        </tr>

    </table>


</div>