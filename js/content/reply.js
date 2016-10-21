$(function() {

	$('#re-con').on('keyup', function() {
		if ($(this).val().length > 500) {
			$(this).val($(this).val().substring(0, 500));
		}
	});	//댓글 텍스트 글자 수 제한

	$(document).on('click', '#reply-button', function() {
				
		var deskNum = $('#con-num').val(),
		    userEmail = $('#re-usermail').val(),
		    userNick = $('#re-usernick').val(),
		    repContent = $('#re-con').val(),
		    replyCon = $('#reply-con');
		
		$.ajax({
			type : 'post',
			dataType : 'json',
			url : './content/reply.php',
			data : {
				deskNum : deskNum,
				userEmail : userEmail,
				userNick : userNick,
				repContent : repContent
			},
			success : function(data) {
				if (data[0] === true) {
					$('#re-con').val('');
					replyCon.prepend('<div id="re-con' + data[1].reply_num + '" class="content"><div class="author" style="display: inline-block;">' + data[1].nickname + '</div><div class="metadata"><span class="date">' + data[1].regist_day + '</span></div><div id="rep-del-button' + data[1].reply_num + '" style="float: right;"></div><div class="text">' + data[1].content + '</div></div>');

					if (data[1].email == userEmail) {
						$('#rep-del-button' + data[1].reply_num).html('<i id="rep-del-icon" class="disabled remove link icon" data-value="' + data[1].reply_num + '"></i>');
					}
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