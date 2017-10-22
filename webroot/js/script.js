$(document).ready(function(){
	
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
