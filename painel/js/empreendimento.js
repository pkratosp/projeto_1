$(document).ready(function(){

    $('.box-display-cliente').sortable({
        start: function(){
            var el = $(this);
            el.find('.box-cliente').css('border','2px dashed #ccc');
        },
        update: function(event,ui){
            var data = $(this).sortable('serialize');
            var el = $(this);
            data+="&acao=ordenar_empreendimento";
            el.find('.box-cliente').css('border','2px solid #444');
            $.ajax({
                url:'http://localhost/projeto_1/painel/ajax/forms.php',
                method:'post',
                data: data
            }).done(function(data){
                console.log(data);
            })
        },
        stop: function(){
            var el = $(this);
            el.find('.box-cliente').css('border','2px solid #444');
        }
    });

})