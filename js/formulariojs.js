$(document).ready(function(){

	$('body').on('submit','form.formulario-infos', function(){
		
		let form = $(this)

		$.ajax({
			beforeSend: function(){
				$('.overley-loading').fadeIn()
			},
			url:include_path+'ajax/formulario.php',
			method:'post',
			dataType: 'json',
			data:form.serialize()//este é o que vem do arquivo php
		}).done(function(data){
			if(data.sucesso){
				$('.overley-loading').fadeOut()
				//console.log('Fomulario enviado com sucesso')
				$('.sucesso').fadeIn()

				setTimeout(function(){
					$('.sucesso').fadeOut()
				},3000)
			}else{
				$('.overley-loading').fadeOut()

				$('.erro').fadeIn()

				setTimeout(function(){
					$('.erro').fadeOut()
				},3000)
				//console.log('Ocorreu algum erro, porfavor tente enviar mais tarde.')
			}
		})


		return false
	})

})