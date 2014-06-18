;(function($){

		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.ready = function(){
		
		};

		Innbativel.load = function(){

			//$('#emailShare').modal('show'); //excluir em produção

			//clear fields on show modal
			$('#emailShare').on('show.bs.modal', function (e) {
				$('#emailShare input[type=text]').val('');
			})

			//#emailShare modal btn-primary behavior
			$('#emailShare.modal .btn-primary').on('click', function() {
				//alert("bey");
				
			});
			
			//clear fields on page load
			//$('input[type=checkbox]').attr('checked', false);

			//.buy-form modal btn-primary behavior
			$('.buy-form .modal .btn-primary').on('click', function() {
				if( !$(this).closest('li').hasClass('selected') ){
					$(this).closest('li').find('input[type=checkbox]').click();
				}
			});
			//.buy-form modal btn-default behavior
			$('.buy-form .modal .btn-default').on('click', function() {
				if( $(this).closest('li').hasClass('selected') ){
					$(this).closest('li').find('input[type=checkbox]').click();
				}
			});
			

			//disabled buy-btn click actions
			$('#buy-btn.disabled').on('click', buyBtnDisabledClickEvents);

			var scrolling = false;
			function buyBtnDisabledClickEvents() {
				if( $('#buy-btn').hasClass('disabled') && scrollHeight == ($('.buy-form h3').offset().top - 130) ) {
					$('#buy-alert').removeClass('hidden');
					$('#buy-box').addClass('arrow');
					scrolling = false;
				}
				if( $('#buy-btn').hasClass('disabled') && scrollHeight != ($('.buy-form h3').offset().top - 130) ) {
					scrolling = true;
					$('html, body').animate({
						scrollTop: $('.buy-form h3').offset().top - 130
					}, 800, function() {
						$('#buy-box').addClass('arrow');
						$('#buy-alert').removeClass('hidden');
						scrolling = false;
					});
				}
			}

			var totalPrice = 0;

			updatePrice();

			//buy-option click actions
			$('.buy-form input[type=checkbox]').on('change', updatePrice);

			function updatePrice() {
				//buy-option toggle select
				//$(this).closest('li').toggleClass('selected');

				//add or remove select according checked field
				$('.buy-form input[type=checkbox]:not(:checked)').closest('li').removeClass('selected');
				$('.buy-form input[type=checkbox]:checked').closest('li').addClass('selected');
				
				totalPrice = 0;
				
				$('.buy-form input[type=checkbox]:checked').each( function(index) {
					totalPrice = (parseFloat(totalPrice) + parseFloat($(this).val())).toFixed(2);
				});
				
				var printPrice;
				if( totalPrice ){
					printPrice = totalPrice.replace(".", ",");
				}
				
				$('#total-price strong').html(printPrice);

				// if buy-btn is disabled and any buy-options are selected,
				// show total-price, enable buy-btn, add href, remove tooltip
				if( $('#buy-btn').hasClass('disabled') && $('.buy-options li').hasClass('selected') ) {
					$('#total-price').removeClass('hidden');
					$('#buy-btn')
						.removeClass('disabled')
						// .attr('href','comprar.html')
						.closest('div').removeClass('tooltip');
					$('#buy-box')
						.addClass('enabled')
						.removeClass('arrow');
					$('#buy-alert').addClass('hidden');
				}

				//if no buy-option is selected, disable buy-btn
				if( !$('.buy-options li').hasClass('selected') ) {
					$('#buy-box')
						.removeClass('enabled');
						// .addClass('arrow');
					$('#buy-btn')
						.addClass('disabled')
						.removeAttr('href')
						.closest('div').addClass('tooltip');
					$('#total-price').addClass('hidden');
					//$('#buy-alert').removeClass('hidden');
						
					//if no buy-combo is selected, hide total-price
					if( !$('.buy-combo li').hasClass('selected') ) {
						//$('#total-price').addClass('hidden');
					}
				}
			}

			if( $('#fotorama').length ) {
				function fotoramaStart() {
					fotorama.startAutoplay(4000);
				}
				function fotoramaStop() {
					fotorama.stopAutoplay();
				}
				$( function() {
					// 1. Initialize fotorama manually.
					var $fotoramaDiv = $('#fotorama').fotorama();

					// 2. Get the API object.
					fotorama = $fotoramaDiv.data('fotorama');

					// 3. Inspect it in console.
					//console.log(fotorama);
					
					$('#fotorama')
						.bind('mouseenter', fotoramaStop)
						//.bind('mouseleave', fotoramaStart) //incluir em produção
						.bind('enterviewport', fotoramaStart)
						.bind('leaveviewport', fotoramaStop)
						// Initialize the plug-in
						.bullseye();

				});
			}

			var remain = 16;
			var dNow = new Date();
			atualizaContador(dNow.getFullYear(),(dNow.getMonth()+1),dNow.getDate(),23,59,59);
			// atualizaContador(2014,04,02,23,59,59);

			var scrollHeight = $(window).scrollTop();
			var windowScrollTop = $('.buy-box-top').offset().top;
			var windowScrollBottom = $('.buy-box-bottom').offset().top + $('.buy-box-bottom').height();
			var viewableOffset = $('#buy-box').offset().top - scrollHeight;

			scrollEvents();

			$(window).scroll(scrollEvents);

			$(window).on('keyup', scrollEvents);
				
			function scrollEvents() {

				if( $('#buy-box').hasClass('arrow') && scrolling ) {
					$('#buy-box').removeClass('arrow');
					$('#buy-alert').addClass('hidden');
				};

				scrolling = true;

				windowScrollTop = $('.buy-box-top').offset().top;
				windowScrollBottom = $('.buy-box-bottom').position().top + $('.buy-box-bottom').outerHeight(true) - $('#buy-box').outerHeight(true) - 130;
				scrollHeight = $(window).scrollTop();
				viewableOffset = $('#buy-box').offset().top - scrollHeight;

				//min start fixed
				if( viewableOffset < 131 && !$('#buy-box').hasClass('fixed') ) {
					$('#buy-box').addClass('fixed');
				}
				//min stop fixed
				if( (scrollHeight + 130) < windowScrollTop && $('#buy-box').hasClass('fixed') ) {
					$('#buy-box').removeClass('fixed');
				}
				//max stop fixed
				if( scrollHeight > windowScrollBottom && $('#buy-box').hasClass('fixed') ) {
					$('#buy-box').removeClass('fixed');
					$('#buy-box').addClass('align-bottom');
					$('.buy-box-bottom').addClass('align-bottom');
					$('.buy-box-container').addClass('align-bottom');
				}
				//max start fixed
				if( scrollHeight < (windowScrollBottom+1) && $('#buy-box').hasClass('align-bottom') ) {
					$('#buy-box').removeClass('align-bottom');
					$('#buy-box').addClass('fixed');
					$('.buy-box-bottom').removeClass('align-bottom');
					$('.buy-box-container').removeClass('align-bottom');
				}

				//$('#log').prepend( "2) "+scrollHeight+" , "+windowScrollBottom+", "+viewableOffset+"<br />" );
				//$('#log').prepend( "1) "+scrollHeight+", "+windowScrollTop+", "+viewableOffset+"<br />" );
				
			}

		};

		$(window).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);