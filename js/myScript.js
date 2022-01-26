$(document).ready(function(){
     //meu menu
     $('.menu-mobile i').click(function(){
         let menu = $('.menu-mobile ul');
         
 
        if(menu.is(':hidden') == true){
             let icone = $('.menu-mobile').find('i');
             icone.removeClass('fa fa-bars')
             icone.addClass('far fa-window-close')
             menu.slideToggle();
        }else{
             let icone = $('.menu-mobile').find('i')
             icone.removeClass('far fa-window-close')
             icone.addClass('fa fa-bars')
             menu.slideToggle();
        }
 
     })
 
     //as especialidades
     var atual = -1;
     var maximo = $('.especi-padrao').length - 1;
     var time;
     var elemento = $('.especi-padrao');
     var animacaoDeley = 3000;

     
     ExecuteAnimacao = () =>{
          $(elemento).hide();
          time = setInterval(LogicaAnimacao,animacaoDeley);
     }

     LogicaAnimacao = () => {
          atual++;
          if(atual > maximo){
               clearInterval();
               return false;
          }

          $(elemento).eq(atual).fadeIn();
     }

     ExecuteAnimacao();
     //scroll dinamico até o footer
     if($('target').length > 0){
          var elementoScroll = '#'+$('target').attr('target')
          var EfeitoScroll = $(elementoScroll).offset().top
          
          $('html,body').animate({'scrollTop':EfeitoScroll},2000);
     }
     

     //carregamento da pagina contato
     ContatoDinamico = () => {
          $('[realtime]').click(function(){
               let pagina = $(this).attr('realtime')

               $('.container-principal').hide()
               $('.container-principal').load(include_path+'pages/'+pagina+'.php')


               setTimeout(function(){
                    initialize();
                    var conteudo = '<p style="color:black;font-size:13px;">Meu endereço</p>'
                    addMarker(-27.609959,-48.576585,'',conteudo,true);
               },1000)


               $('.container-principal').fadeIn(1000)

               return false
               
          })
     }
     ContatoDinamico()

 })
