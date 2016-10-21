$(function() {
	
	if ($('#write-button').length > 0) {
		$('#write-form').modal('attach events', '#write-button, #first-write-button', 'show'); //글쓰기 모달 띄우기 버튼

		$('#content').on('keyup', function() {
			if ($(this).val().length > 500) {
				$(this).val($(this).val().substring(0, 500));
			}
		}); //글쓰기 텍스트 글자 수 제한

		document.getElementById('wrt-file').onchange = function() {
			var size = $(this)[0].files[0].size,
			    type = $(this)[0].files[0].type,
			    errorMessage = '';

			if ((type != 'image/png') && (type != 'image/jpeg')) {
				errorMessage = '이미지 파일만 업로드 가능합니다.';
			} else if (size > 5000000) {
				errorMessage = '업로드 파일 크기가 지정된 용량(5000KB)을 초과합니다.';
			}

			if (errorMessage) {
				swal({
					title : errorMessage,
					animation : false
				});
				$(this).val('');
			}

			document.getElementById('upload-file-name').value = $(this).val().replace(/.*(\/|\\)/, ''); //이미지 경로 빼고 파일명만
		}; //업로드 이미지 체크
	}

});