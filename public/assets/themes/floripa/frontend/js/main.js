;(function($){

		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.ready = function(){

			

		};

		Innbativel.load = function(){

			//   $.ajax({
			//       url: Innbativel.basePath + '/ajax/search/recomendations',
			//       cache: true
			//   }).done(function(json) {
			//   	var list = '';
			//   	$('#super-search .control-group label').append('<span class="tips comma"/>');
			//   	$(json).each(function(index, word){
			//   		 list += '<a href="#">'+ word +'</a>';
			//   	});
			//   	$('#super-search .control-group label span').hide().empty().append(list).fadeIn(1000);

				// $('#super-search .control-group label span a').on('click', function(e){
				// 	e.preventDefault();
				// 	var text = $(this).text();
				// 	console.log(text);
				// 	$('#super-search .controls input').attr('value', text);
				// 	$('#super-search form').submit();
				// 	return false;
				// });
			//   });

				// if (Innbativel.userAuth == 'false') {
				//     $.ajax({
				//         url: Innbativel.basePath + '/entrar/facebook/ajax',
				//         cache: true
				//     }).done(function(json) {
				//         if (json == 'yep') {
				//             window.location.reload();
				//         };
				//     });
				// }

			$('#header-scroll .navMenuCollapse2').collapse({ toggle:false });
			$('#nav .navMenuCollapse').collapse({ toggle:false });
					
			scrollDetect();

			$(window).scroll(scrollDetect);

			function scrollDetect() {
				var scrollHeight = $(window).scrollTop();

				//$('#output').prepend( scrollHeight + "<br />");

				if( scrollHeight > 250 ) {
					//$('#output').prepend( "MAIOR <br />");
					$('#header-scroll').removeClass('out');
					$('#nav .navMenuCollapse').collapse('hide');
				} else {
					//$('#header-scroll .navMenuCollapse2').addClass('collapse');
					//$('#output').prepend( "menor <br />");
					$('#header-scroll').addClass('out');
					$('#header-scroll .navMenuCollapse2').collapse('hide');
				}
			}

		};

		$(window).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);