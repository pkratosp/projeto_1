<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar slides</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <?php //enctype="multipart/form-data" sem isso o updload de imagem nao funciona 

            if(isset($_POST['acao'])){
                $nome = $_POST['nome'];
                $imagem = $_FILES['image'];

                if($nome == ''){
                    Painel::AtualizarAlerta('erro','Campos vazios não são permitidos.');
                }else{
                    if(Painel::imagemValida($imagem) == false){
                        Painel::AtualizarAlerta('erro','O formato da imagem não é valida.');
                    }else{
                        $imagem = Painel::updateImage($imagem);
                        $arr = ['nome'=>$nome,'slide'=>$imagem,'order_id'=>'0','nome_tabela'=>'tb_site.slides'];
                        Painel::IncerirDepoimento($arr);
                        Painel::AtualizarAlerta('sucesso','O slide foi cadastrado com sucesso.');
                        
                    }
                }
            }
                
            

        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome" required>
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