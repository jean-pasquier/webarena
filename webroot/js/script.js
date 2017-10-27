$(document).ready(function(){


	$('#scream-btn').click(function(){
		$('#scream-form').toggleClass('undisplayed');
	});

	$('#create-guild-btn').click(function(){
		$('#create-guild-form').toggleClass('undisplayed');
	});

	$('#create-fighter-btn').click(function(){
//		console.log('new fighter');
		$('#create-fighter-form').toggleClass('undisplayed');
	});
	$('#new-password-btn').click(function(){
		$('#new-password-form').toggleClass('undisplayed');
	});


	$('.guild-msg-btn').click(function(){
		var id = $(this).attr('id');
		$('#guild-msg-form-' + id).toggleClass('undisplayed');
	});


	$('.mainnav-menu').click(function (){
		console.log('click');
		$(this).toggleClass('is-opened');
	});
});
