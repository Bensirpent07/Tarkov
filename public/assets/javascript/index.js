$(document).ready(function(){
	$('div#initialSelectionContainer a#ammoButton').on('click', function(){
		var selected = $(this);
		$('div#initialSelectionContainer').fadeOut('slow', function(){
			if(selected.attr('id') == 'ammoButton'){
				$('div#ammoSelection').fadeIn('slow');
			}
		});
	});
});