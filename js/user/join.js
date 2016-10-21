$(function() {

	if ($('#join-button').length > 0) {
		$('#join-form').modal('setting', 'transition', 'vertical flip').modal('attach events', '#join-button, #first-join-button', 'show'); //회원가입 모달
	}

	$('#join-email').keyup(function(event) {
		if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
			var inputVal = $(this).val();
			$(this).val(inputVal.replace(/[^a-z0-9@.]/gi, ''));
		}
	}); //한글입력 안되게 처리

	$('#join-submit').click(function() {
		var joinEmail = $('#join-email').val(),
		    joinPswd = $('#join-pswd').val(),
		    joinNick = $('#join-nick').val();

		if (!joinEmail) {
			var message = '아이디를 입력하세요';
		} else if (!joinPswd) {
			var message = '비밀번호를 입력하세요';
		} else if (joinPswd.length < 10) {
			var message = '비밀번호 입력을 확인하세요';
		} else if (!joinNick) {
			var message = '닉네임을 입력하세요';
		} else {
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : './user/join.php',
				data : {
					joinEmail : joinEmail,
					joinPswd : joinPswd,
					joinNick : joinNick
				},
				success : function(data) {
					if (data[0] === true) {
						swal({
							title : data[1],
							animation : false
						}).then(function() {
							location.href = './mydesk.php';
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
		
		if (message) {
			swal({
				title : message,
				animation : false
			});
		}
	});

}); 