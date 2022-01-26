<?php 
    verificaPermissaoPagina(2); 
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $categoria = Painel::select('tb_site.categorias','id = ?',array($id));
    }else{
        Painel::AtualizarAlerta('erro','Você precisa do id para continuar.');
        die();
    }
?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar Categoria</h2>
	</div><!--info-empresa-->

    <form method="post">

        <?php
            if(isset($_POST['acao'])){
                $slug = Painel::generateSlug($_POST['nome']);
                $arr = array_merge($_POST,array('slug'=>$slug));
                $verficar = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE nome = ? AND id != ?");
                $verficar->execute(array($_POST['nome'], $id));

                if($verficar->rowCount() == 1){
                    //existe e nao pode ser alterado
                    Painel::AtualizarAlerta('erro','A categoria já existe porfavor tente outra.');
                }else{
                    if(Painel::update($arr)){
                        Painel::AtualizarAlerta('sucesso','A categoria foi alterada com sucesso.');
                        $categoria = Painel::select('tb_site.categorias','id = ?',array($id));
                    }else{
                        Painel::AtualizarAlerta('erro','A categoria não pode ser atualizada.');
                    }
                }


            }
        ?>

        <div class="alinhe-inputs">
            <label>Categoria:</label>
            <input type="text" name="nome" value="<?php echo $categoria['nome']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="nome_tabela" value="tb_site.categorias">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>