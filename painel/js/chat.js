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
            data:{'mensagem':mensagem}
        }).done(function(data){
            console.log(data)
        })
    }

    function recuperarMensagem(){

    }

    setInterval(function(){
        //aqui vamos recuperar as mensagem a cada 1 segundo
        recuperarMensagem();
    },1000)

})