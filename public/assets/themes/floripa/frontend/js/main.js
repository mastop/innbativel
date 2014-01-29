;(function($){

    Innbativel = window.Innbativel || {};

    Innbativel.init = function(){};

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

    };

    $(window).on('ready', Innbativel.ready);
    $(window).on('load', Innbativel.load);

})(jQuery);
