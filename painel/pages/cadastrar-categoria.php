<?php verificaPermissaoPagina(2); ?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Categoria</h2>
	</div><!--info-empresa-->

    <form method="post">

        <?php
            if(isset($_POST['acao'])){

                $nome = $_POST['categoria'];

                if($nome == ''){
                    Painel::AtualizarAlerta('erro','O campo não pode estar vazio');
                }else{

                    $verificar = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE  nome = ?");
                    $verificar->execute(array($nome));
                    if($verificar->rowCount() == 0){
                        //quer dizer que nao existe e ta disponivel
                        $slug = Painel::generateSlug($nome);
                        $arr = ['nome'=>$nome,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.categorias'];
                        Painel::IncerirDepoimento($arr);
                        Painel::AtualizarAlerta('sucesso','A categoria foi cadastrada com sucesso.');
                    }else {
                        //existe e nao está disponivel
                        Painel::AtualizarAlerta('erro','A categoria já existe tente outra.');
                    }

                }

            }
        ?>
        <div class="alinhe-inputs">
            <label>Categoria:</label>
            <input type="text" name="categoria" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>