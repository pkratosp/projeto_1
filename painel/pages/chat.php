<div class="box-content">

	<div class="info-empresa">
			<h2><i class="fas fa-comments"></i> Chat Online</h2>
	</div><!--info-empresa-->

    <div class="chat-main">

        <?php for($i = 0;$i < 20; $i++){ ?>
        <div class="chat-mensagem">
            <span>Pedro Henrique</span>
            <p>Olá como você está?</p>
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