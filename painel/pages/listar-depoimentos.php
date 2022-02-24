<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Depoimentos cadastrados</h2>
	</div><!--info-empresa-->
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
            <td>Depoimento</td>
            <td>Data</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
        </tr>

        <?php foreach ($depoimentos as $key => $value) { ?>

            <tr>
                <td><?php echo $value['nome']; ?></td>
                <td><?php echo $value['depoimento']; ?></td>
                <td><?php echo $value['data']; ?></td>
                <td><a class="btn-options edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-depoimentos?id=<?php echo $value['id']; ?>"><i class="far fa-edit"></i> Editar</a></td>
                <td><a acationBtn="delete" class="btn-options delete" href="<?php echo INCLUDE_PATH_PAINEL; ?>listar-depoimentos?excluir=<?php echo $value['id']; ?>"><i class="fas fa-minus-circle"></i> Excluir</td></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos?order=up&id=<?php echo $value['id']; ?>"><i class="fas fa-chevron-up"></i></a></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos?order=down&id=<?php echo $value['id']; ?>"><i class="fas fa-chevron-down"></i></a></td>
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

</div><!--box-content-->