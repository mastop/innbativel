<xml>
	<valido>{{ isset($result['valido'])?$result['valido']:'' }}</valido>
	<nome>{{ isset($result['nome'])?$result['nome']:'' }}</nome>
	<adultos>{{ isset($result['adultos'])?$result['adultos']:'' }}</adultos>
	<criancas>{{ isset($result['criancas'])?$result['criancas']:'' }}</criancas>
	<final-de-semana>{{ isset($result['final-de-semana'])?$result['final-de-semana']:'' }}</final-de-semana>
	<erro>{{ isset($result['erro'])?$result['erro']:'' }}</erro>
	<voucher>{{ isset($result['voucher'])?$result['voucher']:'' }}</voucher>
</xml>