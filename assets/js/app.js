$(window).load(function(){
	$('body').removeClass('loading');
});
$(function(){
	
	if($(window).width() < 768){
		$('#navbar .navigation').prependTo($('#sidebar'));
	}
});