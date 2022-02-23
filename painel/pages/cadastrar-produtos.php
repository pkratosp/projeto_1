<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Produtos</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">
  
        <div class="alinhe-inputs">
            <label>Nome do Produto:</label>
            <input type="text" name="nome_produto">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Descricao:</label>
            <textarea name="descricao" placeholder="Escreva as informações dos produtos..."></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Largura:</label>
            <input type="number" name="largura">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Altura:</label>
            <input type="number" name="altura">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Comprimento:</label>
            <input type="number" name="comprimento">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input multiple type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>