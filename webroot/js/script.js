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
	
	$('.guild-msg-btn').click(function(){
		var id = $(this).attr('id');
		console.log(id);
		console.log('create-guild-form-'+id);
		$('#guild-msg-form-' + id).toggleClass('undisplayed');
	});
	
	
	var sidebarOpened = false;

	$('.mainnav-menu').click(function (){
		if(sidebarOpened){
			sidebarOpened = false;
			$(this).removeClass('is-opened');
		}
		else{
			sidebarOpened = true;
			$(this).addClass('is-opened');
		}
	});
});