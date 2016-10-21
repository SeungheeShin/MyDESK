$(document).ready(function() {
	$('#fb-sh').popup({
		boundary : '#fb-sh'
	});

	$('#tw-sh').popup({
		boundary : '#tw-sh'
	});

	$('#user-menu').popup({
		boundary : '#user-menu'
	});

	$('#write-button').popup({
		boundary : '#write-button'
	});

	$('#random-button').popup({
		boundary : '#random-button'
	}); //툴팁
	
	$('.ui.dropdown').dropdown({
		transition : 'drop'
	}); //회원 메뉴 드롭다운
}); 