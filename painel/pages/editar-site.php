<?php 
    $editarSite = MySql::conectar()->prepare("SELECT * FROM `tb_admin.confg`");
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
                    $editarSite = MySql::conectar()->prepare("SELECT * FROM `tb_admin.confg`");
                    $editarSite->execute();
                    $editarSite = $editarSite->fetch();
                }else{
                    Painel::AtualizarAlerta('erro','O depoimento não foi editado.');
                }
            }
        ?>

        <div class="alinhe-inputs">
            <label>Nome do site:</label>
            <input type="text" name="titulo_site" value="<?php echo $editarSite['titulo_site']; ?>" >
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Nome do autor do site:</label>
            <input type="text" name="nome_author" value="<?php echo $editarSite['nome_author']; ?>" >
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Descrição do autor do site:</label>
            <textarea name="descri_author" placeholder="depoimentos"><?php echo $editarSite['descri_author']; ?></textarea>
        </div><!--alinhe-inputs-->
        
        <?php for($i = 1; $i <= 6; $i++){ ?>

        <div class="alinhe-inputs">
            <label>Icone <?php echo $i; ?>:</label>
            <input type="text" name="icone<?php echo $i?>" value="<?php echo $editarSite['icone'.$i]; ?>" >
        </div><!--alinhe-inputs-->       

        <div class="alinhe-inputs">
            <label>Descrição <?php echo $i; ?>:</label>
            <textarea name="descri<?php echo $i ?>"><?php echo $editarSite['descri'.$i] ?></textarea>
        </div><!--alinhe-inputs-->       

        <?php } ?>

        <div class="alinhe-inputs">
            <input type="hidden" name="nome_tabela" value="tb_admin.confg">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>