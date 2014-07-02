;(function($){

		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.load = function(){

			try {!function(d,s,id){
				var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
				if(!d.getElementById(id)){js=d.createElement(s);
					js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
					fjs.parentNode.insertBefore(js,fjs);
				}
			}(document,"script","twitter-wjs");} catch(e){}

		};

		Innbativel.ready = function(){

			//$('#register').modal('show'); //excluir em produção

			// user not logged
			var userAuth = 0;

			// login button
			$('#login .btn').on('click', function (e) {
				// login confirmed
				login();
			});

			// register button
			$('#register .btn').on('click', function (e) {
				// login confirmed
				login();
			});

			// logout button
			$('.logout-btn').on('click', function (e) {
				e.preventDefault();
				logout();
			});

			function login() {
				userAuth = 1;
				$('.login').addClass('hidden');
				$('.user-auth').removeClass('hidden');
			}
			function logout() {
				userAuth = 0;
				$('.login').removeClass('hidden');
				$('.user-auth').addClass('hidden');
			}

			
			$('#printEULA .control.print').click(function () { 
				$('#log').prepend( "daora <br />");
				var printContents = document.getElementById('printEULA').innerHTML;
				var originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			});
			
			$('#header-scroll .navMenuCollapse2').collapse({ toggle:false });
			$('#nav .navMenuCollapse').collapse({ toggle:false });

			$('#header-scroll .navbar-toggle').on('click', function() {
				$('.navbar-collapse').css({ maxHeight: $(window).height() - $('.navbar-header').height() + "px" });
			});
					
			scrollEvents();

			$(window).scroll(scrollEvents);

			function scrollEvents() {

				var scrollHeight = $(window).scrollTop();
				
				if( scrollHeight > 130 ) {
					$('#header-scroll').removeClass('out');
					$('#nav .navMenuCollapse').collapse('hide');
				} else {
					$('#header-scroll').addClass('out');
					$('#header-scroll .navMenuCollapse2').collapse('hide');
				}
				
			}
			
		};

		$(document).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);