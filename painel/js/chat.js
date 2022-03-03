$(document).ready(function(){

    $('textarea').keyup(function(e){
        var code = e.KeyCode || e.which;
        if(code == 13){
            insertChat();
        }
    })

    $('form').submit(function(){
        insertChat();
        return false;
    })

    function insertChat(){
        //vai enviar as mensagens
        var mensagem = $('textarea').val();
        $('textarea').val('');
        $.ajax({
            url:'http://localhost/projeto_1/painel/ajax/chat.php',
            method: 'post',
            data:{'mensagem':mensagem,'acao':'inserir_mensagem'}
        }).done(function(data){
            $('.chat-main').append(data);
            $('.chat-main').scrollTop($('.chat-main')[0].scrollHeight);
        })
    }

    function recuperarMensagem(){
        $.ajax({
            url:'http://localhost/projeto_1/painel/ajax/chat.php',
            method:'post',
            data:{
                'acao':'recuperar_mensagem'
            }
        }).done(function(data){
            $('.chat-main').append(data);
            $('.chat-main').scrollTop($('.chat-main')[0].scrollHeight);
        })
    }

    setInterval(function(){
        //aqui vamos recuperar as mensagem a cada 1 segundo
        recuperarMensagem();
    },3000)

})