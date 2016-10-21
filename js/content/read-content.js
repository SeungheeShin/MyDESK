$(function() {

	var userName = $('#user-name'),
	    userImg = $('#user-img'),
	    userContent = $('#user-content'),
	    delNum = $('#del-val'),
	    conModal = $('.ui.large.long.modal.user'),
	    replyCon = $('#reply-con'),
	    conNum = $('#con-num');

	function readContent(dataCon, dataRep, dataDel, userId) {
		userName.text(dataCon.nickname);
		userImg.html('<img class="ui big image" src="./data/origin/' + dataCon.file_copied + '">');
		userContent.html('<div class="ui header">' + dataCon.job + '</div><p>' + dataCon.content + '</p>');
		conNum.val(dataCon.desk_num);

		if (dataDel) {
			delNum.val(dataCon.desk_num);
			$('#del-icon').html('<i id="delete" class="mini trash outline link icon"></i>');
		} else {
			$('#del-icon *').remove();
		}

		if (dataRep) {
			for (var i = 0; i < dataRep.length; i++) {
				replyCon.prepend('<div id="re-con' + dataRep[i].reply_num + '" class="content"><div class="author" style="display: inline-block;">' + dataRep[i].nickname + '</div><div class="metadata"><span class="date">' + dataRep[i].regist_day + '</span></div><div id="rep-del-button' + dataRep[i].reply_num + '" style="float: right;"></div><div class="text">' + dataRep[i].content + '</div></div>');
				
				if (dataRep[i].email == userId) {
					$('#rep-del-button' + dataRep[i].reply_num).html('<i id="rep-del-icon" class="disabled remove link icon" data-value="' + dataRep[i].reply_num + '"></i>');
				}
			}
		}

		conModal
		.modal({
			observeChanges : true
		})
		.modal({
			onHide : function() {
				$('#reply-con *').remove();
			}
		})
		.modal('setting', 'transition', 'fade')
		.modal('show');
	}

	$(document).on('click', '#con-read-button', function() {
		var deskNum = $(this).data('value'),
		    userId = $('#cen').data('value');

		$.ajax({
			type : 'post',
			dataType : 'json',
			url : './content/read-content.php',
			data : {
				deskNum : deskNum,
				userId : userId
			},
			success : function(response) {
				var bool = response.bool;

				if (bool === true) {
					var dataCon = response.itemCon,
					    dataRep = response.itemRep,
					    dataDel = response.itemDel;

					new readContent(dataCon, dataRep, dataDel, userId);
				} else {
					var message = response.message;
					swal({
						title : message,
						animation : false
					});
				}
			}
		});
	});

	$('#random-button').click(function() {
		var userId = $(this).data('value');

		$.ajax({
			type : 'post',
			dataType : 'json',
			url : './content/random-content.php',
			data : {
				userId : userId
			},
			success : function(response) {
				var bool = response.bool;

				if (bool === true) {
					var dataCon = response.itemCon,
					    dataRep = response.itemRep,
					    dataDel = response.itemDel;

					if (dataCon == null) {//작성된 글 없을때 안내
						swal({
							title : '아직 게시글이 없습니다.',
							animation : false
						});
					} else {
						new readContent(dataCon, dataRep, dataDel, userId);
					}
				} else {
					var message = response.message;
					swal({
						title : message,
						animation : false
					});
				}
			}
		});
	});

});
