<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar Slides</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php //enctype="multipart/form-data" sem isso o updload de imagem nao funciona 

            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
                $slides = Painel::select('tb_site.slides','id=?',array($id));
            }else{
                Painel::AtualizarAlerta('erro','Passe o ID para continuar!');
                die();
            }

            if(isset($_POST['acao'])){
                $nome = $_POST['nome'];
                $imagem = $_FILES['image'];
                $imageAtual = $_POST['imagem_atual'];

                if($imagem['name'] != ''){
                    
                    if(Painel::imagemValida($imagem)){
                        Painel::deleteImagem($imageAtual);
                        $imagem = Painel::updateImage($imagem);
                        $arr = ['nome'=>$nome,'slide'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_site.slides'];
                        //a egente usou o update porque as info ja existia entao tinha que atualizalas
                        Painel::update($arr);
                        $slides = Painel::select('tb_site.slides','id=?',array($id));
                        Painel::AtualizarAlerta('sucesso','O slide foi atualizado com a imagem!');
                    }

                }else{
                    $imagem = $imageAtual;
                    $arr = ['nome'=>$nome,'slide'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_site.slides'];
                    Painel::update($arr);
                    $slides = Painel::select('tb_site.slides','id=?',array($id));
                    Painel::AtualizarAlerta('sucesso','O slide foi atualizado com sucesso.');
                }

            }
                
            

        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" required value="<?php echo $slides['nome'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image">
            <input type="hidden" name="imagem_atual" value="<?php echo $slides['slide'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

</div>