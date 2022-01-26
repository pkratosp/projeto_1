<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Editar usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php //enctype="multipart/form-data" sem isso o updload de imagem nao funciona 

            if(isset($_POST['acao'])){
                
                
                $nome = $_POST['nome'];
                $senha = $_POST['password'];
                $imagem = $_FILES['image'];
                $imagem_atual = $_POST['imagem_atual'];

                $usuario = new Usuario();
                if($imagem['name'] != ''){

                    if(Painel::imagemValida($imagem)){
                        Painel::deleteImagem($imagem_atual);
                        $imagem = Painel::updateImage($imagem);

                        if($usuario->AtualizarUsuarios($nome,$senha,$imagem)){
                            $_SESSION['img']= $imagem;
                            Painel::AtualizarAlerta('sucesso','As informações foram atualizadas com a imagem');
                        }else{
                            Painel::AtualizarAlerta('erro','Ocorreu um erro ao atualizar com as imagens');
                        }
                    }else{
                        Painel::AtualizarAlerta('erro','O formato da imagem não é valido');
                    }
                }else{
                    $imagem = $imagem_atual;

                    if($usuario->AtualizarUsuarios($nome,$senha,$imagem)){
                        Painel::AtualizarAlerta('sucesso','As informações foram atualizadas com sucesso.');
                    }else{
                        Painel::AtualizarAlerta('erro','Ocorreu um erro inesperado...');
                    }
                }

            }

            //ta dando erro nessa function

        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" required value="<?php echo $_SESSION['user'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Senha:</label>
            <input type="text" name="password" required value="<?php echo $_SESSION['password'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image">
            <input type="hidden" name="imagem_atual" value="<?php echo $_SESSION['img'] ?>">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Atualizar">
        </div><!--alinhe-inputs-->

    </form>

</div>