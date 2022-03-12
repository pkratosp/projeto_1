<?php 

verificaPermissaoPagina(2); 
?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Empreendimento</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php 

            if(isset($_POST['acao'])){
                $nome = $_POST['nome'];
                $tipo = $_POST['tipo'];
                $preco = $_POST['preço'];
                $imagem = $_FILES['image'];

                if($_FILES['image']['name'] == ''){
                    Painel::AtualizarAlerta('erro','Você precisa selecionar uma imagem!');
                }else if($_FILES['image']['name'] != ''){

                    if(Painel::imagemValida($imagem) == false){
                        Painel::AtualizarAlerta('erro','A imagem não é valida.');
                    }else{
                        $imagem = Painel::updateImage($imagem);
                        $slug = Painel::generateSlug($nome);
                        $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.empreendimentos` VALUES (null,?,?,?,?,?,?)");
                        $sql->execute([$nome,$tipo,$preco,$imagem,$slug,0]);
                        $last_id = MySql::conectar()->lastInsertId();
                        $sql = MySql::conectar()->prepare("UPDATE `tb_admin.empreendimentos` SET order_id = ? WHERE id = ?");
                        $sql->execute([$last_id,$last_id]);
                       Painel::AtualizarAlerta('sucesso','O empreendimento foi cadastrado com sucesso!');
                    }

                }

            }

        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Tipo:</label>
            <select name="tipo">
                <option value="residencial">Residencial</option>
                <option value="comercial">Comercial</option>
            </select>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Preço:</label>
            <input type="text" name="preço">
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