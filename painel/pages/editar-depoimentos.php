<?php 
    verificaPermissaoPagina(2); 
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $depoimentos = Painel::select('tb_site.depoimentos','id = ?',array($id));
    }else{
        Painel::AtualizarAlerta('erro','Você precisa do id para continuar.');
        die();
    }
?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php
            if(isset($_POST['acao'])){
                if(Painel::update($_POST)){
                    Painel::AtualizarAlerta('sucesso','O depoimento foi editado com sucesso.');
                    $depoimentos = Painel::select('tb_site.depoimentos','id = ?',array($id));
                }else{
                    Painel::AtualizarAlerta('erro','O depoimento não foi editado.');
                }
            }
        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo $depoimentos['nome']; ?>" >
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Depoimento:</label>
            <textarea name="depoimentos" placeholder="depoimentos"><?php echo $depoimentos['depoimentos']; ?></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Data:</label>
            <input formato="data" type="text" name="data" value="<?php echo $depoimentos['data']; ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="nome_tabela" value="tb_site.depoimentos">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>