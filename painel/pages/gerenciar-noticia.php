<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Gerenciar notícias</h2>
	</div><!--info-empresa-->

    <table>
        <?php 
            if(isset($_GET['excluir'])){
                $idExcluir = intval($_GET['excluir']);
                $selecione = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE id = ?");
                $selecione->execute(array($idExcluir));
                
                $imagem = $selecione->fetch()['capa'];
                Painel::deletar('tb_site.noticias',$idExcluir);
                Painel::deleteImagem($imagem);
            }else if(isset($_GET['order']) && isset($_GET['id'])){
                Painel::ordemItem('tb_site.noticias',$_GET['order'],$_GET['id']);
            }

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $porPagina = 4;
            $noticias = Painel::SelectAll('tb_site.noticias', ($paginaAtual - 1) * $porPagina, $porPagina);
        ?>

        <tr>
            <td>Título</td>
            <td>Categoria</td>
            <td>Capa</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
        </tr>

        <?php foreach ($noticias as $key => $value) { ?>
        <?php $categoria = Painel::select('tb_site.categorias','id=?',array($value['categoria_id']))['nome'];
        ?>
            <tr>
                <td><?php echo $value['titulo'] ?></td>
                <td><?php echo $categoria ?></td>
                <td><img style="width: 50px;height:50px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo  $value['capa']; ?>"></td>
                <td><a class="btn-options edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-noticias?id=<?php echo $value['id'] ?>"><i class="far fa-edit"></i> Editar</a></td>
                <td><a acationBtn="delete" class="btn-options delete" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticia?excluir=<?php echo $value['id']; ?>"><i class="fas fa-minus-circle"></i> Excluir</td></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticia?order=up&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-up"></i></a></td>
                <td><a class="btn-options seta" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticia?order=down&id=<?php echo $value['id'] ?>"><i class="fas fa-chevron-down"></i></a></td>
            </tr>

        <?php } ?>
    </table>

    <div class="paginacao">
        <?php 
            $totalPagina = ceil(count(Painel::SelectAll('tb_site.noticias')) / $porPagina);

            for($i = 1; $i <= $totalPagina; $i++){
                if($i == $paginaAtual){
                    echo '<a class="pag-select" href="'.INCLUDE_PATH_PAINEL.'gerenciar-noticia?pagina='.$i.'">'.$i.'</a>';
                }else{
                    echo'<a href="'.INCLUDE_PATH_PAINEL.'gerenciar-noticia?pagina='.$i.'">'.$i.'</a>';
                }
            }

        ?>
    </div><!--paginacao-->

</div><!--box-content-->