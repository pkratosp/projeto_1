<?php 
    include('confg.php');

    Site::updateUsuarioOnline();
    $infoSite = MySql::conectar()->prepare("SELECT * FROM `tb_admin.confg`");
    $infoSite->execute();
    $infoSite = $infoSite->fetch();
?>

<?php    Site::Contador(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyworks" content="palavras,chaves,do,site">
    <meta name="description" content="descrição do meu site">
    <meta name="author" content="Criador616">
    <!--algumas exportacao-->
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css">
    <link rel="icon" href="<?php echo INCLUDE_PATH; ?>images/favicon.ico">
    
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/e603a9b5dc.js" crossorigin="anonymous"></script>
    <title><?php echo $infoSite['titulo_site']; ?></title>
</head>
<body id="alinhe-flex">



    <base base="<?php echo INCLUDE_PATH; ?>">

<?php 
    $url = isset($_GET['url']) ? $_GET['url'] : 'home';

    switch ($url) {
        case 'depoimentos':
            echo '<target target="depoimentos" />';
            break;
        
        case 'servicos':
            echo '<target target="servicos" />';
            break;
    }

?>

<div class="sucesso">
    <p>Fomulario enviado com sucesso</p>    
</div><!--sucesso-->

<div class="erro">
    <p>Ocorreu algum erro, porfavor tente enviar mais tarde.</p>
</div><!--erro-->

<div class="overley-loading">
    <img src="<?php INCLUDE_PATH ?>images/ajax-loader.gif">
</div><!--overley-loading-->

<header>
        <div class="container">

            <div class="logo"><a href="<?php echo INCLUDE_PATH; ?>">Logo</a></div>

            <div class="menu-desktop">
                <ul>
                    <li><a title="Home" href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
                    <li><a title="Depoimentos" href="<?php echo INCLUDE_PATH; ?>depoimentos">Depoimentos</a></li>
                    <li><a title="Servicos" href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
                    <li><a title="Noticias" href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
                    <li><a title="Contato" realtime="contato" href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
                </ul>
            </div><!--menu-desktop-->

            <div class="menu-mobile">
                <i class="fas fa-bars"></i>
                <ul>
                    <li><a title="Home" href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
                    <li><a title="Depoimentos" href="<?php echo INCLUDE_PATH; ?>Depoimentos">Depoimentos</a></li>
                    <li><a title="Servicos" href="<?php echo INCLUDE_PATH; ?>Servicos">Serviços</a></li>
                    <li><a title="Noticias" href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
                    <li><a title="Contato" realtime="contato" href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
                </ul>
            </div><!--menu-mobile-->

            <div class="clear"></div>
        </div><!--container-->
</header>

<div class="container-principal">
    <?php 

            if(file_exists('pages/'.$url.'.php')){
                include('pages/'.$url.'.php');
            }else{
                if($url != 'depoimentos' && $url != 'servicos'){
                    $urlPar = explode('/',$url)[0];
                    if($urlPar == 'noticias'){
                        include('pages/noticias.php');
                    }else{
                        include('pages/404.php');
                    }
                }else {
                    include('pages/home.php');
                }
            }

    ?>
</div><!--container-principal-->

<?php if($url != 'home'){ ?>
    <footer class="footer-oniciente">
        <p>Todos os direitos são reservados</p>
    </footer>
<?php }?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7A20ay1Q7cjZ6gS7PBGYadxZXiOCSwhU"></script>
    <script src="js/maps.js"></script>
    <script src="js/constants.js"></script>
    <script src="js/myScript.js"></script>  
    <script src="js/slider.js"></script>
    <script src="js/formulariojs.js"></script>

    <?php if(is_array($url) && strstr($url[0],'noticias') !== false){ ?>
        <script>
            $(function(){
                $('#categoria').change(function(){
                    location.href=include_path+"noticias/"+$(this).val();
                })
            })

        </script>
    <?php } ?>


    <?php 
        if($url == 'contato'){
    ?>
 
    <?php } ?> 

</body>
</html>