<?php 

	$usuariosOnline = Painel::listarUsuariosOnline();

	$vitasTotais = Painel::VisitasTotais();

	$visitasHoje = Painel::VisitasHoje();

?>

<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-home"></i>Bem-vindo a <?php echo Nome_Empresa; ?></h2>
	</div><!--info-empresa-->

	<div class="aline-box-content">
		<div class="informacao-online info-padrao">
				<h2>Usuários Online</h2>
				<p> <?php echo count($usuariosOnline); ?> </p>
		</div><!--informacao-online-->


		<div class="total-visitas info-padrao">
				<h2>Total de visitas</h2>
				<p><?php echo $vitasTotais; ?></p>
		</div><!--total-visitas-->

		<div class="visitas-hoje info-padrao">
				<h2>Visitas Hoje</h2>
				<p> <?php echo $visitasHoje;  ?> </p>
		</div><!--visitas-hoje-->	
	</div><!--alinhe-box-content-->

</div><!--box-content-->


<div class="box-content">
	
	<div class="usuarios-online">
		<h2><i class="fas fa-rocket"></i>Usuarios Online</h2>
	</div><!--usuarios-online-->

	<div class="descri-online">

		
	
		<div class="info-usuarios-online">

			<div class="descri-online-u">
				<p>Ip:</p>
				<p>Ultima ação:</p>
			</div>

			<?php foreach ($usuariosOnline as $key => $value) { ?>

				<div class="info-usuario">
					<p><?php echo $value['ip']; ?></p>
					<p><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])); ?></p>
				</div>
			
			<?php } ?>
				

		</div><!--info-usuarios-online-->

		

	</div><!--descri-online-->

</div><!--box-content-->

<div class="box-content">
	
	<div class="aline-box-content">
	
	</div><!--alinhe-box-content-->

</div><!--box-content-->
