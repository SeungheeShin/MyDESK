$(function() {
	
	$(document).on('click', '#vote_button', function() {
		var deskNum = $(this).data('value'),
		    userId = $(this).closest('div').data('value');

		if (userId) {
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : './content/vote.php',
				data : {
					deskNum : deskNum,
					userId : userId
				},
				success : function(data) {
					if (data.constructor == Object) {
						$('#vote' + data.desk_num + ' i').addClass('red');
						$('#vote' + data.desk_num + ' span').text('·   ' + data.vote_good);
					} else {
						swal({
							title : data,
							animation : false
						});
					}
				}
			});
		} else {
			swal({
				title : '로그인 후 이용 가능',
				animation : false
			});
		}
	});
	
});
