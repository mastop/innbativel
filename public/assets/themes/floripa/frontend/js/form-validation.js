;(function($){

		Innbativel = window.Innbativel || {};

		Innbativel.init = function(){};
		
		Innbativel.ready = function(){

			// $('#press').modal('show'); //excluir em produção

			$('#parceiroForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					parceiroFullName:{ 
						required: true,
						minlength: 5
					},
					parceiroBusinessName:{ 
						required: true,
						minlength: 5
					},
					parceiroEmail: {
						required: true,
						email: true
					},
					parceiroPhone: {
						required: true,
						digits: true,
						rangelength: [10, 11]
					},
					parceiroCelular: {
						required: true,
						digits: true,
						rangelength: [10, 11]
					},
					parceiroCEP: {
						required: true,
						digits: true,
						rangelength: [8, 8]
					},
					parceiroAddress: {
						required: true
					},
					parceiroAddressBairro: {
						required: true
					},
					parceiroAddressCity: {
						required: true
					},
					parceiroAddressState: {
						required: true
					},
					parceiroURL: {
						url: true
					},
					parceiroAbout: {
						required: true,
						rangelength: [30, 200]
					}
				},
				messages:{
					parceiroFullName:{ 
						required: "O campo nome do responsável é obrigatório.",
						minlength: "Deve conter no mínimo 5 caracteres."
					},
					parceiroBusinessName:{ 
						required: "O campo nome do estabelecimento é obrigatório.",
						minlength: "Deve conter no mínimo 5 caracteres."
					},
					parceiroEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					parceiroPhone: {
						required: "O campo telefone é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter de 10 a 11 caracteres."
					},
					parceiroCelular: {
						required: "O campo celular é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter de 10 a 11 caracteres."
					},
					parceiroCEP: {
						required: "O campo CEP é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter 8 caracteres."
					},
					parceiroAddress: {
						required: "O campo endereço é obrigatório."
					},
					parceiroAddressBairro: {
						required: "O campo bairro é obrigatório."
					},
					parceiroAddressCity: {
						required: "O campo cidade é obrigatório."
					},
					parceiroAddressState: {
						required: "O campo estado é obrigatório."
					},
					parceiroURL: {
						required: "O campo website é obrigatório.",
						url: "Digite um URL válido, começando com http://."
					},
					parceiroAbout: {
						required: "O campo depoimento é obrigatório.",
						rangelength: "Deve conter de 30 a 200 caracteres."
					}
				},
				submitHandler: function(form) {
					$.ajax({
						type: "POST",
						dataType: 'json',
						url: $(form).attr('action'),
						data: $(form).serialize(),
						beforeSend: function(data) {
							$('#parceiroForm button[type="submit"]').attr('disabled', true);
							$('#parceiroForm button[type="submit"]').html('Aguarde . . .');
						},
						complete: function(data) {
							$('#parceiroForm button[type="submit"]').attr('disabled', false);
							$('#parceiroForm button[type="submit"]').html('Enviar');
						},
						success: function(data){
							if(data.error == 0){
								$('#parceiro').modal('hide');
								$('#parceiro-response').modal('show');
							}
							else{
								alert(data.message)
							}
						},
						error: function(data) {
							alert('Houve um erro interno. Por favor, tente novamente mais tarde. Se o erro persistir, envie-nos um e-mail para faleconosco@innbativel.com.br');
						},
						headers: {
							'X-CSRF-Token': $(form).find('input[name="_token"]').val()
						}
					});
				}
			});

			$('#conteForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					name:{ 
						required: true,
						minlength: 5
					},
					email: {
						required: true,
						email: true
					},
					destiny: {
						required: true
					},
					travel_date: {
						required: true,
					},
					depoiment: {
						required: true,
						rangelength: [30, 200]
					},
					img: {
						required: true
					},
					authorize: {
						required: true
					}
				},
				messages:{
					name:{ 
						required: "O campo nome completo é obrigatório.",
						minlength: "Deve conter no mínimo 5 caracteres."
					},
					email: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					destiny: {
						required: "O campo destino é obrigatório."
					},
					travel_date: {
						required: "O campo data é obrigatório.",
					},
					depoiment: {
						required: "O campo depoimento é obrigatório.",
						rangelength: "Deve conter de 30 a 200 caracteres."
					},
					img: {
						required: "A foto é obrigatória."
					},
					authorize: {
						required: "Campo obrigatório."
					}
				},
				submitHandler: function(form) {
					$('#conteForm button[type="submit"]').attr('disabled', true);
					$('#conteForm button[type="submit"]').html('Aguarde . . .');
					form.submit();
					// $('#conte-pra-gente').modal('hide');
					// $('#conte-pra-gente-response').modal('show');
				}
			});

			$('#trabalheForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					trabalheFullName:{ 
						required: true,
						minlength: 5
					},
					trabalheEmail: {
						required: true,
						email: true
					},
					trabalheSexo: {
						required: true
					},
					trabalhePhone: {
						required: true,
						digits: true,
						rangelength: [10, 11]
					},
					trabalheCelular: {
						required: true,
						digits: true,
						rangelength: [10, 11]
					},
					trabalheCEP: {
						required: true,
						digits: true,
						rangelength: [8, 8]
					},
					trabalheAddress: {
						required: true
					},
					trabalheAddressBairro: {
						required: true
					},
					trabalheAddressCity: {
						required: true
					},
					trabalheAddressState: {
						required: true
					},
					trabalheAtuacao: {
						required: true
					},
					trabalheCV: {
						required: true
					}
				},
				messages:{
					trabalheFullName:{ 
						required: "O campo nome completo é obrigatório.",
						minlength: "Deve conter no mínimo 5 caracteres."
					},
					trabalheEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					trabalheSexo: {
						required: "O campo sexo é obrigatório."
					},
					trabalhePhone: {
						required: "O campo telefone é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter de 10 a 11 caracteres."
					},
					trabalheCelular: {
						required: "O campo celular é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter de 10 a 11 caracteres."
					},
					trabalheCEP: {
						required: "O campo CEP é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter 8 caracteres."
					},
					trabalheAddress: {
						required: "O campo endereço é obrigatório."
					},
					trabalheAddressBairro: {
						required: "O campo bairro é obrigatório."
					},
					trabalheAddressCity: {
						required: "O campo cidade é obrigatório."
					},
					trabalheAddressState: {
						required: "O campo estado é obrigatório."
					},
					trabalheAtuacao: {
						required: "O campo atuação é obrigatório."
					},
					trabalheCV: {
						required: "Enviar o currículo é obrigatório."
					}
				},
				submitHandler: function(form) {
					$('#trabalheForm button[type="submit"]').attr('disabled', true);
					$('#trabalheForm button[type="submit"]').html('Aguarde . . .');
					form.submit();
					// $('#trabalhe-conosco').modal('hide');
					// $('#trabalhe-conosco-response').modal('show');
				}
			});

			$('#sugiraForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					name:{ 
						required: true,
						minlength: 3
					},
					email: {
						required: true,
						email: true
					},
					destiny:{ 
						required: true,
						minlength: 2
					},
					suggestion: {
						required: true,
						minlength: 10
					}
				},
				messages:{
					name:{ 
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 3 caracteres."
					},
					email: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					destiny: {
						required: "O campo destino é obrigatório.",
						minlength: "Deve conter no mínimo 2 caracteres."
					},
					suggestion: {
						required: "O campo sugestão é obrigatório.",
						minlength: "Deve conter no mínimo 10 caracteres."
					}
				},
				submitHandler: function(form) {
					$.ajax({
						type: "POST",
						dataType: 'json',
						url: $(form).attr('action'),
						data: $(form).serialize(),
						beforeSend: function(data) {
							$('#sugiraForm button[type="submit"]').attr('disabled', true);
							$('#sugiraForm button[type="submit"]').html('Aguarde . . .');
						},
						complete: function(data) {
							$('#sugiraForm button[type="submit"]').attr('disabled', false);
							$('#sugiraForm button[type="submit"]').html('Enviar');
						},
						success: function(data){
							if(data.error == 0){
								$('#sugira').modal('hide');
								$('#sugiraResponse').modal('show');
							}
							else{
								alert(data.message)
							}
						},
						error: function(data) {
							alert('Houve um erro interno. Por favor, tente novamente mais tarde. Se o erro persistir, envie-nos um e-mail para faleconosco@innbativel.com.br');
						},
						headers: {
							'X-CSRF-Token': $(form).find('input[name="_token"]').val()
						}
					});
				}
			});

			$('#paymentBoletoForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					paymentBoletoPhone: {
						required: true,
						rangelength: [14, 15]
					},
					paymentCardEULA: {
						required: true
					}
				},
				messages:{
					paymentBoletoPhone: {
						required: "O campo telefone é obrigatório.",
						rangelength: "Digite um número de telefone válido."
					},
					paymentCardEULA: {
						required: "Campo obrigatório."
					}
				},
				submitHandler: function(form) {
					$('#closeOrderBoleto').attr('disabled','disabled');
					$('#closeOrderBoleto').html('Aguarde . . .');
                    $.each ( $('#paymentBoletoForm input').serializeArray(), function ( i, obj ) {
                        $('<input type="hidden">').prop( obj ).appendTo( $('#buy-form') );
                    } );
                    $('#buy-form input[name="payment_type"]').val('boletus');
                    $('#buy-form').submit();
				}
			});

			$('#paymentCardForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					paymentCardFlag:{ 
						required: true
					},
					paymentCardNumber: {
						required: true,
						creditcard: true
					},
					paymentCardCode: {
						required: true,
						digits: true,
					},
					paymentCardValidityMonth: {
						required: true
					},
					paymentCardValidityYear: {
						required: true
					},
					paymentCardName: {
						required: true,
						minlength: 6
					},
					paymentCardCPF: {
						required: true,
						rangelength: [11,18]
					},
					paymentCardPhone: {
						required: true,
						rangelength: [14, 15]
					},
					paymentCardEULA: {
						required: true
					}
				},
				messages:{
					paymentCardFlag:{ 
						required: "Escolha um tipo de cartão."
					},
					paymentCardNumber: {
						required: "Número do cartão é obrigatório.",
						creditcard: "Digite um número de cartão válido."
					},
					paymentCardCode: {
						required: "Campo obrigatório.",
						digits: "Deve conter apenas dígitos."
					},
					paymentCardValidityMonth: {
						required: "O campo mês é obrigatório."
					},
					paymentCardValidityYear: {
						required: "O campo ano é obrigatório."
					},
					paymentCardName: {
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 6 caracteres."
					},
					paymentCardCPF: {
						required: "Campo CPF é obrigatório.",
						rangelength: "Digite um CPF ou CNPJ válido"
					},
					paymentCardPhone: {
						required: "O campo telefone é obrigatório.",
						rangelength: "Digite um número de telefone válido."
					},
					paymentCardEULA: {
						required: "Campo obrigatório."
					}
				},
				submitHandler: function(form) {
					$('#closeOrderCard').attr('disabled','disabled');
					$('#closeOrderCard').html('<span class="entypo lock"></span>Aguarde . . .');

                    $.each ( $('#paymentCardForm input, #paymentCardForm select').serializeArray(), function ( i, obj ) {
                        $('<input type="hidden">').prop( obj ).appendTo( $('#buy-form') );
                    } );
                    $('#buy-form input[name="payment_type"]').val('credit_card');
                    $('#buy-form').submit();
				}
			});

			$('#paymentCreditForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					paymentCardEULA: {
						required: true
					}
				},
				messages:{
					paymentCardEULA: {
						required: "Campo obrigatório."
					}
				},
				submitHandler: function(form) {
					$('#closeOrderCredit').attr('disabled','disabled');
					$('#closeOrderCredit').html('Aguarde . . .');
                    $.each ( $('#paymentCreditForm input').serializeArray(), function ( i, obj ) {
                        $('<input type="hidden">').prop( obj ).appendTo( $('#buy-form') );
                    } );
                    $('#buy-form input[name="payment_type"]').val('credit');
                    $('#buy-form').submit();
				}
			});

			$('#emailShareForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{
					senderName:{
						required: true,
						minlength: 3
					},
					senderEmail: {
						required: true,
						email: true
					},
					receiverName:{ 
						required: true,
						minlength: 3
					},
					receiverEmail: {
						required: true,
						email: true
					}
				},
				messages:{
					senderName:{ 
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 3 caracteres."
					},
					senderEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					receiverName:{ 
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 3 caracteres."
					},
					receiverEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					}
				},
				submitHandler: function(form) {
					//form.submit();
                    $(form).find('button.btn-primary').attr('disabled', true);
                    $(form).parent().find('h4.modal-title').html('<span class="entypo cycle"></span> Aguarde...');
                    $.ajax({
                        type: "POST",
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function(data){
                            if(data.error > 0){
                                alert('Houve um erro ao tentar enviar sua sugestão. Tente novamente.');
                            }else{
                                $('#receiverName').val('');
                                $('#receiverEmail').val('');
                                $('#emailShare').modal('hide');
                                $('#emailShareResponse').modal('show');
                            }
                            $(form).find('button.btn-primary').attr('disabled', false);
                            $(form).parent().find('h4.modal-title').html('<span class="entypo mail"></span>Compartilhe com seus amigos');
                        },
                        headers: {
                            'X-CSRF-Token': $(form).find('input[name="_token"]').val()
                        }
                    });
				}
			});

			$('#newsletterForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{
					newsletterName:{ 
						required: true,
						minlength: 3
					},
					newsletterEmail: {
						required: true,
						email: true
					}
				},
				messages:{
					newsletterName:{ 
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 3 caracteres."
					},
					newsletterEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					}
				},
				submitHandler: function(form) {
					if($('#newsletterForm input[name="username"]').val()){
						alert('Seu e-mail não pôde ser cadastrado em nossa newsletter. Se o problema persistir, entre em contato conosco.');
					}
					else{
						$(form).find('button.btn-primary').attr('disabled', true);
	                    $(form).parent().find('h4.modal-title').html('<span class="entypo cycle"></span> Aguarde...');
	                    add_contact($('#newsletterName').val(), $('#newsletterEmail').val(), form);
					}
				}
			});

            function add_contact(name, email, form){
                // your API key is available at
                // https://app.getresponse.com/my_api_key.html
                var api_key = '5a98b99902ebe5e0cae6e814f4fcb67a';

                // API 2.x URL
                var api_url = 'http://api2.getresponse.com';

                var campaigns = {};

                var returnMsg = '';

                // find campaign named 'innbativel' (é necessário para acrescentar o usuário à campanha certa)
                $.ajax({
                    url     : api_url,
                    data    : JSON.stringify({
                        'jsonrpc'   : '2.0',
                        'method'    : 'get_campaigns',
                        'params'    : [
                            api_key,
                            {
                                // find by name literally
                                'name' : { 'EQUALS' : 'innbativel' }
                            }
                        ],
                        'id'        : 1
                    }),
                    type        : 'POST',
                    contentType : 'application/json',
                    dataType    : 'JSON',
                    crossDomain : true,
                    async       : false,
                    success     : function(response) {
                        // uncomment following line to preview Response
                        // alert(JSON.stringify(response));

                        campaigns = response.result;
                    }
                });

                // because there can be only (too much HIGHLANDER movie) one campaign of this name
                // first key is the CAMPAIGN_ID required by next method
                // (this ID is constant and should be cached for future use)
                var CAMPAIGN_ID;
                for(var key in campaigns) {
                    CAMPAIGN_ID = key;
                    break; //get only the first key (that is the id)
                }

                //add user to the campaign 'innbativel'

                $.ajax({
                    url     : api_url,
                    data    : JSON.stringify({
                        'jsonrpc'    : '2.0',
                        'method'    : 'add_contact',
                        'params'    : [
                            api_key,
                            {
                                // identifier of 'test' campaign
                                'campaign'  : CAMPAIGN_ID,

                                // basic info
                                'email'     : email,
                                'name'     : name,
                            }
                        ],
                        'id'        : 2
                    }),
                    type        : 'POST',
                    contentType : 'application/json',
                    dataType    : 'JSON',
                    crossDomain : true,
                    async       : false,
                    success     : function(response)
                    {
                        // uncomment following line to preview Response
                        // alert(JSON.stringify(response));

                        if(response.result){
                            returnMsg = 'ok';
                        }
                        else if(response.error.message == 'Invalid email syntax'){
                            returnMsg = "E-mail inválido.";
                        }
                        else if(response.error.message == 'Missing campaign'){
                            returnMsg = "Houve um erro interno. Por favor, tente novamente mais tarde.";
                        }
                        else if(response.error.message == 'Contact already queued for target campaign' || response.error.message == 'Contact already added to target campaign'){
                            returnMsg = "Seu e-mail já está cadastrado em nossa newsletter.";
                        }
                        else{
                            returnMsg = "Houve um erro interno. Por favor, tente novamente mais tarde.";
                        }

                    },
                    error: function(txt) {
                        returnMsg = "Houve um erro interno. Por favor, tente novamente mais tarde.";
                    }
                });
                $(form).find('button.btn-primary').attr('disabled', false);
                $(form).parent().find('h4.modal-title').html('<span class="entypo mail"></span>Receba ofertas por Email');
                if(returnMsg == 'ok'){
                    $('#newsletter').modal('hide');
                    $('#newsletterResponse').modal('show');
                }else{
                    alert(returnMsg);
                }
            }

			$('#registerForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					registerFullName:{ 
						required: true,
						minlength: 5
					},
					registerEmail: {
						required: true,
						email: true
					},
					registerPhone: {
						required: true,
						digits: true,
						rangelength: [10, 11]
					},
					registerPassword: {
						required: true,
						rangelength: [6, 10]
					},
                    registerPassword_confirmation: {
						required: true,
						equalTo: "#registerPassword"
					},
					registerState: {
						required: true
					},
					registerEULA: {
						required: true
					}
				},
				messages:{
					registerFullName:{ 
						required: "O campo nome completo é obrigatório.",
						minlength: "Deve conter no mínimo 5 caracteres."
					},
					registerEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					registerPhone: {
						required: "O campo telefone é obrigatório.",
						digits: "Digite apenas dígitos.",
						rangelength: "Deve conter de 10 a 11 caracteres."
					},
					registerPassword: {
						required: "O campo senha é obrigatório.",
						rangelength: "Este campo deve conter de 6 a 10 caracteres."
					},
                    registerPassword_confirmation: {
						required: "A confirmação da senha é obrigatória.",
						equalTo: "Senha não confere."
					},
					registerState: {
						required: "O campo estado é obrigatório."
					},
					registerEULA: {
						required: "Campo é obrigatório."
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});

			$('#passRecoverForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					passRecoverEmail: {
						required: true,
						email: true
					}
				},
				messages:{
					passRecoverEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					}
				},
				submitHandler: function(form) {
					//form.submit();
                    $.ajax({
                        type: "POST",
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function(data){
                            if(data.error > 0){
                                $('<label></label>').attr('class', 'error').attr('for', 'passRecoverEmail').attr('generated', 'true').text(data.message).insertAfter($('#passRecoverForm input[type=email]')).show();
                            }else{
                                $('#pass-recover').modal('hide');
                                $('#passRecoverResponse').modal('show');
                            }
                        },
                        headers: {
                            'X-CSRF-Token': $(form).find('input[name="_token"]').val()
                        }
                    });
				}
			});

			$('#loginForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlength: 6
					}
				},
				messages:{
					email: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					password: {
						required: "O campo senha é obrigatório.",
						minlength: "Deve conter no mínimo 6 caracteres."
					}
				},
				submitHandler: function(form) {
					form.submit();
					//$('#login').modal('hide');
					// carregar minha-conta
				}
			});

			$('#contactForm').validate({
				onkeyup: false,
				focusCleanup: true,
				rules:{ 
					contactName:{ 
						required: true,
						minlength: 3
					},
					contactEmail: {
						required: true,
						email: true
					},
					contactMessage: {
						required: true,
						minlength: 10
					}
				},
				messages:{
					contactName:{ 
						required: "O campo nome é obrigatório.",
						minlength: "Deve conter no mínimo 3 caracteres."
					},
					contactEmail: {
						required: "O campo email é obrigatório.",
						email: "Digite um email válido."
					},
					contactMessage: {
						required: "O campo mensagem é obrigatório.",
						minlength: "Deve conter no mínimo 10 caracteres."
					}
				},
				submitHandler: function(form) {
					$.ajax({
						type: "POST",
						dataType: 'json',
						url: $(form).attr('action'),
						data: $(form).serialize(),
						beforeSend: function(data) {
							$('#contactForm button[type="submit"]').attr('disabled', true);
							$('#contactForm button[type="submit"]').html('Aguarde . . .');
						},
						complete: function(data) {
							$('#contactForm button[type="submit"]').attr('disabled', false);
							$('#contactForm button[type="submit"]').html('Enviar');
						},
						success: function(data){
							if(data.error == 0){
								$('#contact').modal('hide');
								$('#contactResponse').modal('show');
							}
							else{
								alert(data.message)
							}
						},
						error: function(data) {
							alert('Houve um erro interno. Por favor, tente novamente mais tarde. Se o erro persistir, envie-nos um e-mail para faleconosco@innbativel.com.br');
						},
						headers: {
							'X-CSRF-Token': $(form).find('input[name="_token"]').val()
						}
					});
				}
			});

		};

		Innbativel.load = function(){
			
		};

		$(document).on('ready', Innbativel.ready);
		$(window).on('load', Innbativel.load);

})(jQuery);