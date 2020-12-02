jQuery(document).ready(function($) {
	$(document).on('click', '.register-user', function(event) {
		let _this=$(this);
		_this.html('<i class="fas fa-spinner fa-spin" style="font-size:22px"></i>')
		let _form=$(this).parents('form').serialize();
		$(".register-modal strong").hide()
		$.ajax({
			url: '/register-user',
			type: 'POST',
			data: _form,
			success:function(result) {
				window.location=result.redirectTo;			
			},
			error:function(result) {
				let _error=result.responseJSON;
				for(var key in _error) {
					if(_error.hasOwnProperty(key)){
						$(`.${key}`).html(`<strong>${_error[key][0]}</strong>`)
						$(`.${key}`).css('display', 'block');
					}
				}
				_this.text('Sign Up')
			}
		})
	});

	$(document).on('click', '.login-user', function(event) {
		let _this=$(this);
		_this.html('<i class="fas fa-spinner fa-spin" style="font-size:22px"></i>')
		let _form=$(this).parents('form').serialize();
		$(".login-modal strong").hide()
		$.ajaxSetup({
	          headers: {
	              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	          }
	      });
		$.ajax({
			url: '/userlogin',
			type: 'POST',
			data: _form,
			success:function(result) {
				window.location=result.redirectTo;			
			},
			error:function(result) {
				let _error=result.responseJSON;
				for(var key in _error) {
					if(_error.hasOwnProperty(key)){
						$(`.${key}`).html(`<strong>${_error[key][0]}</strong>`)
						$(`.${key}`).css('display', 'block');
					}
				}
				_this.text('Log in')
			}
		})
	});		
});