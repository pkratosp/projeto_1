<?php
    $url = explode('/',$_GET['url']);

    $verifica_categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ?");
    $verifica_categoria->execute(array($url[1]));
    if($verifica_categoria->rowCount() == 0)
        header('Location: '.INCLUDE_PATH_NOTICIAS);

    $categoria_id =  $verifica_categoria->fetch();

    $post = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ? AND categoria_id = ?");
    $post->execute(array($url[2], $categoria_id['id']));
    if($post->rowCount() == 0)
        header('Location: '.INCLUDE_PATH_NOTICIAS);

    $post = $post->fetch();
    ?>

<div class="container-noticia">
    <h1><i class="far fa-calendar-alt"></i> <?php echo $post['data'];  ?> - <?php echo $post['titulo']; ?></h1>    
    <p><?php echo $post['conteudo']; ?></p>
</div>
