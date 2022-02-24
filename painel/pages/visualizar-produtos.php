<?php 

    if(isset($_GET['excluir'])){
        $idExcluir = $_GET['excluir'];
        $selecione = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = ?");
        $selecione->execute([$idExcluir]);

        $imagem = $selecione->fetch()['image'];
        Painel::deletar('tb_admin.clientes',$idExcluir);
        Painel::deleteImagem($imagem);
    }

    if(isset($_POST['buscar_produto'])){
        $busca = $_POST['busca'];
        $query = " WHERE nome LIKE '%$busca%' OR descricao LIKE '%$busca%' OR largura LIKE '%$busca%' OR altura LIKE '%$busca%' OR comprimento LIKE '%$busca%' OR peso LIKE '%$busca%' OR quantidade LIKE '%$busca%' ";
    }

    @$pdo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query");
    $pdo->execute();
    $produtos = $pdo->fetchAll();


?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Gerenciar produtos</h2>
	</div><!--info-empresa-->

    <div class="busca-cliente">
        <form method="post">
            <h2>Buscar pelos produtos</h2>
            <input type="text" name="busca" placeholder="Digite o nome, descrição, quantidade, peso, largura ou altura.">
            <input type="submit" name="buscar_produto" value="Buscar">
            <?php 
                if(isset($_POST['buscar_produto'])){
                    echo'Foram encontrados <b>'.count($produtos).'</b> resultado(s)';
                }
            ?>
        </form>
    </div>

    <div class="box-display-cliente">

        <?php foreach ($produtos as $key => $value) {
        
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
                <a href="<?php echo INCLUDE_PATH_PAINEL ?>edite-produto?id=<?php echo $value['id'] ?>" class="btn-editar-cliente edit"><i class="far fa-edit" aria-hidden="true"></i> Editar</a>
                <a acationBtn="delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?excluir=<?php echo $value['id'] ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
              
            </div>
            
        </div><!--box-cliente-->

        <?php } ?>

    </div><!--box-display-cliente-->

</div><!--box-content-->