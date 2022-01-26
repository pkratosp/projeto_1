<?php verificaPermissaoPagina(2); ?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php
            if(isset($_POST['acao'])){

                if(Painel::IncerirDepoimento($_POST)){
                    Painel::AtualizarAlerta('sucesso','Os depoimentos foi cadastrado sucesso.');
                }else{
                    Painel::AtualizarAlerta('erro','Não foi possivel cadastrar o depoimento.');
                }

            }
        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="user" name="user" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Depoimento:</label>
            <textarea name="depoimento" placeholder="Depoimento"></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Data:</label>
            <input formato="data" type="text" name="data" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="hidden" name="order_id" value="0">
            <input type="hidden" name="nome_tabela" value="tb_site.depoimentos">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>