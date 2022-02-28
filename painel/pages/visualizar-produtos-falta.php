<div class="box-content">

<div class="info-empresa">
        <h2><i class="far fa-address-card"></i> <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Produtos no estoque</a> » Produtos em falta</h2>
</div><!--info-empresa-->

<div class="box-display-cliente">

    <?php 
    
    if(isset($_POST['atualizar'])){
        $quantidade = $_POST['quantidade_atualizar'];
        $produto_id = $_POST['produto_id'];
        if($quantidade <= 0){
            Painel::AtualizarAlerta('erro','Você não pode atualizar a quantidade para 0 ou menor que 0');
        }else{
            $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET quantidade = ? WHERE id = ?");
            $sql->execute([$quantidade,$produto_id]);
            Painel::AtualizarAlerta('sucesso','Você atualizou a quantidade do produto com id: <b>'.$produto_id.'</b>');
        }
    }

    @$pdo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = ?");
    $pdo->execute([0]);
    $produtos = $pdo->fetchAll();
    if(count($produtos) > 0){
        Painel::AtualizarAlerta('atencao','Todos os produtos listados estão em falta no estoque!');
    }else{
        Painel::AtualizarAlerta('sucesso','Tudo certo, você não possui produtos em falta!');
    }
    foreach ($produtos as $key => $value) {
    
        $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
        $imagemSingle->execute([$value['id']]);
        $imagemSingle = $imagemSingle->fetch()['imagem'];

    ?>

    <div class="box-cliente">
        <div class="avatar-perfil">
         
            <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $imagemSingle ?>" alt="<?php echo $value['nome']; ?>">
    
        </div>

        <div class="info-cliente">
            <p><div class="bold-black">Nome: </div> <?php echo $value['nome']; ?></p>
            <p><div class="bold-black">Descrição: </div><?php echo substr($value['descricao'],0,120); ?>...</p>
            <p><div class="bold-black">Largura: </div><?php echo $value['largura']; ?></p>
            <p><div class="bold-black">Altura: </div><?php echo $value['altura']; ?></p>
            <p><div class="bold-black">Comprimento: </div><?php echo $value['comprimento']; ?></p>
            <p><div class="bold-black">Peso: </div><?php echo $value['peso']; ?></p>
            <p><div class="bold-black">Quantidade: </div><?php echo $value['quantidade']; ?></p>

            <form class="quantidade" method="post">
                <p>Atualizar quantidade</p>
                <input type="number" name="quantidade_atualizar" value="<?php echo $value['quantidade']; ?>">
                <input type="hidden" name="produto_id" value="<?php echo $value['id'] ?>">
                <input type="submit" name="atualizar" value="Atualizar">
            </form>

            <a href="<?php echo INCLUDE_PATH_PAINEL ?>edite-produto?id=<?php echo $value['id'] ?>" class="btn-editar-cliente edit"><i class="far fa-edit" aria-hidden="true"></i> Editar</a>
            <a acationBtn="delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?excluir=<?php echo $value['id'] ?>" class="btn-excluir-cliente delete"><i class="fas fa-minus-circle" aria-hidden="true"></i> Excluir</a>
          
        </div>

        
        
    </div><!--box-cliente-->

    <?php } ?>

</div><!--box-display-cliente-->

</div><!--box-content-->

