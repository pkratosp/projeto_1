<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Gerenciador de categorias</h2>
	</div><!--info-empresa-->
    <div class="wraper-table">
    <table>
        <?php 
            if(isset($_GET['excluir'])){
                $idExcluir = intval($_GET['excluir']);
                Painel::deletar('tb_site.categorias',$idExcluir);
            }else if(isset($_GET['order']) && isset($_GET['id'])){
                Painel::ordemItem('tb_site.categorias',$_GET['order'],$_GET['id']);
            }

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $porPagina = 4;
            $catogorias = Painel::SelectAll('tb_site.categorias', ($paginaAtual - 1) * $porPagina, $porPagina);
        ?>

        <tr>
            <td>Nome</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
        </tr>

        <?php foreach ($catogorias as $key => $value) { ?>

            <tr>
                <td><?php echo $value['nome'] ?></td>
                <td><a class="btn-options edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-categoria?id=<?php echo $value['id'] ?>"><i class="far fa-edit"></i> Editar</a></td>
                <td><a acationBtn="delete" class="btn-options delete" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categoria?excluir=<?php echo $value['id']; ?>"><i class="fas fa-minus-circle"></i> Excluir</td></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categoria?order=up&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-up"></i></a></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categoria?order=down&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-down"></i></a></td>
            </tr>

        <?php } ?>
    </table>
    </div><!--wraper-table-->

    <div class="paginacao">
        <?php 
            $totalPagina = ceil(count(Painel::SelectAll('tb_site.categorias')) / $porPagina);

            for($i = 1; $i <= $totalPagina; $i++){
                if($i == $paginaAtual){
                    echo '<a class="pag-select" href="'.INCLUDE_PATH_PAINEL.'gerenciar-categoria?pagina='.$i.'">'.$i.'</a>';
                }else{
                    echo'<a href="'.INCLUDE_PATH_PAINEL.'gerenciar-categoria?pagina='.$i.'">'.$i.'</a>';
                }
            }

        ?>
    </div><!--paginacao-->

</div><!--box-content-->