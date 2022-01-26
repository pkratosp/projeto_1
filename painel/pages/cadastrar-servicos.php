<?php verificaPermissaoPagina(2); ?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post">

        <?php
            if(isset($_POST['acao'])){

                if(Painel::InserirServicos($_POST)){
                    Painel::AtualizarAlerta('sucesso','O serviço foi cadastrado com sucesso');
                }else{
                    Painel::AtualizarAlerta('erro','Ocorreu um erro não foi possivel cadastrar');
                }

            }
        ?>
        <div class="alinhe-inputs">
            <label>Servicos:</label>
            <textarea name="servicos" placeholder="Serviços..."></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="hidden" name="order_id" value="0">
            <input type="hidden" name="nome_tabela" value="tb_site.servicos">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>