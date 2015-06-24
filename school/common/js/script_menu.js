$(document).ready(function(){
	$('.btnMenu a').click(function(){
		$("#menu").slideDown("slow");
	});
	
	$('.btnClose').click(function(){
		$("#menu").slideUp("slow");
	});
});