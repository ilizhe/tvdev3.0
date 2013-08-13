$(function(){
	$(".model em").click(function(){
		$(this).toggleClass("toggle_holder_off");
		$(this).parent().siblings().toggle();
	})
})