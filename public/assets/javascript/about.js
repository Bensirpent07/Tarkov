$(document).ready(function(){
	$('div#imgContainer').css({'transform': 'translateX(0)', 'opacity': '100'});

	$('.slideLeft').each(function(index){
		let self = this;
		setTimeout(function(){
			$(self).css({'transform': 'translateX(0)', 'opacity': '100'});
		}, index*1000);
	});
});