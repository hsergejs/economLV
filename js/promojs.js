$(document).ready(function() {

	var move = -15;
	
	var zoom = 1.2;

	$('.item').hover(function() {
		
		width = $('.item').width() * zoom;
		height = $('.item').height() * zoom;
		
		$(this).find('img').stop(false,true).animate({'width':width, 'height':height, 'top':move, 'left':move}, {duration:200});
		
		$(this).find('div.caption').stop(false,true).fadeIn(200);
	},
	function() {
		$(this).find('img').stop(false,true).animate({'width':$('.item').width(), 'height':$('.item').height(), 'top':'0', 'left':'0'}, {duration:100});	

		$(this).find('div.caption').stop(false,true).fadeOut(200);
	});

});