<?php 

    if(isset($_GET['excluir'])){
        $idExcluir = $_GET['excluir'];
        $selecione = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = ?");
        $selecione->execute([$idExcluir]);

        $imagem = $selecione->fetch()['image'];
        Painel::deletar('tb_admin.clientes',$idExcluir);
        Painel::deleteImagem($imagem);
    }

    if(isset($_POST['buscar_cliente'])){
        $busca = $_POST['busca'];
        $query = " WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%' OR tipo LIKE '%$busca%' ";
    }

    @$pdo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` $query");
    $pdo->execute();
    $clientes = $pdo->fetchAll();


?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Gerenciar clientes</h2>
	</div><!--info-empresa-->

    <div class="busca-cliente">
        <form method="post">
            <h2>Buscar Clientes</h2>
            <input type="text" name="busca" placeholder="Digite o nome, email, tipo, cnpj, cpf">
            <input type="submit" name="buscar_cliente" value="Buscar">
            <?php 
                if(isset($_POST['buscar_cliente'])){
                    echo'Foram encontrados <b>'.count($clientes).'</b> resultado(s)';
                }
            ?>
        </form>
    </div>

    <div class="box-display-cliente">

        <?php foreach ($clientes as $key => $value) { ?>

        <div class="box-cliente">
            <div class="avatar-perfil">

                <?php if($value['imagem'] == 'semfoto'){ ?>
                    <i class="fas fa-user"></i>
                <?php }else{ ?>
                
                    <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $value['imagem']; ?>" alt="<?php echo $value['nome']; ?>">

                <?php } ?>

            </div>

            <div class="info-cliente">
                <p>Nome: <?php echo $value['nome'] ?></p>
                <p>Email: <?php echo $value['email'] ?></p>
                <p>Tipo: <?php echo $value['tipo'] ?></p>
                <p>Cpf/Cnpj: <?php echo $value['cpf_cnpj'] ?></p>
                <a href="<?php echo INCLUDE_PATH_PAINEL ?>edite-cliente?id=<?php echo $value['id'] ?>" class="btn-editar-cliente edit"><i class="far fa-edit" aria-hidden="true"></i> Editar</a>
                <a acationBtn="delete" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes?excluir=<?php echo $value['id'] ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
              
            </div>
            
        </div><!--box-cliente-->

        <?php } ?>

    </div><!--box-display-cliente-->

</div><!--box-content-->