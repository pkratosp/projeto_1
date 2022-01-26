<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Notícias</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

    <?php  
                
            if(isset($_POST['acao'])){
                $titulo = $_POST['titulo'];
                $categoria_id = $_POST['categoria_id'];
                $noticia = $_POST['noticia'];
                $imagem = $_FILES['image'];
                $data = date('Y-m-d H:i:s');
                $slug = Painel::generateSlug($titulo);
                if($titulo == ''){
                    Painel::AtualizarAlerta('erro','O campo título está vazio');
                }else if($noticia == ''){
                    Painel::AtualizarAlerta('erro','O campo noticia está vazio');
                }else if($imagem['name'] == ''){
                    Painel::AtualizarAlerta('erro','Você não selecionou uma imagem');
                }else if($imagem['name'] != ''){
                    //existe imagem
                    if(Painel::imagemValida($imagem)){
                        $banco = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE titulo=? AND categoria_id = ?");
                        $banco->execute(array($titulo,$categoria_id));
                        if($banco->rowCount() == 0){

                            $imagem = Painel::updateImage($imagem);
                            $arr = ['categoria_id'=>$categoria_id,'data'=>$data,'titulo'=>$titulo,'conteudo'=>$noticia,'capa'=>$imagem,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.noticias'];
                            if(Painel::IncerirDepoimento($arr)){
                                Painel::AtualizarAlerta('sucesso','A notícia foi cadastrada com sucesso!');
                            }

                        }else {
                            Painel::AtualizarAlerta('erro','Já existe uma noticia com este nome!');
                        }

                    }else{
                        Painel::AtualizarAlerta('erro','A imagem não é valida!');
                    }
                }
            }


    ?>

        <div class="alinhe-inputs">
            <label>Categorias</label>
            <select name="categoria_id">
                <?php 
                    $categorias = Painel::SelectAll('tb_site.categorias');
                    foreach ($categorias as $key => $value) {
                ?>
                <option <?php if($value['id'] == @$_POST['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['nome'] ?></option>

                <?php } ?>
            </select>
		</select>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?php recoverPost('titulo'); ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Notícia:</label>
            <textarea id="mytextarea" name="noticia" placeholder="Escreva sua notícia..."><?php recoverPost('noticia') ?></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

</div>