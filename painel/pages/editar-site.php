<?php 
    $editarSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
    $editarSite->execute();
    $editarSite = $editarSite->fetch();
?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar as informação do site</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php
            if(isset($_POST['acao'])){
                if(Painel::update($_POST,true)){
                    Painel::AtualizarAlerta('sucesso','O site foi editado com sucesso.');
                    $editarSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
                    $editarSite->execute();
                    $editarSite = $editarSite->fetch();
                }else{
                    Painel::AtualizarAlerta('erro','O depoimento não foi editado.');
                }
            }
        ?>

        <div class="alinhe-inputs">
            <label>Nome do site:</label>
            <input type="text" name="titulo" value="<?php echo $editarSite['titulo']; ?>" >
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Nome do autor do site:</label>
            <input type="text" name="nome_autor" value="<?php echo $editarSite['nome_autor']; ?>" >
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Descrição do autor do site:</label>
            <textarea name="descricao" placeholder="depoimentos"><?php echo $editarSite['descricao']; ?></textarea>
        </div><!--alinhe-inputs-->
        
        <?php for($i = 1; $i <= 6; $i++){ ?>

        <div class="alinhe-inputs">
            <label>Icone <?php echo $i; ?>:</label>
            <input type="text" name="icone<?php echo $i?>" value="<?php echo $editarSite['icone'.$i]; ?>" >
        </div><!--alinhe-inputs-->       

        <div class="alinhe-inputs">
            <label>Descrição <?php echo $i; ?>:</label>
            <textarea name="descricao<?php echo $i ?>"><?php echo $editarSite['descricao'.$i] ?></textarea>
        </div><!--alinhe-inputs-->       

        <?php } ?>

        <div class="alinhe-inputs">
            <input type="hidden" name="nome_tabela" value="tb_site.config">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>