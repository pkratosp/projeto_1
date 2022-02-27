$(document).ready(function(){


	var open = true;
	var windowSize = $(window)[0].innerWidth;

	if(windowSize <= 758){
		$('.painel-menu').css('width','0')
		$('header').css('width','100%')
		$('.content').css('width','100%')
	}

	$('.menu').click(function(){

		if(open){
			
			if(windowSize <= 758){
				$('.painel-menu').animate({'width':0}, function(){
					open = false
				})
			}
			$('.painel-menu').animate({'width':0}, function(){
				open = false
			})
			$('.content,header').css('width','100%')
			$('.content,header').animate({'left':0}, function(){
				open = false
			})

		}else{
			if(windowSize <= 758){
				$('.painel-menu').animate({'width':'250px'}, function(){
					open = true
				})
	
				
				$('.painel-menu').css('width','250px')
				//$('.content,header').css('width','calc(100% - 300px)')
				$('header').css('width','100%')
				$('header').animate({'left':'250px'}, function(){
					open = true
				})
			}

			if(windowSize >= 1100){
				$('.painel-menu').animate({'width':'300px'}, function(){
					open = true
				})
	
				
				$('.painel-menu').css('width','300px')
				$('.content,header').css('width','calc(100% - 300px)')
				//$('.content,header').css('width','100%')
				$('.content,header').animate({'left':'300px'}, function(){
					open = true
				})
			}
		}

	})

	$('[formato=data]').mask('00/00/0000')

	$('[acationBtn=delete]').click(function(){
		
		var r = confirm('Deseja relamente excluir?');
		if(r == true){
			return true;
		}else{
			return false;
		}
	})

	//mask parar o cnpj e o cpf
	$('[name=cpf]').mask('999.999.999-99')
	$('[name=cnpj]').mask('99.99.999/9999-99')

	$('[name=tipo_cliente]').change(function(){
		let valor = $(this).val();
		if(valor == 'fisico'){

			$('[name=cpf]').parent().show();
			$('[name=cnpj]').parent().hide();

		}else{

			$('[name=cpf]').parent().hide();
			$('[name=cnpj]').parent().show();

		}
	})

	//formato da pagina de cadastrar-clientes

	$('[name=parcelas],[name=intervalo]').mask('99')
	$('[name=pagamento]').maskMoney({
		prefix:'R$',
		allowNegative:true,
		thousands:'.',
		decimal:',',
		affixesStay:false
	})
	$('[name=vencimento]').Zebra_DatePicker();

})