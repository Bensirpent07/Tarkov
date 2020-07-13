console.log('trying');
$(document).ready(function(){
	var tableData,
		filtersArray = [];

	//Make ajax request (Initial table)
	$.ajax({
		url: base_url+"fetch_ammo_chart",
		method: "GET",
		success: function(data, status){

			//Save table data to variable
			tableData = JSON.parse(data);

			//Create table
			createTable();

			//Get filter options
			$(tableData).each(function(){
				if(!filtersArray.includes(this.caliber)){
					filtersArray.push(this.caliber);
				}
			});

			//Filter Table
			filterTable();
		}
	});

	//Change filter on select menu selection
	$('select#filterSelect').change(function(){
		filterTable();
	});

	//Sort by table headers
	$('th').on('click', function(){
		var sort = $(this).attr('data-sort');
		var id = $(this).attr('id');

		//Clear sorting memory from headers and remove sorting arrow
		$('th').each(function(){
			$(this).children('i').remove();
			if($(this).attr('id') != 'id'){
				$(this).attr('data-sort', '');
			}
		});

		//Sort data
		if(sort == 'asc'){
			tableData.sort(compareValues(id, 'desc'))
			$(this).attr('data-sort', 'desc');
		}else{
			tableData.sort(compareValues(id))
			$(this).attr('data-sort', 'asc');
		};
		deleteTable();
		createTable();

		//Filter Table
		filterTable();

		//Show sorting arrow
		var arrowHTML;
		if(sort == 'asc'){
			arrowHTML = "<i class=\"fas fa-sort-up sort-arrow\"></i>";
		}else{
			arrowHTML = "<i class=\"fas fa-sort-down sort-arrow\"></i>";
		};
		$(this).append(arrowHTML);
	});

	function filterTable(){
		var selectMenu = $('select#filterSelect'),
		    value = $(selectMenu).children('option:selected').val().toLowerCase();
		if(value != 'none'){
			$('tbody#ammoTable tr').filter(function(){
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		}else{
			$('tbody#ammoTable tr').css('display', 'table-row');
		};
	}
	function deleteTable(){
		$('tbody#ammoTable').html('');
	}

	function createTable(){
		$(tableData).each(function(){
			var html = '<tr><td>'+this.ammo_name+'</td><td class="damage">'+this.damage+'</td><td class="pen">'+this.pen+'</td><td>'+this.frag+'</td><td>'+this.ricochet+'</td><td>'+this.speed+'</td></tr>'
			$('tbody#ammoTable').append(html)
		});
	}

	function compareValues(key, order = 'asc'){
		return function innerSort(a, b){
			if(!a.hasOwnProperty(key) || !b.hasOwnProperty(key)){
				//Property doesn't exist on either object
				return 0
			}

			//Check if property is string. If it is, set to upper case.
			const varA = (typeof a[key] === 'string') ? a[key].toUpperCase() : a[key];
			const varB = (typeof b[key] === 'string') ? b[key].toUpperCase() : b[key];

			let comparison = 0;
		    if (varA > varB) {
		      comparison = 1;
		    } else if (varA < varB) {
		      comparison = -1;
		    }

			return(
				//Check if order is descending. If it is, reverse.
				(order === 'desc') ? (comparison * -1) : comparison
			);
		}
	}
});