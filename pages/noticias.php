<?php 
    $url = explode('/',$_GET['url']);
    if(!isset($url[2])){
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ? ");
        $sql->execute(array(@$url[1]));
        $sql = $sql->fetch();
?>
<div class="header-noticias">
    <h2 class="notification"><i class="far fa-bell"></i></h2>
    <h2 class="notification-2">ACOMPANHE AS ÚLTIMAS <b>NOTÍCIAS DO PORTAL</b></h2>
</div><!--header-noticia-->

<div class="section-noticias">
    <div class="container">
        <div class="parte-serch">

            <div class="serch-padrao">
                <form method="post">
                    <h2><i class="fas fa-search"></i>Realizar uma busca:</h2>
                    <input type="text" name="parametro" placeholder="o que desejá procurar?">
                    <input type="submit" name="acao" value="Pesquisar!">
                </form>
            </div><!--serch-padrao-->

            <div class="serch-padrao">
                <h2><i class="fas fa-list-ul"></i>Selecione a categoria:</h2>
                <form>
                    <select id="categoria" name="categoria">
                        <option value="" selected="" >Todas as categorias</option>
                        <?php $categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` ORDER BY order_id ASC");
                            $categoria->execute();
                            $categoria = $categoria->fetchAll();

                            foreach ($categoria as $key => $value) {
                        ?>
                        <option <?php if($value['slug'] == @$url[1]) echo 'selected'; ?> value="<?php echo $value['slug'] ?>"><?php echo $value['nome']; ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div><!--parte-serch-->

        <div class="mostrar-noticias">
            <?php 

                $porpagina = 10;
                if(!isset($_POST['parametro'])){
                    if(@$sql['nome'] == ''){
                        echo'<div class="titulo-noticia"><h2>Visualizando todos os Posts</h2></div>';
                    }else{
                        echo'<div class="titulo-noticia"><h2>Visualizando posts em '.$sql['nome'].'.</h2></div>';
                    }
                }else{
                    echo'<div class="titulo-noticia"><h2>Busca realizada com sucesso.</h2></div>';
                }

                $query = "SELECT * FROM `tb_site.noticias`";
                if(@$sql['nome'] != ''){
                    $sql['id'] = (int)$sql['id'];
                    $query.="WHERE categoria_id = $sql[id]";
                }

                //sistema de pesquisa
                if(isset($_POST['parametro'])){
                    if(strstr($query,'WHERE') !== false){
                        $busca = $_POST['parametro'];
                        $query.=" AND titulo LIKE '%$busca%'";
                    }else{
                        $busca = $_POST['parametro'];
                        $query.=" WHERE titulo LIKE '%$busca%'";
                    }
                }

                $query2 = "SELECT * FROM `tb_site.noticias`";
                if(@$sql['nome'] != ''){
                    $sql['id'] = (int)$sql['id'];
                    $query2.=" WHERE categoria_id = $sql[id]";
                }

                //sistema de pesquisa
                if(isset($_POST['parametro'])){
                    if(strstr($query2,'WHERE') !== false){
                        $busca = $_POST['parametro'];
                        $query2.=" AND titulo LIKE '%$busca%' ";
                    }else{
                        $busca = $_POST['parametro'];
                        $query2.=" WHERE titulo LIKE '%$busca%' ";
                    }
                }

                $totalpagina = MySql::conectar()->prepare($query2);
                $totalpagina->execute();
                $totalpagina = ceil($totalpagina->rowCount() / $porpagina);

                if(!isset($_POST['parametro'])){
                    if(isset($_GET['pagina'])){
                        $pagina = (int)$_GET['pagina'];

                        //verifica se a pagina digitada na url é maior que o total de pagina
                        if($pagina > $totalpagina)
                            $pagina = 1;

                        $limitQuery = ($pagina - 1) * $porpagina;
                        $query.=" ORDER BY order_id ASC LIMIT $limitQuery,$porpagina";

                    }else{
                        $pagina = 1;
                        $query.=" ORDER BY order_id ASC LIMIT 0,$porpagina";
                    }

                }else {
                    $query.=" ORDER BY order_id ASC";
                }
                $banco = MySql::conectar()->prepare($query);
                $banco->execute();
                $noticias = $banco->fetchAll(); 
            ?>
            

            <?php 
                foreach ($noticias as $key => $value) {
                    $banco2 = MySql::conectar()->prepare("SELECT `slug` FROM `tb_site.categorias` WHERE id = ?");
                    $banco2->execute(array($value['categoria_id']));
                    $slug = $banco2->fetch()['slug'];
            ?>
            <div class="noticia-padrao">
                <h2><?php echo $value['data'] ?> - <?php echo $value['titulo'] ?></h2>
                <p><?php echo substr(strip_tags($value['conteudo']),0,400).'...' ?></p>
                <a class="btn-leiamais" href="<?php echo INCLUDE_PATH; ?>noticias/<?php echo $slug; ?>/<?php echo $value['slug']; ?>">Leia mais</a>
            </div><!--noticia-padrao-->
            <?php } ?>

            <div class="paginator">
                    <?php 
                        if(!isset($_POST['parametro'])){
                            for ($i=1; $i <= $totalpagina; $i++) { 
                                $catStr = (@$sql['nome'] != '') ? '/'.$sql['slug'] : '';
                                if($pagina == $i){
                                    echo '<a class="pag-select" href="'.INCLUDE_PATH.'noticias'.$catStr.'?pagina='.$i.'">'.$i.'</a>';
                                }else{
                                    echo '<a href="'.INCLUDE_PATH.'noticias'.$catStr.'?pagina='.$i.'">'.$i.'</a>';
                                }
                            }
                        }
                    ?>
                <?php ?>
            </div>
        </div><!--mostrar-noticias-->
    </div><!--container-->

</div><!--section-noticias-->
<?php }else{
    include('noticias-single.php');
} ?>