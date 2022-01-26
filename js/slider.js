var Atual = 0;
var time = 4000;
var elemento = $('.slide__img__padrao').length;
var tempo = 5000;

inicieSlide()

function inicieSlide(){
    for(let i =0; i < elemento; i++){
        if(i == 0){
            $('.slide__bulets').append('<span style="background-color: #2E2E2E;"></span>')
        }else{
            $('.slide__bulets').append('<span></span>')
        }
    }

    $('.slide__img__padrao').eq(Atual).fadeIn()
    setInterval(function(){
        alterarSlider()
    }, time)
}

function alterarSlider(){
    $('.slide__img__padrao').stop().fadeIn()
    Atual+=1
    if(Atual == elemento){
        Atual=0
    }
    $('.slide__bulets span').css('background-color','#fff')
    $('.slide__bulets span').eq(Atual).css('background-color','#2E2E2E')
    $('.slide__img__padrao').eq(Atual).fadeOut()
}