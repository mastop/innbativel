;(function($){

		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.ready = function(){
		
		};

		Innbativel.load = function(){

			//$('#modal-payment-boleto').modal('show'); //excluir em produção

			// user not logged
			var userAuth = 0;

			// open modal login on load page if user not logged
			if( !userAuth ){
				$('#login').modal('show');
			}

			// login button
			$('#login .btn').on('click', function (e) {
				// login confirmed
				userAuth = 1;
			});

			// register button
			$('#register .btn').on('click', function (e) {
				// login confirmed
				userAuth = 1;
			});

			// credit card payment
			$('#payment-card').on('click', function (e) {
				e.preventDefault();
				if( !userAuth ){
					$('#login').modal('show');
					$('#login .btn').on('click', function (e) {
						userAuth = 1;
						$('#modal-payment-card').modal('show');
					});
					$('#register .btn').on('click', function (e) {
						userAuth = 1;
						$('#modal-payment-card').modal('show');
					});
				}
				else {
					$('#modal-payment-card').modal('show');
				}
			});

			$('#paymentCardFlag').on('change', updateFlag);
			function updateFlag(){
				$('#cc-flag').removeClass();
				if( $(this).val().length > 0 ){
					var flag = $(this).val();
					$('#cc-flag').addClass(flag);
				}
			}

			// $('#modal-payment-card .btn-primary').on('click', function (e) {
			// 	e.preventDefault();
			// 	$('#modal-payment-confirmed').modal('show');
			// });
			
			// boleto payment
			$('#payment-boleto').on('click', function (e) {
				e.preventDefault();
				if( !userAuth ){
					$('#login').modal('show');
					$('#login .btn').on('click', function (e) {
						userAuth = 1;
						$('#modal-payment-boleto').modal('show');
					});
					$('#register .btn').on('click', function (e) {
						userAuth = 1;
						$('#modal-payment-boleto').modal('show');
					});
				}
				else {
					$('#modal-payment-boleto').modal('show');
				}
			});

			// $('#modal-payment-boleto .btn-primary').on('click', function (e) {
			// 	e.preventDefault();
			// 	window.open('https://www.pagador.com.br/post/pagador/reenvia.asp/ea60e3e1-8e48-4ecd-93c7-0b98313b575a', '_blank');
			// 	$('#modal-payment-confirmed').modal('show');
			// });

			// on dismiss modal payment confirmed, load user account
			$('#modal-payment-confirmed').on('hidden.bs.modal', function (e) {
				//window.location.href = 'index.html';
				// alterar url para conta do usuário
				window.open('index.html', '_self');
			});

			function hideEmptyComboList(){
				if( $('li').parents('.checkout-combo').length == 0 ){
					$('.checkout-combo').slideToggle('500');
				}
			}

			function showEmptyComboList(){
				if( $('li').parents('.checkout-combo').length == 0 ){
					$('.checkout-combo').slideToggle('500');
				}
			}

			// include combo-item
			$('.btn-include').on('click', function (e) {
				// prevent default button event
				e.preventDefault();
				// e.stopPropagation();
				var thisItem = $(this).closest('li');
				// target list item position
				var thisTarget = $('.checkout-itens li:first-of-type');
				// highlight item
				thisItem.addClass('selected');
				// remove item from actual list
				thisItem.slideToggle('500', function () {
					// insert item in target list
					thisItem.insertAfter(thisTarget).stop().slideToggle('500', function () {
						thisItem.removeClass('selected');
						updatePrice();
						$('.checkout-itens select').on('change', updatePrice);
					});
					// hide empty combo list
					hideEmptyComboList();
				});
				
				// fade alternative
				// thisItem.fadeOut( '500', function() {
				// 	thisItem.insertAfter(thisTarget).stop().fadeTo('500', 1, function() {
				// 		thisItem.removeClass('selected');
				// 	});
				// });

			});

			// remove combo-item
			$('.btn-remove').on('click', function (e) {
				// prevent default button event
				e.preventDefault();
				// e.stopPropagation();
				var thisItem = $(this).closest('li');
				// target list item position
				var thisTarget = $('.checkout-combo');
				// highlight item
				thisItem.addClass('selected');
				// show empty combo list
				showEmptyComboList();
				// remove item from actual list
				thisItem.slideToggle('500', function () {
					// insert item in target list
					thisItem.appendTo(thisTarget).stop().slideToggle('500', function () {
						thisItem.removeClass('selected');
						updatePrice();
					});
				});
			});

			// include combo-item through modal
			$('.combo-control .btn-primary').on('click', function (e) {
				var thisItemId = $(this).closest('.modal').attr('id');
				var thisItem = $('a[href="#'+thisItemId+'"]').closest('li');
				// if item is in checkout-combo list
				if( thisItem.parents('.checkout-combo').length > 0 ){
					// target list item position
					var thisTarget = $('.checkout-itens li:first-of-type');
					// highlight item
					thisItem.addClass('selected');
					// remove item from actual list
					thisItem.slideToggle('500', function () {
						// insert item in target list
						thisItem.insertAfter(thisTarget).stop().slideToggle('500', function () {
							thisItem.removeClass('selected');
							updatePrice();
							$('.checkout-itens select').on('change', updatePrice);
						});
						// hide empty combo list
						hideEmptyComboList();
					});
				}
			});

			// remove combo-item through modal
			$('.combo-control .btn-default').on('click', function (e) {
				var thisItemId = $(this).closest('.modal').attr('id');
				var thisItem = $('a[href="#'+thisItemId+'"]').closest('li');
				// if item is in checkout-itens list
				if( thisItem.parents('.checkout-itens').length > 0 ){
					// target list item position
					var thisTarget = $('.checkout-combo');
					// highlight item
					thisItem.addClass('selected');
					// show empty combo list
					showEmptyComboList();
					// remove item from actual list
					thisItem.slideToggle('500', function () {
						// insert item in target list
						thisItem.appendTo(thisTarget).stop().slideToggle('500', function () {
							thisItem.removeClass('selected');
							updatePrice();
						});
					});
				}
			});

			// modal donation yes
			$('#donation-info .btn-primary').on('click', function (e) {
				$('#donation').val('1').change();
			});

			// modal donation no
			$('#donation-info .btn-default').on('click', function (e) {
				$('#donation').val('0').change();;
			});

			$('.checkout-itens select').on('change', updatePrice);

			
			// promo code
			var promoCodeDiscount = 0;
			$('#btn-promo-code').on('click', function (e) {
				e.preventDefault();
				var promoCodeInput = $('#input-promo-code').val();
				//alert(promoCodeInput);
				// ajax requisition: send promoCodeInput, validate promoCode, get promoCodeDiscount
				var promoCode = '12345';			
				// validation
				if( promoCodeInput != promoCode ){
					promoCodeDiscount = 0;
					$('#promocode-modal').modal('show');
				}
				if( promoCodeInput == promoCode ){
					promoCodeDiscount = 50;
					updatePrice();
				}
				
			});

			var totalPrice = 0;

			var donationPrice = 1;

			updatePrice();

			function updatePrice() {
				// reset total price
				totalPrice = 0;
				// alert( $('#testing').attr('data-price') );
				// for each priced item in checkout list
				$('.checkout-itens li[data-price]').each( function (index) {
					// multiply this price by its quantity and sum in total price
					totalPrice = ( parseFloat(totalPrice) + ( $(this).find('select').val() * parseFloat($(this).attr('data-price')) ) ).toFixed(2);
				});

				// donation
				$('.donation .price span').hide();
				if( $('#donation').val() == 1 ){
					totalPrice = ( parseFloat(totalPrice) + parseFloat(donationPrice) ).toFixed(2);
					$('.donation .price span').show();
				}

				// credits
				var credits = $('li[data-credits]').attr('data-credits');
				$('li[data-credits]').hide();
				if( credits > 0 ){
					totalPrice = ( parseFloat(totalPrice) - parseFloat(credits) ).toFixed(2);
					// update tag
					$('li[data-credits]').show();
					$('li[data-credits] .price strong').html(credits);
				}

				// promo code
				//var promoCodeDiscount = $('li[data-promocode-discount]').attr('data-promocode-discount');
				$('li.promocode .price span').hide();
				if( promoCodeDiscount > 0 ){
					totalPrice = ( parseFloat(totalPrice) - parseFloat(promoCodeDiscount) ).toFixed(2);
					// update tag
					$('li.promocode .price span').show();
					$('li.promocode .price strong').html(promoCodeDiscount);
				}

				// print total price
				var printPrice;
				if( totalPrice ){
					printPrice = totalPrice.replace(".", ",");
				}
				$('#total-price strong').html(printPrice);
			}

			$('#printEULA .control.print').click(function () { 
				$('#log').prepend( "daora <br />");
				var printContents = document.getElementById('printEULA').innerHTML;
				var originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			});

		};

		$(window).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);