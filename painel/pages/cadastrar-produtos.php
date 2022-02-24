<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Produtos</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

    <?php 

        if(isset($_POST['acao'])){
            $nome = $_POST['nome_produto'];
            $descricao = $_POST['descricao'];
            $largura = $_POST['largura'];
            $altura = $_POST['altura'];
            $comprimento = $_POST['comprimento'];
            $peso = $_POST['peso'];
            $quantidade = $_POST['quantidade'];

            $imagens = [];
            $aumontFiles = count($_FILES['image']['name']);

            $sucesso = true;

            if($_FILES['image']['name'][0] != ''){

                for($i = 0; $i < $aumontFiles; $i++){
                    $imagensAtual = ['type'=>$_FILES['image']['type'][$i], 'size'=>$_FILES['image']['size'][$i]];
                    if(Painel::imagemValida($imagensAtual) == false){
                        $sucesso = false;
                        Painel::AtualizarAlerta('erro','As imagens não são validas.');
                        break;
                    }
                }

            }else{
                $sucesso = false;
                Painel::AtualizarAlerta('erro','Você deve selecionar uma imagem valida.');
            }

            if($sucesso){

                for($i = 0; $i < $aumontFiles; $i++){
                    $imagensAtual = ['tmp_name'=>$_FILES['image']['tmp_name'][$i],'name'=>$_FILES['image']['name'][$i]];
                    $imagens[] = Painel::updateImage($imagensAtual);
                }

                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUES (null,?,?,?,?,?,?,?)");
                $sql->execute([$nome,$descricao,$largura,$altura,$comprimento,$peso,$quantidade]);
                $last_id = MySql::conectar()->lastInsertId();

                foreach ($imagens as $key => $value) {
                    $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,?,?)");
                    $sql->execute([$last_id,$value]);
                }
                Painel::AtualizarAlerta('sucesso','O produto foi cadastrado com sucesso!');
            }

        }

    ?>
  
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
            <label>Peso:</label>
            <input type="number" name="peso">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Quantidade atual do produto:</label>
            <input type="number" name="quantidade">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Selecione as imagem:</label>
            <input multiple type="file" name="image[]">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>