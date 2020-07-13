$(document).ready(function(){
	$('div#imgContainer').css('transform', 'translateX(0)');
	$('div#imgContainer').css('opacity', '100');

	$('.slideLeft').each(function(index){
		var self = this;
		setTimeout(function(){
			$(self).css('transform', 'translateX(0)');
			$(self).css('opacity', '100');
		}, index*1000);
	});
});