$(function () {
    innbativel = window.innbativel || {};

    innbativel.init = function(){

    	if ($.cookie('sidebar') === '1' && $('#sidebar').length > 0) {
    		$('body').addClass('no-transition').toggleClass('force-sidebar');
    		setTimeout(function(){
    			$('body').removeClass('no-transition');
    		}, 500);
    	};

        $('.expand').collapsible({ defaultOpen: 'current,third', cookieName: 'navAct', cssOpen: 'subOpened', cssClose: 'subClosed', speed: 200 });

        $('.sidebar-tabs').easytabs({ animationSpeed: 100, collapsible: false, tabActiveClass: 'active' });
        $('.actions').easytabs({ animationSpeed: 100, collapsible: false, tabActiveClass: 'current' });


		// $('table.table').dataTable();

		$('.fullview').on('click', function(e){
			e.preventDefault();
			if ($('#sidebar').length > 0) {
				if ($.cookie('sidebar') === '1') { $.cookie('sidebar', 0, '/'); } else { $.cookie('sidebar', 1, '/'); }
			    $('body').toggleClass('force-sidebar');
			}
		    return false;
		});

        Holder.add_theme('simple', { background: '#3C3C3C', foreground: '#fff', size: 10 }).run();

        window.prettyPrint && prettyPrint();
    };

    $(window).ready(innbativel.init);

    // innbativel.ready = function(){
    // 	$('html').addClass('ready');
    // };

    // innbativel.load = function(){
    // 	$('html').removeClass('ready').addClass('loaded');
    // };

    // innbativel.resize = function(){
    // 	$('html').addClass('resized');
    // };

    // $(window)
    // 	.on('ready', innbativel.ready)
    // 	.on('load', innbativel.load)
    // 	.on('resize', innbativel.resize);

    // Muda os itens por página automaticamente sem precisar enviar o formulário
    $('#pag').change(function(){
        $(this).closest('form').submit();
    });

    function formatIcon(o) {
        return "<span class='entypo " + o.id + "' style='margin-top:10px'></span>" + o.text;
    }
    function formatIconSelection(o) {
        return "<span class='entypo " + o.id + "' style='margin-top:13px'></span>" + o.text;
    }
    $("#icon").select2({
        formatResult: formatIcon,
        formatSelection: formatIconSelection,
        escapeMarkup: function(m) { return m; }
    });
});
