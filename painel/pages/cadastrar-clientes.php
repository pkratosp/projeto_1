<?php 

verificaPermissaoPagina(2); 
?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php 
        
            if(isset($_POST['acao'])){

                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $tipo = $_POST['tipo_cliente'];
                $cpf = $_POST['cpf'];
                $cnpj = $_POST['cnpj'];
                $image = $_FILES['image'];
            
                $infoFinal = $cpf == '' ? $cnpj : $cpf;
            
                if($nome == '' || $email == '' || $infoFinal == ''){
                    Painel::AtualizarAlerta('erro','Campos vazios não são permitidos.');
                }else{
                    
                    $verifica_cpf = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE cpf_cnpj = ?");
                    $verifica_cpf->execute([$infoFinal]);

                    $verifica_cnpj = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE cpf_cnpj = ?");
                    $verifica_cnpj->execute([$infoFinal]);

                    if($verifica_cpf->rowCount() == 1 || $verifica_cnpj->rowCount() == 1){
                        //nao podemos cadastra
                        Painel::AtualizarAlerta('erro','O cliente já existe.');
                    }else{
                        $image = Painel::updateImage($image);
                        $pdo = MySql::conectar()->prepare("INSERT INTO `tb_admin.clientes` VALUES(null,?,?,?,?,?)");
                        $pdo->execute([$nome,$email,$tipo,$infoFinal,$image]);
                        Painel::AtualizarAlerta('sucesso','O cliente foi cadastrado.');
                    }


                    

                }
            
            }
        
        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Email:</label>
            <input type="text" name="email">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Tipo:</label>
            <select name="tipo_cliente">
                <option value="fisico">Físico</option>
                <option value="juridico">Jurídico</option>
            </select>
        </div><!--alinhe-inputs-->

        <div rel="cpf" class="alinhe-inputs">
            <label>CPF:</label>
            <input type="text" name="cpf">
        </div><!--alinhe-inputs-->

        <div style="display:none;" rel="cnpj" class="alinhe-inputs">
            <label>CNPJ:</label>
            <input type="text" name="cnpj">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
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