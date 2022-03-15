<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Visualizar Empreendimento</h2>
	</div><!--info-empresa-->

	<div class="box-visualizar">

		<div class="row1">
			<div class="card-title-color">
				<h2><i class="fas fa-image"></i> Imagem do empreendimento:</h2>
			</div><!--card-title-->

			<div class="avatar-perfil">
				<img src="http://localhost/projeto_1/painel/uploades/6230f9cd1bc5a.jpeg">
			</div><!--avatar-perfil-->

		</div><!--row1-->

		<div class="row2">

			<div class="card-title-color">
				<h2><i class="fas fa-image"></i> Informações do Empreendimento:</h2>
			</div><!--card-title-->

			<div class="info-empreendimento">
				<p><i class="fas fa-pen-square" aria-hidden="true"></i> Nome do empreendimento: Empreendimento3</p>
				<p><i class="fas fa-pen-square" aria-hidden="true"></i> Tipo: Residencial</p>
			</div><!--info-empreendimento-->
			
		</div><!--row2-->
	
	</div><!--alinhe-flex-->

	<div class="card-title">
		<h2>Cadastrar Imóvel</h2>
	</div>

	<form method="post" enctype="multipart/form-data">

        <?php 
        
        
        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Área:</label>
            <input type="text" name="area">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Preço:</label>
            <input type="text" name="preco">
        </div><!--alinhe-inputs-->


        <div class="alinhe-inputs">
            <label>Imagens:</label>
            <input multiple type="file" name="image[]">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

	<div class="wraper-table">
    <table>
        <?php 
            
            if(isset($_GET['excluir'])){
                $idExcluir = (int)$_GET['excluir'];
                Painel::deletar('tb_site.depoimentos',$idExcluir);
            }else if(isset($_GET['order']) && isset($_GET['id'])){
                Painel::ordemItem('tb_site.depoimentos',$_GET['order'],$_GET['id']);
            }

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $porPagina = 4;
            $depoimentos = Painel::SelectAll('tb_site.depoimentos', ($paginaAtual - 1) * $porPagina, $porPagina);
        ?>

        <tr>
            <td>Nome</td>
            <td>Preço</td>
            <td>Área</td>
            <td>#</td>
        </tr>

        <?php foreach ($depoimentos as $key => $value) { ?>

            <tr>
                <td><?php echo $value['nome']; ?></td>
                <td><?php echo $value['depoimento']; ?></td>
                <td><?php echo $value['data']; ?></td>
                <td><a acationBtn="delete" class="btn-options delete" href="<?php echo INCLUDE_PATH_PAINEL; ?>listar-depoimentos?excluir=<?php echo $value['id']; ?>"><i class="fas fa-minus-circle"></i> Excluir</td></td>
            </tr>

        <?php } ?>
    </table>
    </div><!--wraper-table-->
    
    <div class="paginacao">
        <?php 
            $totalPagina = ceil(count(Painel::SelectAll('tb_site.depoimentos')) / $porPagina);
            
            for($i = 1; $i <= $totalPagina; $i++){
                if($i == $paginaAtual){
                    echo '<a class="pag-select" href="'.INCLUDE_PATH_PAINEL.'listar-depoimentos?pagina='.$i.'">'.$i.'</a>';
                }else{
                    echo'<a href="'.INCLUDE_PATH_PAINEL.'listar-depoimentos?pagina='.$i.'">'.$i.'</a>';
                }
            }

        ?>
    </div><!--paginacao-->
  
</div>