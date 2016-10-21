$(function() {

	if ($('#login-button').length > 0) {
		$('#login-form').modal('attach events', '#login-button', 'show'); 
	} //로그인 모달
	
	$('#login-email').keyup(function(event) {
		if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
			var inputVal = $(this).val();
			$(this).val(inputVal.replace(/[^a-z0-9@.]/gi, ''));
		}
	}); //한글입력 안되게 처리

	$('#login-submit').click(function() {
		var loginEmail = $('#login-email').val(),
		    loginPswd = $('#login-pswd').val();

		if (!loginEmail) {
			swal({
				title : '이메일을 입력해주세요',
				animation : false
			});
		} else if (!loginPswd) {
			swal({
				title : '비밀번호를 입력해주세요',
				animation : false
			});
		} else {
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : './user/login.php',
				data : {
					loginEmail : loginEmail,
					loginPswd : loginPswd
				},
				success : function(data) {
					if (data[0] === true) {
						swal({
							title : data[1],
							animation : false
						}).then(function() {
							location.href = ('./mydesk.php');
						});
					} else {
						swal({
							title : data[1],
							animation : false
						});
					}
				}
			});
		}
	});

}); 