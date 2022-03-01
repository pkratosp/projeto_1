<?php 

    @$id = (int)$_GET['id'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
    $sql->execute([$id]);
    $infoProduto = $sql->fetch();
    if($sql->rowCount() == 0){
        Painel::AtualizarAlerta('erro','Você não tem permição de acessar está pagina!');
        die();
    }

    $todasImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
    $todasImagens->execute([$id]);
    $todasImagens = $todasImagens->fetchAll();



?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Produtos no estoque</a> » Editar produto id: <?php echo $infoProduto['id'];  ?></h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

    <?php  
                
        if(isset($_GET['deletarImagem'])){
            $nome = $_GET['deletarImagem'];
            $pdo = MySql::conectar()->prepare("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = ?");
            $pdo->execute([$nome]);
            Painel::deleteImagem($nome);
            Painel::AtualizarAlerta('sucesso','A imagem foi deletada com sucesso!');
            $todasImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
            $todasImagens->execute([$id]);
            $todasImagens = $todasImagens->fetchAll();
        }

        if(isset($_POST['atualizar'])){
            $nome = $_POST['nome_produto'];
            $descricao = $_POST['descricao'];
            $largura = $_POST['largura'];
            $altura = $_POST['altura'];
            $comprimento = $_POST['comprimento'];
            $peso = $_POST['peso'];
            $quantidade = $_POST['quantidade'];

            $sucesso = true;

            $imagens = [];
            $aumontFiles = count($_FILES['image']['name']);

            if($_FILES['image']['name'][0] != ''){
                for ($i=0; $i < $aumontFiles; $i++) { 
                    $imagensAtual = ['type'=>$_FILES['image']['type'][$i],'size'=>$_FILES['image']['size'][$i]];
                    if(Painel::imagemValida($imagensAtual) == false){
                        $sucesso = false;
                        Painel::AtualizarAlerta('erro','Uma das imagens não são validas.');
                        break;
                    }
                }
            }

            if($sucesso){

                if($_FILES['image']['name'][0] != ''){
                    for ($i=0; $i < $aumontFiles; $i++) { 
                        $imagensAtual = ['tmp_name'=>$_FILES['image']['tmp_name'][$i], 'name'=>$_FILES['image']['name'][$i]];
                        $imagens[] = Painel::updateImage($imagensAtual);
                    }

                    foreach ($imagens as $key => $value) {
                        $updateImagem = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque_imagens` VALUES(null,?,?)");
                        $updateImagem->execute([$id,$value]);
                    }
                }

                $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET nome = ?, descricao = ?, largura = ?, altura = ?, comprimento = ?, peso = ?, quantidade = ? WHERE id = ?");
                $sql->execute([$nome,$descricao,$largura,$altura,$comprimento,$peso,$quantidade, $id]);
                Painel::AtualizarAlerta('sucesso','O produto foi atualizado com sucesso!');

                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
                $sql->execute([$id]);
                $infoProduto = $sql->fetch();
                $todasImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
                $todasImagens->execute([$id]);
                $todasImagens = $todasImagens->fetchAll();

            }

        }


    ?>

 

        <div class="alinhe-inputs">
            <label>Nome do Produto:</label>
            <input type="text" name="nome_produto" value="<?php echo $infoProduto['nome'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Descricao:</label>
            <textarea name="descricao" placeholder="Escreva as informações dos produtos..."><?php echo $infoProduto['descricao']; ?></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Largura:</label>
            <input type="number" name="largura" value="<?php echo $infoProduto['largura']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Altura:</label>
            <input type="number" name="altura" value="<?php echo $infoProduto['altura']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Comprimento:</label>
            <input type="number" name="comprimento" value="<?php echo $infoProduto['comprimento']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Peso:</label>
            <input type="number" name="peso" value="<?php echo $infoProduto['peso']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Quantidade atual do produto:</label>
            <input type="number" name="quantidade" value="<?php echo $infoProduto['quantidade']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Selecione as imagem:</label>
            <input multiple type="file" name="image[]">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="atualizar" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

    <div class="card-title">
        <h2><i class="fas fa-rocket" aria-hidden="true"></i> Imagens do produto:</h2>
    </div><!--card-title-->

    <div class="alinhe-box-produto">

        <?php foreach ($todasImagens as $key => $value) { ?>

            <div class="box-cliente">
                <div class="avatar-perfil-edite">
                    <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $value['imagem']; ?>" alt="">
                </div><!--avatar-perfil-->
                <a href="<?php echo INCLUDE_PATH_PAINEL ?>edite-produto?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem']; ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
            </div><!--box-cliente-->

        <?php } ?>

    </div>

</div>