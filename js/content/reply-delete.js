$(function() {

	$(document).on('click', '#rep-del-icon', function() {
		var replyNum = $(this).data('value');

		$.ajax({
			type : 'post',
			dataType : 'json',
			url : './content/reply-delete.php',
			data : {
				replyNum : replyNum
			},
			success : function(data) {
				if (data[0] === true) {
					$('#re-con' + replyNum).remove();
				} else {
					swal({
						title : data[1],
						animation : false
					});
				}
			}
		});
	});
	
}); 