<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-comments"></i> Chat Online</h2>
	</div><!--info-empresa-->

    <div class="chat-main">

        <?php 

            $mensagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.chat` ORDER BY id DESC LIMIT 10");
            $mensagens->execute();
            $mensagens = $mensagens->fetchAll();
            $mensagens = array_reverse($mensagens);

            foreach ($mensagens as $key => $value) {
                $nomeUsuario = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
                $nomeUsuario->execute([$value['user_id']]);
                $nomeUsuario = $nomeUsuario->fetch()['nome'];

        ?>
            <div class="chat-mensagem">
                <span><?php echo $nomeUsuario ?></span>
                <p><?php echo $value['mensagem']; ?></p>
            </div><!--chat-mensagem-->

        <?php } ?>


    </div><!--chat-main-->

    <form method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/chat.php">
     
        <div class="alinhe-inputs">
            <textarea name="Mensagem" placeholder="Digite sua mensagem..."></textarea>
        </div><!--alinhe-inputs-->

        <div class="alinhe-inputs">
            <input type="submit" name="enviar" value="Enviar!">
        </div><!--alinhe-inputs-->

    </form>

</div><!--box-content-->