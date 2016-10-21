$(function() {

	$('form#write-form').submit(function(event) {
		event.preventDefault();
		var fd = new FormData($(this)[0]);
		
		$('#con-submit').addClass('disabled loading');

		$.ajax({
			type : 'POST',
			dataType : 'json',
			url : './content/insert.php',
			data : fd,
			async : true,
			cache : false,
			contentType : false,
			processData : false,

			success : function(response) {
				var sm = response.sm, //성공
				    fm = response.fm; //실패

				if (sm) {
					swal({
						title : sm,
						animation : false
					}).then(function() {
						location.href = ('./mydesk.php');
					});
				} else if (fm) {
					$('#con-submit').removeClass('disabled loading');
					
					swal({
						title : fm,
						animation : false
					});
				}
			}
		});
	});
	
}); 