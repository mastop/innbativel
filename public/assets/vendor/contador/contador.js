function atualizaContador(ano,mes,dia,hora,minuto,segundo) {
	var hoje = new Date();
	var futuro = new Date(ano,mes-1,dia,hora,minuto,segundo); 

	var ss = parseInt((futuro - hoje) / 1000);
	var mm = parseInt(ss / 60);
	var hh = parseInt(mm / 60);
	var dd = parseInt(hh / 24); 

	ss = ss - (mm * 60);
	mm = mm - (hh * 60);
	//hh = hh - (dd * 24); 

		if(mm < 10){
				mm = '0'+mm;
		}
		
		if(ss < 10){
				ss = '0'+ss;
		}
		
		if(hh < 10){
				hh = '0'+hh;
		}

	var faltam = '';
	//faltam += (dd && dd > 1)? '<li>'+dd+'d</li>' : (dd==1 ? '<li>1d</li>' : '');
	faltam += (toString(hh).length) ? '<li>'+hh+'h</li>' : '00h';
	faltam += (toString(mm).length) ? '<li>'+mm+'m</li>' : '00m';
	faltam += '<li>'+ss+'s</li>'; 

	if (dd+hh+mm+ss > 0) {
		$('#contador').html(faltam);
		setTimeout(function(){atualizaContador(ano,mes,dia,hora,minuto,segundo)},1000);
	} else {
		window.reload();
	}
}
