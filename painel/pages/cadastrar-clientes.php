<?php 

verificaPermissaoPagina(2); 

if(isset($_POST['acao'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo_cliente'];
    $cpf = $_POST['cpf'];
    $cnpj = $_POST['cnpj'];
    $image = $_FILES['image'];

    $infoFinal = $cpf == '' ? $cnpj : $cpf;

        $image = Painel::updateImage($image);
        $arr = ['nome'=>$nome, 'email'=>$email, 'tipo'=>$tipo, 'cpf_cnpj'=>$infoFinal, 'image'=>$image, 'nome_tabela'=>'tb_admin.cliente'];
        Painel::IncerirDepoimento($arr);
        Painel::AtualizarAlerta('true','O cliente foi cadastrado com sucesso.');


}

?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-pen-square"></i> Cadastrar Usuario</h2>
	</div><!--info-empresa-->

    <form method="post" enctype="multipart/form-data">

        <div class="alinhe-inputs">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Email:</label>
            <input type="text" name="email">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Tipo:</label>
            <select name="tipo_cliente">
                <option value="fisico">Físico</option>
                <option value="juridico">Jurídico</option>
            </select>
        </div><!--alinhe-inputs-->

        <div rel="cpf" class="alinhe-inputs">
            <label>CPF:</label>
            <input type="text" name="cpf">
        </div><!--alinhe-inputs-->

        <div style="display:none;" rel="cnpj" class="alinhe-inputs">
            <label>CNPJ:</label>
            <input type="text" name="cnpj">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <label>Imagem:</label>
            <input type="file" name="image">
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--alinhe-inputs-->

    </form>

</div>