;(function($){

    Innbativel = window.Innbativel || {};

    Innbativel.init = function(){};

    Innbativel.ready = function(){

        // $('#faq').modal('show'); //excluir em produção

        $('#parceiroForm').validate({
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
                //form.submit();
                $('#parceiro').modal('hide');
                $('#parceiro-response').modal('show');
            }
        });

        $('#conteForm').validate({
            rules:{
                conteFullName:{
                    required: true,
                    minlength: 5
                },
                conteEmail: {
                    required: true,
                    email: true
                },
                conteDestiny: {
                    required: true
                },
                conteDate: {
                    required: true,
                    date: true
                },
                conteDepo: {
                    required: true,
                    rangelength: [30, 200]
                },
                conteFoto: {
                    required: true
                },
                conteVideo: {
                    url: true
                },
                conteAutorizo: {
                    required: true
                }
            },
            messages:{
                conteFullName:{
                    required: "O campo nome completo é obrigatório.",
                    minlength: "Deve conter no mínimo 5 caracteres."
                },
                conteEmail: {
                    required: "O campo email é obrigatório.",
                    email: "Digite um email válido."
                },
                conteDestiny: {
                    required: "O campo destino é obrigatório."
                },
                conteDate: {
                    required: "O campo data é obrigatório.",
                    date: "Digite uma data válida."
                },
                conteDepo: {
                    required: "O campo depoimento é obrigatório.",
                    rangelength: "Deve conter de 30 a 200 caracteres."
                },
                conteFoto: {
                    required: "A foto é obrigatória."
                },
                conteVideo: {
                    url: "Digite um URL válido, começando com http://."
                },
                conteAutorizo: {
                    required: "Campo obrigatório."
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $('#conte-pra-gente').modal('hide');
                $('#conte-pra-gente-response').modal('show');
            }
        });

        $('#trabalheForm').validate({
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
                //form.submit();
                $('#trabalhe-conosco').modal('hide');
                $('#trabalhe-conosco-response').modal('show');
            }
        });

        $('#sugiraForm').validate({
            rules:{
                sugiraName:{
                    required: true,
                    minlength: 3
                },
                sugiraEmail: {
                    required: true,
                    email: true
                },
                sugiraMessage: {
                    required: true,
                    minlength: 10
                }
            },
            messages:{
                sugiraName:{
                    required: "O campo nome é obrigatório.",
                    minlength: "Deve conter no mínimo 3 caracteres."
                },
                sugiraEmail: {
                    required: "O campo email é obrigatório.",
                    email: "Digite um email válido."
                },
                sugiraMessage: {
                    required: "O campo sugestão é obrigatório.",
                    minlength: "Deve conter no mínimo 10 caracteres."
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $('#sugira').modal('hide');
                $('#sugiraResponse').modal('show');
            }
        });

        $('#paymentBoletoForm').validate({
            rules:{
                paymentBoletoPhone: {
                    required: true,
                    digits: true,
                    rangelength: [10, 11]
                }
            },
            messages:{
                paymentBoletoPhone: {
                    required: "O campo telefone é obrigatório.",
                    digits: "Digite apenas dígitos.",
                    rangelength: "Digite um número de telefone válido."
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $('#modal-payment-boleto').modal('hide');
                $('#modal-payment-confirmed').modal('show');
            }
        });

        $('#paymentCardForm').validate({
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
                    digits: true
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
                    rangelength: [11,11]
                },
                paymentCardPhone: {
                    required: true,
                    digits: true,
                    rangelength: [10, 11]
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
                    rangelength: "Digite um CPF válido"
                },
                paymentCardPhone: {
                    required: "O campo telefone é obrigatório.",
                    digits: "Digite apenas dígitos.",
                    rangelength: "Digite um número de telefone válido."
                },
                paymentCardEULA: {
                    required: "Campo obrigatório."
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $('#modal-payment-card').modal('hide');
                $('#modal-payment-confirmed').modal('show');
            }
        });

        $('#emailShareForm').validate({
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
                $('#emailShare').modal('hide');
                $('#emailShareResponse').modal('show');
            }
        });

        $('#newsletterForm').validate({
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
                //form.submit();
                $('#newsletter').modal('hide');
                $('#newsletterResponse').modal('show');
            }
        });

        $('#registerForm').validate({
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
                    minlength: 6
                },
                registerConfirmPassword: {
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
                    minlength: "Este campo deve conter no mínimo 6 caracteres."
                },
                registerConfirmPassword: {
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
                //form.submit();
                $('#register').modal('hide');
            }
        });

        $('#passRecoverForm').validate({
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
                $('#pass-recover').modal('hide');
                $('#passRecoverResponse').modal('show');
            }
        });

        $('#loginForm').validate({
            rules:{
                loginEmail: {
                    required: true,
                    email: true
                },
                loginPassword: {
                    required: true,
                    minlength: 6
                }
            },
            messages:{
                loginEmail: {
                    required: "O campo email é obrigatório.",
                    email: "Digite um email válido."
                },
                loginPassword: {
                    required: "O campo senha é obrigatório.",
                    minlength: "Deve conter no mínimo 6 caracteres."
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $('#login').modal('hide');
                // carregar minha-conta
            }
        });

        $('#contactForm').validate({
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
                //form.submit();
                $('#contact').modal('hide');
                $('#contactResponse').modal('show');
            }
        });

    };

    Innbativel.load = function(){

    };

    $(window).on('ready', Innbativel.ready);
    $(window).on('load', Innbativel.load);

})(jQuery);