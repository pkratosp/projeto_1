<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Listar empreendimentos</h2>
	</div><!--info-empresa-->

    <div class="busca-cliente">
        <form method="post">
            <h2>Buscar pelos empreendimentos</h2>
            <input type="text" name="busca" placeholder="Digite o nome do empreendimento ou o tipo...">
            <input type="submit" name="buscar_empre" value="Buscar">
        </form>
    </div>

    <div class="box-display-cliente">

        <?php 
        

            if(isset($_GET['excluir'])){
                $id = (int)$_GET['excluir'];
                $Imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE id = ?");
                $Imagens->execute([$id]);
               @$imagem = $Imagens->fetch()['imagem'];
                @unlink(BASE_DIR_PAINEL.'/uploades/'.$imagem);

                $excluir = MySql::conectar()->prepare("DELETE FROM `tb_admin.empreendimentos` WHERE id = ?");
                $excluir->execute([$id]);
                Painel::AtualizarAlerta('sucesso','Você excluiu o empreendimento com sucesso.');
            }

            $query = "";
            if(isset($_POST['buscar_empre'])){
                $busca = $_POST['busca'];
                $query = "WHERE nome LIKE '%$busca%' OR tipo LIKE '%$busca%' ";
            }

            $empreendimento = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` $query ORDER BY order_id ASC");
            $empreendimento->execute();
            foreach ($empreendimento as $key => $value) {

        ?>

        <div id="item-<?php echo $value['id']; ?>" class="box-cliente">
            <div class="avatar-perfil">
             
                <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $value['imagem'] ?>" alt="<?php echo $value['nome']; ?>">
        
            </div>

            <div class="info-cliente">
                <p><div class="bold-black">Nome: </div> <?php echo $value['nome']; ?></p>
                <p><div class="bold-black">Tipo: </div> <?php echo $value['tipo']; ?></p>
                

                <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-empreendimento/<?php echo $value['id'] ?>" class="btn-visualizar-cliente visu"><i class="fas fa-eye"></i>Visualizar</a>
                <a acationBtn="delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimento?excluir=<?php echo $value['id'] ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
              
            </div>

            
            
        </div><!--box-cliente-->

        <?php } ?>

    </div><!--box-display-cliente-->

</div><!--box-content-->
