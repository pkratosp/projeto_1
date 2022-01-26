<?php 

verificaPermissaoPagina(2); 



?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Email:</label>
            <input type="text" name="email" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Tipo:</label>
            <select name="tipo_cliente" required>
                <option value="fisico">Físico</option>
                <option value="juridico">Jurídico</option>
            </select>
        </div><!--alinhe-inputs-->

        <div rel="cpf" class="alinhe-inputs">
            <label>CPF:</label>
            <input type="text" name="cpf" required>
        </div><!--alinhe-inputs-->

        <div style="display:none;" rel="cnpj" class="alinhe-inputs">
            <label>CNPJ:</label>
            <input type="text" name="cnpj" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>