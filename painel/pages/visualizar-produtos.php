<?php 

    if(isset($_GET['pendentes']) == false){

?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Produtos no estoque</a></h2>
	</div><!--info-empresa-->

    <div class="busca-cliente">
        <form method="post">
            <h2>Buscar pelos produtos</h2>
            <input type="text" name="busca" placeholder="Digite o nome, descrição, quantidade, peso, largura ou altura.">
            <input type="submit" name="buscar_produto" value="Buscar">
        </form>
    </div>

    <div class="box-display-cliente">

        <?php 
        
            if(isset($_POST['atualizar'])){
                $quantidade = $_POST['quantidade_atualizar'];
                $produto_id = $_POST['produto_id'];
                if($quantidade < 0){
                    Painel::AtualizarAlerta('erro','Você não pode atualizar a quantidade para menor que 0');
                }else{
                    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET quantidade = ? WHERE id = ?");
                    $sql->execute([$quantidade,$produto_id]);
                    Painel::AtualizarAlerta('sucesso','Você atualizou a quantidade do produto com id: <b>'.$produto_id.'</b>');
                }
            }

            if(isset($_GET['excluir'])){
                $id = (int)$_GET['excluir'];
                $Imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
                $Imagens->execute([$id]);
                foreach ($Imagens as $key => $value) {
                    @unlink(BASE_DIR_PAINEL.'/uploades/'.$value['imagem']);
                }
                $excluir = MySql::conectar()->prepare("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
                $excluir->execute([$id]);
                $excluir = MySql::conectar()->prepare("DELETE FROM `tb_admin.estoque` WHERE id = ?");
                $excluir->execute([$id]);
                Painel::AtualizarAlerta('sucesso','Você excluiu o item do estoque.');
            }

            $pdoBanco = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = ?");
            $pdoBanco->execute([0]);
            if($pdoBanco->rowCount() > 0){
                Painel::AtualizarAlerta('atencao','Você está com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">aqui</a> para visualiza-los!');
            }

            $query = "";
            if(isset($_POST['buscar_produto'])){
                $nome = $_POST['busca'];
                $query = "WHERE (nome LIKE '%$nome%' OR descricao LIKE '%$nome%')";
            }

            if($query == ''){
                $query2 = "WHERE quantidade > ?";
            }else{
                $query2 = "AND quantidade > ?";
            }

        
            @$pdo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");

            if($query == ''){
                $pdo->execute([0]);
            }else{
                $pdo->execute([0]);
            }
            $produtos = $pdo->fetchAll();

            foreach ($produtos as $key => $value) {
            
                $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
                $imagemSingle->execute([$value['id']]);
                $imagemSingle = $imagemSingle->fetch()['imagem'];

        ?>

        <div class="box-cliente">
            <div class="avatar-perfil">
             
                <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $imagemSingle ?>" alt="<?php echo $value['nome']; ?>">
        
            </div>

            <div class="info-cliente">
                <p>Nome: <?php echo $value['nome']; ?></p>
                <p>descrição: <?php echo $value['descricao']; ?></p>
                <p>Largura: <?php echo $value['largura']; ?></p>
                <p>Altura: <?php echo $value['altura']; ?></p>
                <p>Comprimento: <?php echo $value['comprimento']; ?></p>
                <p>Peso: <?php echo $value['peso']; ?></p>
                <p>Quantidade: <?php echo $value['quantidade']; ?></p>

                <form class="quantidade" method="post">
                    <p>Atualizar quantidade</p>
                    <input type="number" name="quantidade_atualizar" value="<?php echo $value['quantidade']; ?>">
                    <input type="hidden" name="produto_id" value="<?php echo $value['id'] ?>">
                    <input type="submit" name="atualizar" value="Atualizar">
                </form>

                <a href="<?php echo INCLUDE_PATH_PAINEL ?>edite-produto?id=<?php echo $value['id'] ?>" class="btn-editar-cliente edit"><i class="far fa-edit" aria-hidden="true"></i> Editar</a>
                <a acationBtn="delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?excluir=<?php echo $value['id'] ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
              
            </div>

            
            
        </div><!--box-cliente-->

        <?php } ?>

    </div><!--box-display-cliente-->

</div><!--box-content-->

<?php }else{ 
    include('visualizar-produtos-falta.php');
} ?>