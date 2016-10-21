$(function() {

	$(document).on('mouseover', '.special.cards .image', function() {
		$('.special.cards .image').dimmer({
			on : 'hover'
		});
	});	//마우스오버 시 이미지 디머 효과

	$('.special.cards .image img').visibility({
		type : 'image',
		transition : 'fade in',
		duration : 1000
	});	//스크롤 시 이미지 로딩 효과

	$(document).on('click', '#list-more-button', function() {
		var moreNum = $(this).data('value'),
		    cardMore = $('#card-more'),
		    userMail = $('#useremail').val();

		$.ajax({
			type : 'post',
			dataType : 'json',
			url : './content/list-more.php',
			data : {
				moreNum : moreNum,
				userMail : userMail
			},
			success : function(response) {
				var bool = response.bool;

				if (bool === true) {
					var count = 0,
					    data = response.items;
					    
					$('.ui.container.list-more-box').css('display', 'none');

					for (var i = 0; i < data.length; i++) {
						cardMore.append('<div class="card" data-value="' + data[i].desk_num + '"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div id="cen" class="center" data-value="' + userMail + '"><div id="con-read-button" class="ui inverted button" data-value="' + data[i].desk_num + '">More</div></div></div></div><img src="./data/thumbnails/' + data[i].file_thumb + '" data-src="./data/thumbnails/' + data[i].file_thumb + '" class="transition visible"></div><div id="vote' + data[i].desk_num + '" class="ui right aligned extra content" data-value="' + userMail + '"><i id="vote_button" class="heart link icon" data-value="' + data[i].desk_num + '"></i><span></span></div></div>');

						if (data[i].hasVote === true) {
							$('#vote' + data[i].desk_num + ' i').addClass('red');
						}//추천한 게시물 표시 유지
						if (data[i].vote_good >= 1) {
							$('#vote' + data[i].desk_num + ' span').text('·   ' + data[i].vote_good + ' ');
						}//추천수 0 일때 미노출
						count++;
					} //end for

					if (response.hasMore === true) {
						cardMore.append('<div class="ui container list-more-box"><button id="list-more-button" data-value="' + data[count - 1].desk_num + '" class="fluid ui button"><i class="chevron down icon"></i></button></div>');
					} //더보기할 목록 확인

					if (data.length > 0) {
						$('.special.cards .image img').visibility({
							type : 'image',
							transition : 'fade in',
							duration : 1000
						}); //추가된 목록 이미지 로딩 효과
					}
				} else {
					var message = response.message;
					
					swal({
						title : message,
						animation : false
					});
				} //end if
			}
		});
	});	//더보기 목록

});
