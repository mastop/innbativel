;(function($){
		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.ready = function(){
			
			var $grid = $('#sortable');
			var $minPrice = $('#min-price');
			var $maxPrice = $('#max-price');
			var $destinies = $('#destinies');
			var $categories = $('#categories');
			var $departures = $('#departures');
			var $holidays = $('#holidays');
			var $dates = $('#dates');

			var $maxPriceValue = 5000;
			var $minPriceValue = 1;
			var $difPriceValue = 333	;
			var $priceFlag = false;

			// $grid.shuffle({
			// 	itemSelector: '.offer-grid-item'
			// });

			//initial settings
			$('input[value="all"]').prop('checked', true);

			updateFilters();

			// sort itens
			//sortItens();

			$('#sort').on('change', sortItens);

			function sortItens() {
				var sort = this.value,
				opts = {};

				// We're given the element wrapped in jQuery
				if ( sort === 'spotlight' ) {
					opts = {
						reverse: true,
						by: function($el) {
							return $el.data('spotlight');
						}
					};
				}
				if ( sort === 'price' ) {
					opts = {
						by: function($el) {
							return $el.data('price');
						}
					};
				}
				if ( sort === 'discount' ) {
					opts = {
						reverse: true,
						by: function($el) {
							return $el.data('discount');
						}
					};
				}
				// Filter elements
				$grid.shuffle('sort', opts);
			}

			//change event for option "all"
			$('.search-filters input[value="all"]').on('change', function (e) {
				$(this).closest('ul').find('input:not([value="all"])').prop('checked', false);
				updateFilters();
			});

			//change event for other options
			$('.search-filters input:not([value="all"])').on('change', function (e) {
				$(this).closest('ul').find('input[value="all"]').prop('checked', false);
				updateFilters();
			});

			function updateFilters() {
				//if none filter is select, select "all"
				$('.search-filters:not(.links)').each( function (i) {
					if( $(this).find('input[type=checkbox]:not(:checked)').length == $(this).find('input[type=checkbox]').length ){
						$(this).find('input[value="all"]').prop('checked', true);
					}
				});
				//remove selected class from all itens
				$('.search-filters input[type=checkbox]:not(:checked)').closest('li').removeClass('selected');
				//add selected class to checked itens
				$('.search-filters input[type=checkbox]:checked').closest('li').addClass('selected');
				filterItens();
			}

			$grid.on('filtered.shuffle', function () {
				// $('#log').prepend( "done shuffle<br />" );
				$('html, body').animate({
					scrollTop: $grid.offset().top - 165
				}, 400);
			});

			// change minPrice
			$minPrice.on('change keyup mouseup', function() {
				if ( parseInt($minPrice.val()) <= $minPriceValue ) {
					$minPrice.val($minPriceValue);
				}
				if ( parseInt($minPrice.val()) >= parseInt($maxPrice.val()) /*|| !parseInt($maxPrice.val())*/ ){
					$maxPrice.val( parseInt($minPrice.val())+$difPriceValue );
					if( parseInt($maxPrice.val()) >= $maxPriceValue ){
						$minPrice.val(parseInt($maxPriceValue-$difPriceValue));
						$maxPrice.val($maxPriceValue);
					}
				}
				if ( parseInt($minPrice.val()) >= $maxPriceValue ) {
					$minPrice.val(parseInt($maxPriceValue-$difPriceValue));
					$maxPrice.val($maxPriceValue);
				}
				filter();
			});

			// change maxPrice
			$maxPrice.on('change mouseup', function() {
				if ( parseInt($maxPrice.val()) >= $maxPriceValue ) {
					$maxPrice.val($maxPriceValue);
				}
				if ( parseInt($maxPrice.val()) <= parseInt($minPrice.val()) /* || !parseInt($minPrice.val())*/ ){
					$minPrice.val( parseInt($maxPrice.val())-$difPriceValue );
					if( parseInt($minPrice.val()) <= $minPriceValue ){
						$minPrice.val($minPriceValue);
						$maxPrice.val(parseInt($minPriceValue+$difPriceValue));
					}
				}
				if ( parseInt($maxPrice.val()) <= $minPriceValue ) {
					$minPrice.val($minPriceValue);
					$maxPrice.val(parseInt($minPriceValue+$difPriceValue));
				}
				filter();
			});

			// destinies
			$destinies.find('input').on('change', function() {
				var $checked = $destinies.find('input:checked'),
				groups = [];

				// At least one checkbox is checked, clear the array and loop through the checked checkboxes
				// to build an array of strings
				if ( $checked.length !== 0 && $checked[0].value !== 'all' ) {
					$checked.each(function() {
						groups.push(this.value);
					});
				}
				destinies = groups;
				
				filter();
			});

			// categories
			$categories.find('input').on('change', function() {
				var $checked = $categories.find('input:checked'),
				groups = [];

				// At least one checkbox is checked, clear the array and loop through the checked checkboxes
				// to build an array of strings
				if ( $checked.length !== 0 && $checked[0].value !== 'all' ) {
					$checked.each(function() {
						groups.push(this.value);
					});
				}
				categories = groups;

				filter();
			});

			// departures
			departures = [];
			$departures.find('input').on('change', function() {
				var $checked = $departures.find('input:checked'),
				groups = [];

				// At least one checkbox is checked, clear the array and loop through the checked checkboxes
				// to build an array of strings
				if ( $checked.length !== 0 && $checked[0].value !== 'all' ) {
					$checked.each(function() {
						groups.push(this.value);
					});
				}
				departures = groups;
				
				filter();
			});

			// holidays
			$holidays.find('input').on('change', function() {
				var $checked = $holidays.find('input:checked'),
				groups = [];

				// At least one checkbox is checked, clear the array and loop through the checked checkboxes
				// to build an array of strings
				if ( $checked.length !== 0 && $checked[0].value !== 'all' ) {
					$checked.each(function() {
						groups.push(this.value);
					});
				}
				holidays = groups;

				filter();
			});

			// dates
			$dates.find('input').on('change', function() {
				var $checked = $dates.find('input:checked'),
				groups = [];

				// At least one checkbox is checked, clear the array and loop through the checked checkboxes
				// to build an array of strings
				if ( $checked.length !== 0 && $checked[0].value !== 'all' ) {
					$checked.each(function() {
						groups.push(this.value);
					});
				}
				dates = groups;

				filter();
			});
			
			filter = function() {
				if ( hasActiveFilters() ) {
					$grid.shuffle('shuffle', function($el) {
						$price = parseInt($el.data('price'));
						$destiny = $el.data('destinies');
						$category = $el.data('categories');
						return itemPassesFilters( $el.data() );
					});
				} else {
					$grid.shuffle( 'shuffle', 'all' );
				}
			}
		
			itemPassesFilters = function(data) {

				// If a destinies filter is active and no value is in the array
				if ( destinies.length > 0 && !valueInArray(data.destinies, destinies) ) {
					return false;
				}
				// If a categories filter is active and no value is in the array
				if ( categories.length > 0 && !valueInArray(data.categories, categories) ) {
					return false;
				}
				// If a departures filter is active and no value is in the array
				if ( departures &&departures.length > 0 && !valueInArray(data.departures, departures) && !arrayContainsArray(data.departures, departures) ) {
					return false;
				}
				// If a holidays filter is active and no value is in the array
				if ( holidays.length > 0 && !valueInArray(data.holidays, holidays) && !arrayContainsArray(data.holidays, holidays) ) {
					return false;
				}
				// If a date filter is active and no value is in the array
				if ( dates.length > 0 ){
                    var passDate = false;
                    for ( var i in dates ) {
                        //alert(parseInt(dates[i]));
                        if(parseInt(dates[i]) >= parseInt(data.mindate) && parseInt(dates[i]) <= parseInt(data.maxdate)){
                            passDate = true;
                            //alert(data.mindate);
                            //alert(data.maxdate);
                            //return false;
                        }

                    }
                    if(!passDate){
                        return false
                    }
				}

				if ( parseInt($price) > parseInt($maxPrice.val()) /*&& !parseInt($minPrice.val())*/ ){
					return false;
				}
				if ( parseInt($price) < parseInt($minPrice.val()) /*&& !parseInt($maxPrice.val())*/ ){
					return false;
				}
				// if ( parseInt($price) >= parseInt($minPrice.val()) && parseInt($price) <= parseInt($maxPrice.val()) ){
				// 	$('#log').prepend( "<hr>price between<br />" );
				// 	return true;
				// }
				// $('#log').prepend( "<hr>price passed<br />" );
				return true;
			}

			hasActiveFilters = function() {
				return destinies.length > 0 || categories.length > 0 || departures.length > 0 || holidays.length > 0 || dates.length > 0 || parseInt($minPrice.val()) || parseInt($maxPrice.val()) ;
			}

			valueInArray = function(value, arr) {
				return $.inArray(value, arr) !== -1;
			}

			arrayContainsArray = function(arrToTest, requiredArr) {
				// Loop through selected filters, if some is in array, push to match
				match = [];
				for ( var i in arrToTest ) {
					if ( $.inArray(arrToTest[i], requiredArr) !== -1 ){
						match.push(arrToTest[i]);
					}
				}
				// if match is empty, return false
				if ( match.length === 0 ){
					return false;
				} 
				return true;
			}

			function filterItens() {
				
			}

			//$('#log').prepend( "1) "+scrollHeight+", "+windowScrollTop+", "+viewableOffset+"<br />" );
			
		};

		Innbativel.load = function(){

		};

		$(window).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);