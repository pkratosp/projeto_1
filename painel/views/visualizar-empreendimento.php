<?php 

$id = $par[2];

$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE id = ?");
$sql->execute([$id]);

$infoEmpreendimento = $sql->fetch();

if($infoEmpreendimento['nome'] == ''){
    header('Location: '.INCLUDE_PATH_PAINEL);
    die();
}

?>
<div class="box-content">

	<div class="info-empresa">
			<h2><i class="far fa-address-card"></i> Visualizar Empreendimento</h2>
	</div><!--info-empresa-->

	<div class="box-visualizar">

		<div class="row1">
			<div class="card-title-color">
				<h2><i class="fas fa-image"></i> Imagem do empreendimento:</h2>
			</div><!--card-title-->

			<div class="avatar-perfil">
				<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $infoEmpreendimento['imagem'] ?>">
			</div><!--avatar-perfil-->

		</div><!--row1-->

		<div class="row2">

			<div class="card-title-color">
				<h2><i class="fas fa-image"></i> Informações do Empreendimento:</h2>
			</div><!--card-title-->

			<div class="info-empreendimento">
				<p><i class="fas fa-pen-square" aria-hidden="true"></i> Nome do empreendimento: <?php echo $infoEmpreendimento['nome'] ?></p>
				<p><i class="fas fa-pen-square" aria-hidden="true"></i> Tipo: <?php echo $infoEmpreendimento['tipo'] ?></p>
			</div><!--info-empreendimento-->
			
		</div><!--row2-->
	
	</div><!--alinhe-flex-->

	<div class="card-title">
		<h2>Cadastrar Imóvel</h2>
	</div>

	<form method="post" enctype="multipart/form-data">

        <?php 
            
            if(isset($_POST['acao'])){

                $emprendId = $id;
                $nome = $_POST['nome'];
                $preco = Painel::formateMoedaBd($_POST['preco']);
                $area = $_POST['area'];

                $imagens = [];
                $aumontFiles = count($_FILES['image']['name']);
                $sucesso = true;

                if($_FILES['image']['name'][0] != ''){
                    for ($i=0; $i < $aumontFiles; $i++) { 
                        $imagensAtual = ['type'=>$_FILES['image']['type'][$i],'size'=>$_FILES['image']['size'][$i]];
                        if(Painel::imagemValida($imagensAtual) == false){
                            $sucesso = false;
                            Painel::AtualizarAlerta('erro','As imagens não são validas!');
                            break;
                        }
                    }
                }else{
                    $sucesso = false;
                    Painel::AtualizarAlerta('erro','Você precisa selecionar uma imagem!');
                }

                if($sucesso){
                    for ($i=0; $i < $aumontFiles; $i++) { 
                        $imagensAtual = ['tmp_name'=>$_FILES['image']['tmp_name'][$i],'name'=>$_FILES['image']['name'][$i]];
                        $imagens[] = Painel::updateImage($imagensAtual);
                    }

                    $pdo = MySql::conectar()->prepare("INSERT INTO `tb_admin.imoveis` VALUES (null,?,?,?,?,?)");
                    $pdo->execute([$emprendId,$nome,$preco,$area,0]);
                    $last_id = MySql::conectar()->lastInsertId();
                    foreach ($imagens as $key => $value) {
                        $pdo = MySql::conectar()->prepare("INSERT INTO `tb_admin.imagens_imoveis` VALUES(null,?,?)");
                        $pdo->execute([$last_id,$value]);
                    }

                    Painel::AtualizarAlerta('sucesso','Você cadastrou o imóvel com sucesso.');

                }
                

            }
        
        ?>

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Área:</label>
            <input type="text" name="area">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Preço:</label>
            <input type="text" name="preco">
        </div><!--alinhe-inputs-->


        <div class="alinhe-inputs">
            <label>Imagens:</label>
            <input multiple type="file" name="image[]">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

	<div class="wraper-table">
    <table>
        <tr>
            <td>Nome</td>
            <td>Preço</td>
            <td>Área</td>
            <td>#</td>
        </tr>

        <?php
            $imoveis = Painel::SelectQuery('tb_admin.imoveis','empreend_id=?',[$id]);
            foreach ($imoveis as $key => $value) { 
                $value['preco'] = Painel::convertMoney($value['preco']);    
        ?>

            <tr>
                <td><?php echo $value['nome']; ?></td>
                <td>R$<?php echo $value['preco']; ?></td>
			    <td><?php echo $value['area']; ?>m²</td>
                <td><a class="btn-options visu" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-imovel/<?php echo $value['id']; ?>"><i class="fas fa-eye" aria-hidden="true"></i> Visualizar</td></td>
            </tr>

        <?php } ?>
    </table>
    </div><!--wraper-table-->
    
</div>