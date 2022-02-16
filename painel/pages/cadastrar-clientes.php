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
                        

                        if($image['name'] != ''){
                            //temos uma imagem
                            $image = Painel::updateImage($image);
                            $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>$image,'order_id'=>'0','nome_tabela'=>'tb_admin.clientes'];
                            Painel::IncerirDepoimento($arr);
                            Painel::AtualizarAlerta('sucesso','O cliente foi cadastrado com uma foto.');
                        }else if($image['name'] == ''){
                            //nao temos uma imagem
                            $arr = ['nome'=>$nome,'email'=>$email,'tipo'=>$tipo,'cpf_cnpj'=>$infoFinal,'image'=>'semfoto','order_id'=>'0','nome_tabela'=>'tb_admin.clientes'];
                            Painel::IncerirDepoimento($arr);
                            Painel::AtualizarAlerta('sucesso','O cliente foi cadastrado sem foto');

                        }
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

</div>