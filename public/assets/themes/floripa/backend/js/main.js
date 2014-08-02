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
        // Faz com que o menu não ultrapasse o rodapé da Admin
        $('#content').css('min-height', $('#sidebar').height()+'px');
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

    // $('#sort').change(function(){
    //     $(this).closest('form').submit();
    // });

    // $('#order').change(function(){
    //     $(this).closest('form').submit();
    // });

    function formatIcon(o) {
        return "<span class='map-icon " + o.id + "' style='margin-top:2px'></span>" + o.text;
    }
    function formatIconSelection(o) {
        return "<span class='map-icon " + o.id + "'></span>" + o.text;
    }
    $("#icon").select2({
        formatResult: formatIcon,
        formatSelection: formatIconSelection,
        escapeMarkup: function(m) { return m; }
    });
    $('.redactor').redactor({
        lang: 'pt_br',
        linebreaks: true,
        observeLinks: true,
        convertVideoLinks: true,
        plugins: ['fontsize'],
        buttons: ['html', 'formatting',  'bold', 'italic', 'unorderedlist', 'orderedlist', 'image', 'video', 'file', 'table', 'link', 'alignment', 'horizontalrule']
    });
});
