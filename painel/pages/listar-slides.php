<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Slides Cadastrados</h2>
	</div><!--info-empresa-->

    <div class="wraper-table">

    <table>
        <?php 
            if(isset($_GET['excluir'])){
                $idExcluir = intval($_GET['excluir']);
                $selecione = MySql::conectar()->prepare("SELECT * FROM `tb_site.slides` WHERE id = ?");
                $selecione->execute(array($idExcluir));
                
                $imagem= $selecione->fetch()['slide'];
                Painel::deletar('tb_site.slides',$idExcluir);
                Painel::deleteImagem($imagem);
            }else if(isset($_GET['order']) && isset($_GET['id'])){
                Painel::ordemItem('tb_site.slides',$_GET['order'],$_GET['id']);
            }

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $porPagina = 4;
            $slides = Painel::SelectAll('tb_site.slides', ($paginaAtual - 1) * $porPagina, $porPagina);
        ?>

        <tr>
            <td>Nome</td>
            <td>Imagem</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
        </tr>

        <?php foreach ($slides as $key => $value) { ?>

            <tr>
                <td><?php echo $value['nome'] ?></td>
                <td><img style="width: 50px;height:50px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo  $value['slide']; ?>"></td>
                <td><a class="btn-options edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-slides?id=<?php echo $value['id'] ?>"><i class="far fa-edit"></i> Editar</a></td>
                <td><a acationBtn="delete" class="btn-options delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?excluir=<?php echo $value['id']; ?>"><i class="fas fa-minus-circle"></i> Excluir</td></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?order=up&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-up"></i></a></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?order=down&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-down"></i></a></td>
            </tr>

        <?php } ?>
    </table>

    </div><!--wraper-table-->

    <div class="paginacao">
        <?php 
            $totalPagina = ceil(count(Painel::SelectAll('tb_site.slides')) / $porPagina);

            for($i = 1; $i <= $totalPagina; $i++){
                if($i == $paginaAtual){
                    echo '<a class="pag-select" href="'.INCLUDE_PATH_PAINEL.'listar-slides?pagina='.$i.'">'.$i.'</a>';
                }else{
                    echo'<a href="'.INCLUDE_PATH_PAINEL.'listar-slides?pagina='.$i.'">'.$i.'</a>';
                }
            }

        ?>
    </div><!--paginacao-->

</div><!--box-content-->