var $ = jQuery;
$(function(){
	$('#write-author').click(function(){
		$('#success').addClass('hidden');
		$('#modal-author').modal('show');
	});

	$('#send').click(function(){
		var error = false;
		var name = $('#name').val();
		var email = $('#email').val();
		var text = $('#text').val();
		if(name == ''){
			$('#name').parent().removeClass('has-success');			
			$('#name').parent().addClass('has-error');
			error = true;
		}
		else{
			$('#name').parent().removeClass('has-error');			
			$('#name').parent().addClass('has-success');			
		}
		if(email == ''){
			$('#email').parent().removeClass('has-success');			
			$('#email').parent().addClass('has-error');
			error = true;
		}
		else{
			$('#email').parent().removeClass('has-error');			
			$('#email').parent().addClass('has-success');			
		}
		if(text == ''){
			$('#text').parent().removeClass('has-success');			
			$('#text').parent().addClass('has-error');
			error = true;
		}
		else{
			$('#text').parent().removeClass('has-error');			
			$('#text').parent().addClass('has-success');			
		}
		if(error){
			$('#error').removeClass('hidden');
			return;
		}
		else{
			$('#error').addClass('hidden');
			$.ajax({
				type:'post',
				url:'/wp-content/themes/responsivetheme/ajax/send.php',
				data:{name:name, email:email,text:text},
				dataType:'json',
				success: function(result){
					$('#success').removeClass('hidden');
					var name = $('#name').val('');
					var email = $('#email').val('');
					var text = $('#text').val('');
				},
				error: function(){

				}
			});
		}
	});

	$('#ukraine').click(function(){
		$('.tab-2').addClass('no-active');
		$('.tab-1').removeClass('no-active');
		$('#georgia').removeClass('c_active');
		$(this).addClass('c_active');
		return false;
	});

	$('#georgia').click(function(){
		$('.tab-1').addClass('no-active');
		$('.tab-2').removeClass('no-active');
		$('#ukraine').removeClass('c_active');
		$(this).addClass('c_active');
		return false;
	});

});