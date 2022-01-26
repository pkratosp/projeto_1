<?php 
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $noticia = Painel::select('tb_site.noticias','id=?',array($id));
    }else{
        echo '<script>alert("Você não pode acessar está pagina")</script>';
        die();
    }
?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar Notícias</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

    <?php  
                
            if(isset($_POST['acao'])){
                $titulo = $_POST['titulo'];
                $categoria_id = $_POST['categoria_id'];
                $noticia = $_POST['noticia'];
                $imagem = $_FILES['image'];
                $imagem_atual = $_POST['imagem_atual'];
                $data = date('Y-m-d H:i:s');
                
                $verificar = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE titulo = ? AND categoria_id = ? AND id != ?");
                $verificar->execute(array($titulo,$categoria_id,$id));
                if($verificar->rowCount() == 0){
                    if($imagem['name'] != ''){
                        //existe imagem
                        if(Painel::imagemValida($imagem)){
                            Painel::deleteImagem($imagem_atual);
                            $imagem = Painel::updateImage($imagem);
                            $slug = Painel::generateSlug($titulo);
                            $arr = ['id'=>$id,'categoria_id'=>$categoria_id,'data'=>$data,'titulo'=>$titulo,'conteudo'=>$noticia,'capa'=>$imagem,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.noticias'];
                            Painel::update($arr);
                            $noticia = Painel::select('tb_site.noticias','id=?',array($id));
                            Painel::AtualizarAlerta('sucesso','A notícia foi alterada com a imagem!');
                        }else{
                            Painel::AtualizarAlerta('erro','A imagem não é valida');
                        }
                    }else{
                        //nao tem nova imagem entao continua
                        $imagem = $imagem_atual;
                        $slug = Painel::generateSlug($titulo);
                        $arr = ['id'=>$id,'categoria_id'=>$categoria_id,'data'=>$data,'titulo'=>$titulo,'conteudo'=>$noticia,'capa'=>$imagem,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.noticias'];
                        Painel::update($arr);
                        $noticia = Painel::select('tb_site.noticias','id=?',array($id));
                        Painel::AtualizarAlerta('sucesso','A notícia foi alterada sem a imagem!');

                    }

                }else{
                    Painel::AtualizarAlerta('erro','Já existe um titulo com este nome!');
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
                <option <?php if($value['id'] == $noticia['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['nome'] ?></option>

                <?php } ?>
            </select>
		</select>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo $noticia['titulo'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Notícia:</label>
            <textarea id="mytextarea" name="noticia" placeholder="Escreva sua notícia..."><?php echo $noticia['conteudo'] ?></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="hidden" name="imagem_atual" value="<?php echo $noticia['capa'] ?>">
            <input type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

</div>