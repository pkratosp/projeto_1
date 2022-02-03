<?php 
	if(isset($_GET['logout'])){
		Painel::SairDaSessao();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Painel</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/default/zebra_datepicker.min.css">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css">
	<script src="https://kit.fontawesome.com/e603a9b5dc.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="painel-menu">

	<div class="painel-menu-wraper">
		<div class="box-usuario">


		<?php if($_SESSION['img'] == ''){ ?>

			<div class="avatar">
				<i class="far fa-user"></i>
			</div><!--avatar-->

		<?php } else { ?>

			<div class="usuario-avatar">
				<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploades/<?php echo $_SESSION['img']; ?>" alt="avatar">
			</div><!--usuario-avatar-->

		<?php } ?>

			<div class="descri-cargo">
				<p><?php echo $_SESSION['nome'] ?></p>
				<p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
			</div><!--descri-cargo-->

		</div><!--box-usuario-->

		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Cadastro</h2>
					<ul>
						<li><a <?php SelecioneMenu('cadastrar-depoimentos'); ?>  href="<?php INCLUDE_PATH_PAINEL ?>cadastrar-depoimentos">Cadastrar depoimento</a></li>
						<li><a <?php SelecioneMenu('cadastrar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-servicos">Cadastrar Serviços</a></li>
						<li><a <?php SelecioneMenu('cadastrar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-slides">Cadastrar Slides</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->
			
		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Gestão</h2>
					<ul>
						<li><a <?php SelecioneMenu('listar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos">Listar depoimentos</a></li>
						<li><a <?php SelecioneMenu('listar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos">Listar Serviços</a></li>
						<li><a <?php SelecioneMenu('listar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides">Listar Slides</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->

		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Adiministração do painel</h2>
					<ul>
						<li><a <?php SelecioneMenu('editar-usuario'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php INCLUDE_PATH_PAINEL ?>editar-usuario">Editar usuário</a></li>
						<li><a <?php SelecioneMenu('adicionar-usuario'); ?> <?php verificaPermissaoPagina(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario">Adicionar usuário</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->

		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Configurações geral</h2>
					<ul>
						<li><a <?php SelecioneMenu('editar'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-site">Editar</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->

		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Gestão de Notícias</h2>
					<ul>
						<li><a <?php SelecioneMenu('cadastrar-categoria'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-categoria">Cadastrar Categoria</a></li>
						<li><a <?php SelecioneMenu('gerenciar-categoria'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categoria">Gerenciar Categoria</a></li>
						<li><a <?php SelecioneMenu('cadastrar-noticia'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-noticia">Cadastrar Notícia</a></li>
						<li><a <?php SelecioneMenu('gerenciar-noticia'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticia">Gerenciar Notícia</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->


		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Gestão de Clientes</h2>
					<ul>
						<li><a <?php SelecioneMenu('cadastrar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-clientes">Cadastrar Clientes</a></li>
						<li><a <?php SelecioneMenu('gerenciar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes">Gerenciar Clientes</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->


		<div class="servicos-painel">
			<div class="box-opitions">
					<h2>Controle Financero</h2>
					<ul>
						<li><a <?php SelecioneMenu('visualizar-pagamentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos">Visualizar pagamentos</a></li>
					</ul>
			</div><!--box-opitions-->
		</div><!--servicos-painel-->


	</div><!--painel-menu-wraper-->
</div><!--painel--menu-->

<header class="header-topo">
	<div class="alinhe-flex">
		<div class="menu">
			<i class="fas fa-align-center"></i>
		</div><!--menu-->

			<a class="pagina-inicial" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fas fa-home"></i>Página Inicial</a>
	

		<div class="logout">
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>?logout"><i class="fas fa-sign-out-alt"></i>Sair</a>
		</div>
	</div><!--alinhe-flex-->
</header>


<div class="content">
	
<?php Painel::CarregarPage(); ?>

</div><!--content-->

<div class="clear"></div>



<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/zebra_datepicker@1.9.13/dist/zebra_datepicker.min.js"></script>
<?php Painel::CarregarJs(['jquery.maskMoney.js'],'cadastrar-clientes') ?>
<script>
  tinymce.init({
	selector: '#mytextarea',
	plugins: 'image',
	height:300
  });
</script>


</body>
</html>