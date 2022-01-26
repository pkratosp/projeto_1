<?php verificaPermissaoPagina(2); ?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php
            if(isset($_POST['acao'])){
                
                $login = $_POST['user'];
                $nome = $_POST['nome'];
                $senha = $_POST['password'];
                $imagem = $_FILES['image'];
                $cargo = $_POST['cargo'];

                if($login == ''){
                    Painel::AtualizarAlerta('erro','O campo login está vazio!');
                    echo'<script>
                            function noRefresh(){
                                return false;
                            }
                        </script>';
                }else if($nome == ''){
                    Painel::AtualizarAlerta('erro','O campo nome está vazio!');
                }else if($senha == ''){
                    Painel::AtualizarAlerta('erro','O campo senha está vazio!');
                }else if($imagem['name'] == ''){
                    Painel::AtualizarAlerta('erro','O campo da imagem está vazio!');
                }else if($cargo == ''){
                    Painel::AtualizarAlerta('erro','O campo cargo está vazio!');
                }else{
                    //pode cadastrar
                    if($cargo > $_SESSION['cargo']){
                        Painel::AtualizarAlerta('erro','Selecione um cargo menor que o seu.');
                    }else if(Painel::imagemValida($imagem) == false){
                        Painel::AtualizarAlerta('erro','A imagem não é valida porfavor tente com outra.');
                    }else if(Usuario::UsuarioExiste($login)){
                        //verificar se já existe um usuario cadastrado ou nao
                        Painel::AtualizarAlerta('erro','O usuario '.$login.' já existe porfavor tente outro nome.');
                    }else{
                        //agora é a incerção dos dados no banco
                        $imagem = Painel::updateImage($imagem);
                        Usuario::CadastrarUsuario($login,$senha,$imagem,$nome,$cargo);
                        Painel::AtualizarAlerta('sucesso','O usuario '.$login.' foi cadastrado com sucesso.');
                    }
                }



            }
        ?>

        <div class="alinhe-inputs">
            <label>Login:</label>
            <input type="text" name="user" name="user" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" name="user" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Senha:</label>
            <input type="text" name="password" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image" required>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Cargo:</label>
            <select name="cargo" required>
                <?php 
                    foreach (Painel::$cargos as $key => $value) {
                        if($key < $_SESSION['cargo']){
                            echo'<option value="'.$key.'">'.$value.'<option/>';
                        }
                    }
                ?>
            </select>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>