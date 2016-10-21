$(function() {	
	$('#del-icon').click(function() {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			ype: 'warning',
			showCancelButton: true,
			onfirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			onfirmButtonText: 'Yes, delete it!'
		}).then(function() {
			var deskNum = $('#del-val').val();

			$.ajax({
				type : 'post',
				dataType : 'json',
				url : './content/delete.php',
				data : {
					deskNum : deskNum
				},
				success : function(data) {
					if (data === true) {
						if ($('#card').data('value') == deskNum) {
							$(this).remove();
						}
						swal({
							title : '삭제되었습니다.',
							animation : false
						}).then(function() {
							location.href = ('./mydesk.php');
						});
					} else {
						swal({
							title : data,
							animation : false
						});
					}
				}
			});
		});
	});	
}); 