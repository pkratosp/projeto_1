<section class="section1">
        <div class="slide__img">

            <div style="background-image: url(https://external-preview.redd.it/GOkP8onbuyjGmN9Rc8Que5mw21CdSw6OuXpAKUuE6-4.jpg?width=960&crop=smart&auto=webp&s=baada9754b52c3be1dbf59e8d9b2502ce8ff9f8d);" class="slide__img__padrao"></div>
            <div style="background-image: url(https://www.showmetech.com.br/wp-content/uploads//2017/01/outrun_wallpaper__10_-2017-01-25-0516.jpg);" class="slide__img__padrao"></div>
            <div style="background-image: url(https://ohlaladani.com.br/wp-content/uploads/wallpaper-OHLALADANI_DESKTOP_WALLPAPERS_AVENTURA-2.jpg);" class="slide__img__padrao"></div>

            <div class="cadastro">

                <form class="formulario-infos" method="post">
                    <h2>Qual o seu melhor email?</h2>
                    <input type="email" name="email" placeholder="Digite seu email" required>
                    <input type="hidden" name="identificador" value="form_home">
                    <input type="submit" value="Cadastrar" name="acao">
                </form>
            </div>

            <div class="slide__bulets">

            </div><!--slide__bulets-->
        </div><!--slide__img-->

    </section><!--section1-->

    <section class="section2">
        <div class="container">

            <div class="part1">
                <h2><?php echo $infoSite['nome_autor'] ?></h2>
                <p><?php echo $infoSite['descricao']; ?></p>
            </div><!--part1-->

            <div class="part2"></div><!--part2-->

        </div><!--container-->
    </section><!--section2-->

    <!--fazer a especialidades depois-->

    <section class="especialidades">
                <div><h2>Especialidades</h2></div>
        <div class="container">
            <div class="especi-1 especi-padrao">
                <div><i class="<?php echo $infoSite['icone1'] ?>"></i></div>
                <p><?php echo $infoSite['descricao1'] ?></p>
            </div>

            <div class="especi-2 especi-padrao">
                <div><i class="<?php echo $infoSite['icone2'] ?>"></i></div>
                <p><?php echo $infoSite['descricao2'] ?></p>
            </div>

            <div class="especi-3 especi-padrao">
                <div><i class="<?php echo $infoSite['icone3'] ?>"></i></div>
                <p><?php echo $infoSite['descricao3'] ?></p>
            </div>

            <div class="especi-4 especi-padrao">
                <div><i class="<?php echo $infoSite['icone4'] ?>"></i></div>
                <p><?php echo $infoSite['descricao4'] ?></p>
            </div>

            <div class="especi-5 especi-padrao">
                <div><i class="<?php echo $infoSite['icone5'] ?>"></i></div>
                <p><?php echo $infoSite['descricao5'] ?></p>
            </div>

            <div class="especi-6 especi-padrao">
                <div><i class="<?php echo $infoSite['icone6'] ?>"></i></div>
                <p><?php echo $infoSite['descricao6'] ?></p>
            </div>


        </div><!--container-->
    </section><!--especialidades-->

<footer>
        <div class="container">

            <div id="depoimentos" class="part1__depoimentos">
                <h2>Depoimentos dos nossos clientes</h2>

                <?php //$depoimentos = Painel::SelectAll('tb_site.depoimentos'); 
                    $depoimentos = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY nome LIMIT 5");
                    $depoimentos->execute();
                ?>

                <?php foreach ($depoimentos as $key => $value) { ?>

                <p><?php echo $value['depoimento']; ?><p>
                <strong><?php echo $value['nome']; ?></strong>
                <div class="line"></div>

                <?php } ?>

            </div><!--part1__depoimentos-->

            <div id="servicos" class="part2__servicos">
                <h2>Serviços</h2>
                <ul>
                    <?php //$servicos = Painel::ListarServicos('tb_site.servicos');
                        $servicos = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` LIMIT 9");
                        $servicos->execute(); 
                    ?>
                    <?php foreach ($servicos as $key => $value) { ?>
                        <li><?php echo $value['servico']; ?></li>
                    <?php } ?>
                </ul>
            </div><!--part2__servicos-->

        </div><!--container-->

        <div class="fim__footer">
            Todos os direitos reservados
        </div><!--fim__footer-->
</footer>