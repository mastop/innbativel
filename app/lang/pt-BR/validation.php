<?php

return [
	"accepted" 			=> "Este campo deve ser aceite.",
	"active_url" 		=> "Este campo não é uma URL válida.",
	"after" 			=> "Este campo deve ser uma data após :date.",
	"alpha" 			=> "Este campo só pode conter letras.",
	"alpha_dash" 		=> "Este campo só pode conter letras, números e traços.",
	"alpha_num" 		=> "Este campo só pode conter letras e números.",
	"before" 			=> "Este campo deve ser uma data anterior à :date.",
	"between" 			=> [
		"numeric" => "Este campo deve estar entre :min - :max.",
		"file" 	  => "Este campo deve estar entre :min - :max kilobytes.",
		"string"  => "Este campo deve estar entre :min - :max caracteres.",
	],
	"confirmed" 		=> "Este campo confirmação não coincide.",
	"date" 				=> "Este campo não é uma data válida.",
	"date_format" 		=> "Este campo não corresponde ao formato :format.",
	"different" 		=> "Este campo e :other deve ser diferente.",
	"digits" 			=> "Este campo deve ter :digits dígitos.",
	"digits_between" 	=> "Este campo deve ter entre :min e :max dígitos.",
	"email" 			=> "Este campo não é um e-mail válido.",
	"exists" 			=> "Este campo selecionado é inválido.",
	"image" 			=> "Este campo deve ser uma imagem.",
	"in" 				=> "Este campo selecionado é inválido.",
	"integer" 			=> "Este campo deve ser um inteiro.",
	"ip" 				=> "Este campo deve ser um endereço IP válido.",
	"max" 				=> [
		"numeric" => "Este campo deve ser inferior a :max.",
		"file"    => "Este campo deve ser inferior a :max kilobytes.",
		"string"  => "Este campo deve ser inferior a :max caracteres.",
	],
	"mimes" 			=> "Este campo deve ser um arquivo do tipo: :values.",
	"min" 				=> [
		"numeric" => "Este campo deve conter pelo menos :min.",
		"file"    => "Este campo deve conter pelo menos :min kilobytes.",
		"string"  => "Este campo deve conter pelo menos :min caracteres.",
	],
	"not_in" 			=> "Este campo selecionado é inválido.",
	"numeric" 			=> "Este campo deve ser um número.",
	"regex" 			=> "Este campo não é válido.",
	"required" 			=> "Este campo deve ser preenchido.",
	"required_if" 		=> "Este campo deve ser preenchido quando :other é :value.",
	"required_with" 	=> "Este campo deve ser preenchido quando :values está presente.",
	"required_without" 	=> "Este campo deve ser preenchido quando :values não está presente.",
	"same" 				=> "Este campo e :other devem ser iguais.",
	"size" 				=> [
		"numeric" => "Este campo deve ser :size.",
		"file"    => "Este campo deve ter :size kilobyte.",
		"string"  => "Este campo deve ter :size caracteres.",
	],
	"unique" 			=> "Este :attribute já existe.",
	"url" 				=> "O formato :attribute é inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
