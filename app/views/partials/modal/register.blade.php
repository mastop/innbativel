<div id="register" class="modal fade" tabindex="-1">
<div class="modal-dialog modal-sm modal-stylized">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><span class="entypo add-user"></span>Cadastre-se</h4>
</div>
{{ Former::framework('Nude') }}
{{ Former::horizontal_open(route('account.create'))->rules([
'registerEmail' => 'required|email',
'registerFullName' => 'required',
'registerPhone' => 'required|numeric',
'registerPassword'      => 'required|min:6|confirmed',
'registerPassword_confirmation' => 'required|min:6',
])->id('registerForm')->name('registerForm')->novalidate('novalidate')->class('form-horizontal') }}
<div class="modal-body">
<div class="form-group">
    <div class="col-md-offset-2 col-md-8">
        <a class="img-link" href="{{ route('login.facebook', array('destination' => Input::get('destination', Request::getPathInfo()))) }}"><img src="//innbativel.s3.amazonaws.com/fb-register.png" alt="Faça login com sua conta do Facebook"></a>
    </div>
</div>
<hr>
<div class="form-group">
    <label class="control-label col-md-4" for="registerFullName">Nome completo</label>
    <div class="col-md-8">
        {{ Former::text('registerFullName')->class('form-control')->placeholder('Seu nome completo') }}
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerEmail">Email</label>
    <div class="col-md-8 input-group">
        {{ Former::email('registerEmail')->class('form-control')->placeholder('Seu email') }}
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerPhone">Telefone</label>
    <div class="col-md-8">
        {{ Former::text('registerPhone')->class('form-control')->placeholder('Seu telefone (com DDD)')->maxlength(11) }}
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerPassword">Senha</label>
    <div class="col-md-8">
        {{ Former::password('registerPassword')->class('form-control')->placeholder('Escolha uma senha') }}
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerConfirmPassword">Confirme a senha</label>
    <div class="col-md-8">
        {{ Former::password('registerPassword_confirmation')->class('form-control')->placeholder('Digite novamente a senha') }}
    </div>
</div>
<!--
<div class="form-group">
    <label class="control-label col-md-4" for="registerState">Estado</label>
    <div class="col-md-8">
        <select class="form-control" id="registerState" name="registerState">
            <option value="" selected="selected">Selecione</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoa</option>
            <option value="AM">Amazonas</option>
            <option value="AP">Amapá</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goías</option>
            <option value="MA">Maranhão</option>
            <option value="MG">Minas Gerais</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MT">Mato Grosso</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="PR">Paraná</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="SC">Santa Catarina</option>
            <option value="SE">Sergipe</option>
            <option value="SP">São Paulo</option>
            <option value="TO">Tocantins</option>
        </select>
    </div>
</div>
-->
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        <label class="newsletter">
            {{ Former::checkbox('registerNewsletter')
            ->check() }}
            Desejo receber ofertas por email
        </label>
    </div>
</div>
<div class="form-group">
    <div class="panel-group col-md-12" id="eula">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <label class="eula">
                    {{ Former::checkbox('registerEULA') }}
                    Li e aceito os <a href="#collapseOne" data-toggle="collapse" data-parent="#eula">termos de uso e a política de privacidade</a>
                </label>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div id="printEULA" class="panel-body">
                    <!-- <a href="javascript:window.print();" class="control">​Imprimir</a> -->
                    <!-- <a href="#" class="control print">​Imprimir</a> -->
                    <!-- <a href="#" target="_blank" class="control">Download</a> -->
                     <h4>​Termos e Condições de Uso​</h4>​
                     <p>	ANTES DE SE ASSOCIAR AO SITE LEIA COM ATENÇÃO ESTES TERMOS E CONDIÇÕES DE USO DO SERVIÇO.</p>
                     <p>
                         AO CLICAR O BOTÃO “ACEITO” DA PÁGINA DE REGISTRO, O USUÁRIO ESTARÁ DECLARANDO TER LIDO E ACEITO INTEGRALMENTE, SEM QUALQUER RESERVA, ESTE CONTRATO QUE TEM COMO PARTES O USUÁRIO (“USUÁRIO”) E A ASN SERVICOS DE INFORMACOES DIGITAIS NA WEB LTDA., INSCRITA NO CNPJ SOB O Nº 12.784.420/0001-95 (“INNBATÍVEL”), LOCALIZADA NA ROD. ARMANDO CALIL BULOS, Nº 5405, FLORIANÓPOLIS - SC. ALÉM DISSO, O USUÁRIO ESTARÁ DECLARANDO QUE É MAIOR DE IDADE OU EMANCIPADO E QUE GOZA DE PLENA CAPACIDADE CIVIL E PENAL. CASO NÃO CONCORDE COM ESTE CONTRATO, O USUÁRIO NÃO DEVERÁ UTILIZAR O SITE.</p>
                     <p>
                         OS PAIS OU OS REPRESENTANTES LEGAIS DE MENOR DE IDADE RESPONDERÃO PELOS ATOS POR ELE PRATICADOS SEGUNDO ESTE CONTRATO, DENTRE OS QUAIS EVENTUAIS DANOS CAUSADOS A TERCEIROS, PRÁTICAS DE ATOS VEDADOS PELA LEI E PELAS DISPOSIÇÕES DESTE CONTRATO, SEM PREJUÍZO DA RESPONSABILIDADE DO CONTRATANTE, SE ESTE NÃO FOR O PAI OU O REPRESENTANTE LEGAL DO MENOR INFRATOR.</p>
                     <p>
                         Este Contrato regula a utilização dos serviços de intermediação de negócios e promoções, por meio da compra de cupons para obtenção de ofertas ou promoções de serviços oferecidos por terceiros licenciantes por meio do Site de propriedade do INNBatível, bem como qualquer documentação on-line ou eletrônica relacionada.</p>
                     <p>
                         AVISO IMPORTANTE:</p>
                     <p>
                         O Usuário está ciente de que o tráfego de dados que lhe dá acesso ao Site é suportado por um serviço prestado pela operadora de serviços de telecomunicações escolhido e contratado pelo Usuário e que tal contratação é completamente independente do Site. O Usuário está ciente, ainda, de que os encargos cobrados pela operadora de serviços de telecomunicação (WAP, GPRS) de sua escolha e os impostos aplicáveis podem incidir no tráfego de dados necessário a eventuais downloads e de anúncios de terceiros para seu dispositivo.</p>
                     <p>
                         1. Concessão de Licença de Uso. O INNBatível presta um serviço interativo de intermediação de serviços e/ou produtos de terceiros, por meio da publicação de ofertas e promoções (“Promoções”) no Site, a serem adquiridas, observadas certas condições, por meio da compra de cupons (“Cupons”). Tais serviços são operados e administrados pelo INNBatível na rede mundial de computadores (“Internet”).</p>
                     <p>
                         1.1 O INNBatível, neste ato, concede ao Usuário uma licença pessoal limitada, não exclusiva, não transferível, revogável, por prazo indeterminado, consoante este Contrato, para utilizar o Site, a fim de avaliar, manifestar o interesse em adquirir e eventualmente adquirir as Promoções. O direito de utilização do Site é pessoal e intransferível. Para fins de cadastramento, o Usuário forneceu ao INNBatível as informações necessárias ao seu cadastramento e criou um nome (login) e uma senha (password). O Usuário declara e reconhece que as informações sobre si fornecidas são verdadeiras, corretas, atuais e completas, responsabilizando-se civil e criminalmente por essas informações. Caso os dados informados pelo Usuário no momento do cadastramento estejam errados ou incompletos, impossibilitando a comprovação e identificação do Usuário, o INNBatível terá o direito de suspender imediatamente a prestação de serviços prestados por meio do Site, sem necessidade de prévio aviso, e haver do Usuário as perdas e danos eventualmente sofridos.</p>
                     <p>
                         1.2 O Usuário é responsável pela proteção da confidencialidade de sua senha pessoal. O Usuário autoriza expressamente ao INNBatível a manter em seu cadastro as informações fornecidas pelo Usuário, bem como autoriza ao INNBatível a fornecer as informações constantes de referido cadastro (i) a autoridades públicas que as solicitarem conforme permitido pela legislação em vigor e (ii) a seus parceiros estratégicos, comerciais ou técnicos, com a finalidade de oferecer melhores condições de Promoções e/ou conteúdos ao Usuário. Ademais, o Usuário autoriza expressamente ao INNBatível coletar informações para realização de acompanhamento de tráfego, com intuito de identificar grupos e perfis de usuários, bem assim para fins de orientação publicitária.</p>
                     <p>
                         1.3 Sem prejuízo do disposto acima, não serão aceitos e poderão ser cancelados, a qualquer tempo, endereços de correio eletrônico (e-mail) que contenham expressões ou conjuntos gráfico-denominativos que já tenham sido escolhidos anteriormente por outro usuário ou, de outra forma, que sejam injuriosos, malsoantes, coincidentes com marcas, nomes comerciais, títulos de estabelecimentos, razões sociais de empresas, expressões publicitárias, nomes e pseudônimos de pessoas de relevância pública, famosos ou registrados por terceiros, cujo uso não esteja autorizado ou que sejam, em geral, contrários à lei ou às exigências da moral e bons costumes geralmente aceitos, bem como expressões que possam induzir outras pessoas a erro, sendo certo que o Usuário responderá pelo uso indevido, tanto no âmbito civil quanto criminal, se aplicável.</p>
                     <p>
                         1.4 O Usuário se compromete a comunicar ao INNBatível por meio do serviço de atendimento ao cliente (“SAC”) no e-mail: <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> ou pelo telefone (48) 3365.2790, o extravio, perda, furto ou roubo das senhas de acesso imediatamente após o conhecimento do fato. Até o momento em que efetivamente comunicar ao INNBatível o extravio, perda, furto ou roubo de senha de acesso, o Usuário será o único responsável pelos gastos e/ou prejuízos decorrentes da sua eventual utilização por terceiros, não tendo o INNBatível qualquer responsabilidade por eventuais danos decorrentes de tais fatos.</p>
                     <p>
                         2. Continuidade dos Serviços. O Usuário reconhece que poderão ocorrer (ii) interrupções na prestação dos serviços ou, ainda, (i) outros fatos ocorridos por motivos fora do controle do INNBatível. O INNBatível não será responsabilizado por quaisquer dados perdidos durante a transmissão de informação por meio da Internet.</p>
                     <p>
                         2.1 Embora o INNBatível envide todos os esforços possíveis para manter o Site em funcionamento durante 24 (vinte e quatro) horas por dia, 7 (sete) dias por semana, é possível que haja momentos em que o Site fique indisponível por diferentes motivos, inclusive em virtude da realização de manutenções rotineiras. Desta forma, o acesso ao Site e a prestação dos serviços podem ser interrompidos, suspensos ou encerrados, a qualquer momento, a exclusivo critério do INNBatível.</p>
                     <p>
                         2.2 O INNBatível possui o direito de, a qualquer momento e a seu exclusivo critério, descontinuar, suspender, terminar ou alterar a forma de acesso ao Site com relação a qualquer conteúdo, período de disponibilidade e equipamentos necessários ao acesso e/ou utilização do Site. O INNBatível reserva-se o direito de descontinuar a disseminação de qualquer informação, alterar ou eliminar métodos de transmissão, alterar velocidade de transmissão de dados ou quaisquer outras características de sinal. O INNBatível reserva-se o direito de, a qualquer tempo, descontinuar ou alterar o Contrato, sem necessidade de prévia notificação ao Usuário, podendo, inclusive, optar por cobrar eventuais taxas de inscrição e/ou eventuais remunerações, sendo que neste caso, a mudança só terá efeito e será aplicável às aquisições futuras dos Usuários.</p>
                     <p>
                         3. Equipamentos para Utilização do Site e Capacitação Técnica. O Usuário será o único responsável por adquirir e realizar a manutenção de aparelho de telefone, computador e quaisquer outros equipamentos que venham a ser necessários ao perfeito acesso e uso do Site. O Usuário será o único responsável por eventuais danos que seu equipamento vier a sofrer em decorrência do mau uso de qualquer hardware, software ou conexões.</p>
                     <p>
                         4. Características Individuais e Serviços. Ao utilizar o Site, o Usuário estará sujeito a quaisquer outras diretrizes ou regras aplicáveis aos serviços disponibilizados, que possam vir a ser informadas, de tempos em tempos, as quais ficam automaticamente incorporadas por referência a este Contrato. O Usuário está ciente de que algumas Promoções poderão estar sujeitas a determinadas condições para que se tornem exeqüíveis (p.ex., que determinado número de usuários manifeste o interesse em adquirir o Cupom referente a tal Promoção). O INNBatível não será responsável (i) pela não verificação de uma condição necessária à efetivação da Promoção, bem assim (ii) pela qualidade dos serviços e/ou produtos objeto das Promoções veiculadas a pedido de terceiros licenciantes.</p>
                     <p>
                         4.1 O INNBatível, uma vez verificada a condição necessária para aquisição do Cupom pelo Usuário, poderá debitar o valor de compra do Cupom diretamente do Usuário, sem necessidade de qualquer autorização adicional ou aviso prévio.</p>
                     <p>
                         5. Direito de Arrependimento e Política de Cancelamento e Estorno. Uma vez adquirido o Cupom por meio do Site, o Usuário somente poderá cancelá-lo nas situações previstas abaixo e desde que não tenha resgatado/utilizado/validado o Cupom junto ao efetivo fornecedor do bem ou serviço adquirido:</p>
                     <p>
                         5.1. Em até 14 (quatorze) dias, contados da disponibilização do Cupom na conta pessoal do Usuário mantida no Site, o Usuário poderá solicitar o cancelamento do Cupom, optando, a seu exclusivo critério, pelo estorno do pagamento pelo mesmo meio de pagamento utilizado na aquisição do Cupom ou pela disponibilização da quantia correspondente ao exato valor pago em créditos na conta pessoal do Usuário no Site, que poderá ser utilizado pelo Usuário na aquisição de qualquer outra Promoção. Uma vez optado pelo estorno em créditos, o Usuário deverá estar ciente de que tais créditos não poderão ser futuramente revertidos em dinheiro.</p>
                     <p>
                         <span style="font-size: 12px;">5.2. Em quaisquer das hipóteses acima, seja qual for o prazo, caso o Cupom tenha sido resgatado/utilizado/validado pelo Usuário junto ao efetivo fornecedor dos serviços adquiridos, o INNBatível não mais efetuará o cancelamento do mesmo.</span></p>
                     <p>
                         5.3. Após resgate/utilização/validação do Cupom junto ao fornecedor do serviço, o INNBatível não será mais responsável pelo cancelamento do Cupom, qualquer que seja o motivo.</p>
                     <p>
                         5.4. O Usuário está ciente de que determinados Cupons somente poderão ser utilizados durante um prazo determinado ou em dias específicos. A não utilização do Cupom no prazo e/ou data constantes do Cupom não ensejará sua devolução ou troca.</p>
                     <p>
                         6. Modificações ao Contrato. O INNBatível se reserva o direito de, a seu exclusivo critério, efetuar alterações no Contrato sem necessidade de prévia notificação. Desta forma, é recomendável que o Usuário releia este documento regularmente, de forma a se manter sempre informado sobre eventuais mudanças ocorridas.</p>
                     <p>
                         6.1. Se houver qualquer mudança no Contrato e o Usuário continuar utilizando o Site, o Contrato será considerado lido e aprovado pelo Usuário. Todas as alterações no Contrato tornar-se-ão efetivas imediatamente a partir de sua publicação no Site, sem a necessidade de qualquer aviso prévio ao Usuário.</p>
                     <p>
                         6.2. Em qualquer hipótese, as mudanças no Contrato somente terão efeito e serão aplicáveis às aquisições futuras do Usuário.</p>
                     <p>
                         7. Propriedade do Conteúdo do Site. Todo o conteúdo disponível no Site, incluindo os Microsites, é de propriedade exclusiva do INNBatível e de seus terceiros licenciantes. É proibida a cópia, distribuição, transmissão, publicação, conexão ou qualquer outro tipo de modificação do Site ou dos Microsites sem expressa autorização do INNBatível.</p>
                     <p>
                         7.1 Qualquer violação do disposto nesta cláusula constituirá infração de direitos de propriedade intelectual e sujeitará o Usuário às sanções administrativas, civis e criminais aplicáveis.</p>
                     <p>
                         7.2 O INNBatível e seus terceiros licenciantes reservam-se todos os direitos não expressamente licenciados de acordo com este Contrato. O Usuário declara e reconhece que o download de qualquer conteúdo do Site não lhe confere a propriedade sobre quaisquer marcas exibidas no Site.</p>
                     <p>
                         7.3 Quaisquer marcas exibidas no Site ou qualquer outro site operado em conjunto com o INNBatível não devem ser consideradas como de domínio público e são de propriedade exclusiva do INNBatível ou de seus terceiros licenciantes.</p>
                     <p>
                         7.4 O Usuário não deverá fazer upload, publicar ou de qualquer forma disponibilizar no Site qualquer material protegido por direitos autorais, registro de marcas ou qualquer outro direito de propriedade intelectual sem a prévia e expressa autorização do titular do referido direito.</p>
                     <p>
                         7.5 O INNBatível não tem o dever ou a responsabilidade de fornecer ao Usuário quaisquer indicações que auxiliem na identificação do conteúdo como protegido por direitos de propriedade intelectual. O Usuário será o único responsável por quaisquer danos causados a terceiros, que resultem de violação de direitos de propriedade intelectual, em virtude da utilização do referido conteúdo.</p>
                     <p>
                         8. Acesso e Uso do Site. Tanto o Site, quanto quaisquer outros sites, de qualquer maneira disponibilizados no Site (“Microsites”) são de propriedade privada e quaisquer interações devem ser realizadas de acordo com este Contrato. Sem prejuízo das demais obrigações do Usuário estabelecidas segundo o Contrato, o Usuário obriga-se a (i) não utilizar os conteúdos e produtos do Site com a finalidade de desrespeitar a lei, a moral, os bons costumes, as normas de direito autoral e/ou propriedade industrial, ou os direitos à honra, à vida privada, à imagem, à intimidade pessoal e familiar; (ii) observar os mais elevados padrões éticos e morais vigentes na Internet e as leis nacionais e internacionais aplicáveis; (iii) não utilizar os serviços, conteúdos e produtos fornecidos conforme o Contrato para transmitir ou divulgar material ilegal, difamatório, que viole a privacidade de terceiros, ou que seja abusivo, ameaçador, obsceno, prejudicial, vulgar, injurioso, ou de qualquer outra forma censurável; (iv) não enviar mensagens não-solicitadas, reconhecidas como "spam", "junk mail" ou correntes de correspondência ("chain letters"); não utilizar os serviços, conteúdos e produtos fornecidos conforme o Contrato para enviar/divulgar quaisquer tipos de vírus ou arquivos contendo quaisquer tipos de vírus (p.ex., "Cavalos de Tróia") ou que possam causar danos ao seu destinatário ou a terceiros; (v) cumprir todas as leis aplicáveis com relação à transmissão de dados a partir do Brasil ou do território onde o Usuário resida; (vi) não obter ou tentar obter acesso não-autorizado a outros sistemas ou redes de computadores conectados aos conteúdos e produtos do Site; (vii) responsabilizar-se integralmente pelo conteúdo dos e-mails que vier a transmitir ou retransmitir bem como pelo conteúdo e informações que vier a disponibilizar nas Promoções do Site; (viii) não interferir ou interromper os serviços ou os servidores ou redes conectados aos os serviços, conteúdos e produtos fornecidos por meio do Site ou Microsites, conforme o Contrato; e (ix) cumprir todos procedimentos, políticas, normas e regulamentos aplicáveis aos conteúdos e produtos do Site, divulgados nas páginas e links de cada conteúdo/produto ou Microsites.</p>
                     <p>
                         8.1 Além do disposto acima, o Usuário não poderá postar ou transmitir por meio do Site qualquer conteúdo ou informação que contenha qualquer propaganda ou proposta relacionada a quaisquer produtos e/ou serviços. O Usuário não poderá divulgar ou fazer qualquer oferta comercial, religiosa, política, ou qualquer outra oferta mesmo que sem fins comerciais, incluindo, mas não limitando oferta aos Usuários para que se tornem Usuários de outros serviços que de qualquer maneira possam competir com os serviços prestados pelo INNBatível ou quaisquer dos terceiros licenciantes, de acordo com este Contrato.</p>
                     <p>
                         8.2 Qualquer conduta do Usuário que, a critério exclusivo do INNBatível, possa vir a restringir ou inibir o uso do Site ou Microsites por demais Usuários ou terceiros fica expressamente proibida.</p>
                     <p>
                         9. Preço e Pagamento pelos Serviços. Atualmente, o fornecimento dos conteúdos e produtos constantes do Site é realizado em favor do Usuário sem necessidade de pagamento de remuneração ao INNBatível, que realizará somente a intermediação das operações de compra e venda dos Cupons referentes a Promoções oferecidas ao Usuário pelos terceiros licenciantes.</p>
                     <p>
                         10. Aceitação do Recebimento de Mensagens. O Usuário expressamente aceita que o INNBatível e/ou qualquer de seus parceiros enviem ao Usuário mensagens de e-mail ou de SMS de caráter informativo, referentes a comunicações específicas referentes a Promoções veiculadas em diversas praças de atuação, que estejam ou que venham a ser disponibilizadas no Site, bem como outras mensagens de natureza comercial, tais como ofertas dos terceiros licenciantes da INNBatível, novidades do Site. Caso o Usuário não deseje mais receber referidas mensagens deverá solicitar o cancelamento do seu envio no próprio Site, ou clicar no link “remova aqui” que se localiza no rodapé de todos os e-mails enviados.</p>
                     <p>
                         11. Privacidade das Informações. O INNBatível somente compartilha as informações pessoais dos Usuários com empresas afiliadas do INNBatível, única e exclusivamente com o objetivo de dar cumprimento ao fornecimentos dos bens e serviços, quando necessário e assim constar nas regras da oferta, ou em circunstâncias específicas como ordem judicial ou por determinação legal, quando a ordem advir de autoridades policiais. O INNBatível toma todas as medidas de segurança adequadas de proteção contra acesso, alteração, divulgação ou destruição não autorizada dos dados. Essas medidas incluem análises internas de práticas de coleta, armazenamento e processamento de dados e medidas de segurança, incluindo criptografia e medidas de segurança físicas apropriadas para proteção contra o acesso não autorizado a sistemas de armazenamento de dados pessoais. Todo o acesso aos dados dos Usuários é limitado aos funcionários, contratantes e agentes do INNBatível, de forma escalonada e com conteúdo limitado conforme a função e o tipo de processamento de tais informações para processamento em nome do INNBatível. Essas pessoas firmam contratos com o INNBatível que contém obrigações específicas de confidencialidade e podem ser submetidas a punições, incluindo rescisão de contrato e processo criminal, caso não cumpram tais obrigações.</p>
                     <p>
                         12. Isenções; Garantia. OS SERVIÇOS OU APLICAÇÕES DE TERCEIROS, DISPONIBILIZADOS EM CONJUNTO OU POR MEIO DO SITE, SÃO FORNECIDOS "TAL COMO ESTÃO" E "CONFORME DISPONÍVEIS" SEM GARANTIAS OU CONDIÇÕES DE QUALQUER TIPO, SEJAM ELAS EXPRESSAS OU IMPLÍCITAS. ATÉ A EXTENSÃO MÁXIMA PERMISSÍVEL EM CONFORMIDADE COM A LEGISLAÇÃO APLICÁVEL, O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS EXIMEM-SE DE TODAS AS GARANTIAS E CONDIÇÕES, EXPRESSAS OU IMPLÍCITAS, INCLUSIVE GARANTIAS IMPLÍCITAS E CONDIÇÕES DE COMERCIALIZAÇÃO, ADEQUAÇÃO PARA UM DETERMINADO OBJETIVO E NÃO VIOLAÇÃO DE DIREITOS DE PROPRIEDADE.</p>
                     <p>
                         12.1 O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS NÃO GARANTEM QUE OS SERVIÇOS DISPONIBILIZADOS NO SITE SEJAM ININTERRUPTOS OU LIVRES DE ERROS, QUE OS DEFEITOS SEJAM CORRIGIDOS, OU QUE OS SERVIÇOS OU O SERVIDOR QUE OS DISPONIBILIZA SEJA LIVRE DE VÍRUS OU OUTROS COMPONENTES PREJUDICIAIS.</p>
                     <p>
                         12.2 O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS NÃO GARANTEM NEM FAZEM QUAISQUER DECLARAÇÕES RELATIVAS AO USO OU AOS RESULTADOS DA UTILIZAÇÃO DOS SERVIÇOS E DO SITE EM TERMOS DE EXATIDÃO, PRECISÃO, CONFIABILIDADE, OU DE QUALQUER OUTRA FORMA. O USUÁRIO ASSUME TODO O CUSTO DE QUALQUER SERVIÇO NECESSÁRIO, REMEDIAÇÕES OU CORREÇÕES. O USUÁRIO COMPREENDE E CONCORDA QUE ACESSARÁ O SITE E UTILIZARÁ O SITE A SEU EXCLUSIVO CRITÉRIO E PRÓPRIO RISCO E QUE SERÁ O ÚNICO RESPONSÁVEL POR QUAISQUER DANOS CAUSADOS AO SEU SISTEMA DE COMPUTADOR OU SEU DISPOSITIVO MÓVEL OU PERDA DE DADOS RESULTANTES DA UTILIZAÇÃO DOS SERVIÇOS OU DO DOWNLOAD DE MATERIAIS OU DADOS CONTIDOS NO SITE OU MICROSITES.</p>
                     <p>
                         13. Limites de Responsabilidade. EM NENHUMA CIRCUNSTÂNCIA, O INNBATÍVEL OU SUAS AFILIADAS, CONTRATADAS, FUNCIONÁRIOS, AGENTES OU OUTROS PARCEIROS, TERCEIROS LICENCIANTES OU FORNECEDORES SERÃO RESPONSÁVEIS POR QUAISQUER PERDAS E DANOS SOFRIDOS PELO USUÁRIO OU QUALQUER TERCEIRO QUE RESULTAREM DO SEU USO, DOS MATERIAIS DISPONÍVEIS NO SITE OU QUALQUER OUTRA INTERAÇÃO COM O SITE OU COM O INNBATÍVEL.</p>
                     <p>
                         13.1 ESTAS LIMITAÇÕES TAMBÉM SE APLICARÃO COM RESPEITO ÀS PERDAS E DANOS SOFRIDOS PELO USUÁRIO OU QUALQUER TERCEIRO EM RELAÇÃO A QUAISQUER PRODUTOS, SERVIÇOS, OFERTAS OU PROMOÇÕES VENDIDOS OU FORNECIDOS POR TERCEIROS, QUE NÃO O INNBATÍVEL, DIVULGADOS NOS ANÚNCIOS OU MATERIAIS PUBLICITÁRIOS ENCONTRADOS NO SITE.</p>
                     <p>
                         13.2 EM NENHUMA CIRCUNSTÂNCIA O INNBATÍVEL SERÁ RESPONSÁVEL PELA QUALIDADE, PONTUALIDADE OU EXATIDÃO DOS SERVIÇOS PRESTADOS E/OU DOS PRODUTOS OFERTADOS POR SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS, E ANUNCIADOS NO SITE.</p>
                     <p>
                         13.3 AO INNBATÍVEL RESERVA-SE O DIREITO DE CANCELAR PROMOÇÕES ANUNCIADAS NO SITE, A QUALQUER TEMPO, NOS CASOS EM QUE O INNBATÍVEL IDENTIFIQUE QUALQUER RISCO AOS USUÁRIOS, POR INDÍCIOS DE QUE OS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS DEMONSTREM QUE NÃO IRÃO CUMPRIR COM OS EXATOS TERMOS DAS PROMOÇÕES, DEVENDO O INNBATÍVEL EFETUAR O REGULAR ESTORNO INTEGRAL DO PAGAMENTO EFETUADO PELO USUÁRIO NA AQUISIÇÃO DO CUPOM, PELO MESMO MEIO DE PAGAMENTO UTILIZADO.</p>
                     <p>
                         14. Base do Negócio. O Usuário concorda que as exclusões de garantia e limitações de responsabilidade estabelecidas acima são elementos fundamentais da base do Contrato ora celebrado com o INNBatível.</p>
                     <p>
                         14.1 O Usuário concorda, ainda, que o INNBatível não poderia prestar os serviços e/ou fornecer os produtos disponíveis no Site em uma base economicamente razoável sem essas limitações.</p>
                     <p>
                         14.2 O Usuário reconhece e concorda que as exclusões de garantia e limitações de responsabilidade refletem uma alocação razoável e justa de riscos entre o Usuário e o INNBatível. A exclusão de garantia e as limitações de responsabilidades acima são estendidas para o benefício de todos os terceiros licenciantes do INNBatível.</p>
                     <p>
                         15. Indenização. O INNBatível não será responsável pelo uso indevido ou inapropriado do Site pelo Usuário, nem por quaisquer perdas e danos sofridos pelo Usuário ou por qualquer terceiro em decorrência do seu uso indevido ou inapropriado.</p>
                     <p>
                         15.1 O Usuário concorda em guardar e manter o INNBatível, suas empresas afiliadas e seus fornecedores, terceiros licenciantes, parceiros a salvo e a indenizá-los por quaisquer reclamações, processos, ações, perdas, danos, bem como quaisquer outras responsabilidades (inclusive honorários advocatícios) decorrentes de seu uso ou utilização indevida do Site, de violação deste Contrato, violação dos direitos de qualquer outra pessoa ou entidade, ou qualquer violação das declarações, garantias e acordos feitos aqui pelo Usuário. O INNBatível reserva-se o direito de, as suas custas, assumir a defesa exclusiva e o controle de qualquer questão para com a qual Usuário esteja obrigado a indenizar o INNBatível, ficando, neste caso, o Usuário obrigado, desde já, a cooperar com a defesa do INNBatível.</p>
                     <p>
                         16. Rescisão. O presente Contrato é celebrado por prazo indeterminado, entrando em vigor na data de sua aceitação pelo Usuário, na forma do presente. O Usuário poderá dar por findo o presente a qualquer tempo e independentemente de motivo, mediante contato com SAC do INNBatível, sem que isto gere para qualquer das partes o direito de haver da outra indenização ou qualquer outra quantia. Neste caso, o presente Contrato será rescindido no último dia do mês civil em que o Usuário contatar o SAC do INNBatível.</p>
                     <p>
                         16.1 O INNBatível poderá dar por findo o presente contrato, a qualquer tempo e independentemente de motivo ou aviso dirigido ao Usuário, sem que isto gere para qualquer das partes o direito de haver da outra indenização ou qualquer outra quantia.</p>
                     <p>
                         16.2 O presente contrato será rescindido de pleno direito, independentemente de aviso ou notificação, podendo o INNBatível imediatamente cancelar todos os serviços, conteúdos e produtos objeto do presente, caso o Usuário venha a violar qualquer das suas obrigações previstas no Contrato, sem prejuízo do dever do Usuário de indenizar ao INNBatível.</p>
                     <p>
                         16.3 O INNBatível poderá suspender os serviços, conteúdos e produtos objeto do presente Contrato, caso haja suspeita ou indício de que o Usuário esteja utilizando os serviços, conteúdos e produtos do Site para a veiculação de fotografias e imagens associadas ou de qualquer forma relacionadas a pornografia infantil, ou ainda relacionadas a idéias preconceituosas quanto à origem, raça, etnia, sexo, orientação sexual, cor, idade, crença religiosa ou quaisquer outras formas de discriminação, sem prejuízo do dever do Usuário de indenizar ao INNBatível caso comprovada a violação ao presente.</p>
                     <p>
                         16.4 Com o término, por qualquer motivo, do presente contrato, todos os serviços, conteúdos e produtos fornecidos de acordo com o presente serão imediatamente interrompidos e cancelados e todo e qualquer arquivo, conteúdo, informação ou dados armazenados pelo Usuário nestes serviços, produtos e/ou conteúdos serão automaticamente apagados, sem que isto gere para o Usuário o direito de haver do INNBatível indenização ou qualquer outra quantia.</p>
                     <p>
                         16.5 O INNBatível se responsabiliza em manter a confidencialidade dos arquivos, documentos, e-mails, dados e quaisquer outros tipos de informações que tenham sido armazenados pelo INNBatível em virtude do presente Contrato.</p>
                     <p>
                         17. Disposições Finais.</p>
                     <p>
                         17.1 Tolerância. A tolerância de uma parte quanto ao descumprimento de qualquer das obrigações da outra não será considerada novação ou renúncia a qualquer direito, constituindo mera liberalidade, que não prejudicará o posterior exercício de qualquer direito.</p>
                     <p>
                         17.2 Lei Aplicável. Este Contrato será regido e interpretado de acordo com as leis do Brasil.</p>
                     <p>
                         17.3 Foro. As partes elegem Foro da Comarca de Florianópolis, Estado de Santa Catarina, para dirimir quaisquer questões oriundas do presente Contrato que não possam ser solucionadas de comum acordo entre as partes, com a exclusão de qualquer outro, por mais privilegiado que seja.</p>
                     <p>
                         17.4 Cessão. Este Contrato e quaisquer direitos e licenças concedidas aqui, não podem ser transferidos ou cedidos pelo Usuário, mas poderão ser transferidos ou cedidos pelo INNBatível sem qualquer restrição.</p>
                     <p>
                         17.5 Títulos. As referências a título existentes neste Contrato são feitas para fins de conveniência apenas, e não serão consideradas para limitar ou afetar qualquer das disposições aqui contidas.</p>
                     <p>
                         17.6 Contrato Integral. Este é o acordo integral entre o Usuário e o INNBatível relacionado ao assunto aqui tratado e não será alterado, salvo consoante o previsto neste próprio Contrato.</p>

                     <h4>​Política de privacidade do INNBatível​</h4>​
                     <p>
                         Nosso compromisso é respeitar sua privacidade e garantir o sigilo de todas as informações que você nos fornece. Todos os dados cadastrados em nosso site são utilizados apenas para melhorar sua experiência de compra e mantê-lo atualizado sobre nossas promoções e vantagens oferecidas por empresas parceiras do INNBatível.</p>
                     <p>
                         <em>Uso e Segurança das informações</em></p>
                     <p>
                         Para seu cadastro, solicitamos informações como nome, endereço, e-mail e telefones para contato, para facilitar suas compras no site.</p>
                     <p>
                         O seu e-mail é utilizado para divulgar informações de suas compras e, quando solicitado por você, para comunicar promoções de produtos e serviços do INNBatível e suas parceiras.</p>
                     <p>
                         O INNBatível somente compartilha as informações pessoais com empresas afiliadas do INNBatível e exclusivamente com o objetivo de fornecer a você as melhores ofertas de serviços, ou em circunstâncias específicas como ordem judicial ou advindas de lei.</p>
                     <p>
                         Tomamos medidas de segurança adequadas para nos proteger contra acesso, alteração, divulgação ou destruição não autorizada dos dados. Essas medidas incluem análises internas de nossas práticas de coleta, armazenamento e processamento de dados e medidas de segurança, incluindo criptografia e medidas de segurança físicas apropriadas para nos proteger contra o acesso não autorizado a sistemas em que armazenamos os dados pessoais.</p>
                     <p>
                         Limitamos o acesso às informações pessoais aos funcionários, contratantes e agentes do INNBatível que precisam ter conhecimento dessas informações para processá-las em nosso nome. Essas pessoas estão comprometidas com as obrigações de confidencialidade e podem ser submetidas a punições, incluindo rescisão de contrato e processo criminal, caso não cumpram essas obrigações.</p>
                     <p>
                         <em>Cookies</em></p>
                     <p>
                         No innbativel.com.br, o uso de cookies é feito apenas para reconhecer um visitante constante e melhorar a experiência de compra. Os cookies são pequenos arquivos de dados transferidos de um site da web para o disco do seu computador e não armazenam dados pessoais. Se preferir, você pode apagar os cookies existentes em seu computador através do browser.</p>
                     <p>
                         <em>Envio de e-mails</em></p>
                     <p>
                         O innbativel.com.br nunca envia e-mails solicitando confirmação de dados/cadastro ou com anexos executáveis (extensão .exe, .com, .scr, .bat) e links para download.</p>
                     <p>
                         Nossos e-mails com promoções têm como remetentes: news@innbativelnews.com.br e contato@innbativel.com.br. Os e-mails de acompanhamento de seu pedido são: atendimento@innbativel.com.br e faleconosco@innbativel.com.br</p>
                     <p>
                         Os links de nossos e-mails levam diretamente para o innbativel.com.br ou para empresas parceiras.</p>
                     <p>
                         Nunca forneça a senha de seu cadastro a terceiros e, no caso de uso não autorizado, acesse imediatamente a área “Meus Dados” em “Minha Conta” no site e altere sua senha.</p>
                     <p>
                         Caso deseje parar de receber nossos e-mails, basta clicar no link “remova aqui” que se localiza no rodapé de todos os e-mails enviados.</p>
                     <p>
                         Em caso de dúvidas ou sugestões, por favor, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br</p>
                     <p>
                         Alterações nesta Política de Privacidade</p>
                     <p>
                         Esta Política de Privacidade pode ser alterada periodicamente.<br>
                         <br>
                         Esta Política de Privacidade não reduzirá os seus direitos sem o seu consentimento explícito. Publicaremos todas as alterações da Política de Privacidade nesta página e, se as alterações forem significativas, colocaremos um aviso com mais destaque, incluindo, para alguns serviços, notificação por e-mail das alterações da Política de Privacidade. Também manteremos as versões anteriores desta Política de Privacidade arquivadas para você visualizá-las.</p>
                     <p>
                         Compra segura no innbativel.com.br</p>
                     <p>
                         Nosso site utiliza uma tecnologia avançada de segurança. Todo o tráfego de dados é feito com as informações criptografadas, utilizando-se do certificado SSL (Secure Socket Layer), que é um método padrão usado na Internet para proteger as comunicações entre os usuários da Web e os sites, fornecendo uma compra 100% segura.</p>
                     <p>
                         As informações de cartões de crédito não são armazenadas em nossos sistemas e todo o processo de aprovação é feito diretamente com as Administradoras de Cartões e Bancos. Para sua tranquilidade, o ícone do cadeado fechado, no canto superior da tela, indica absoluta segurança durante a transmissão de dados em sua compra.</p>
                     <p>
                         Para sua segurança, se houver qualquer divergência de informações cadastrais e de pagamento, o innbativel.com.br entrará em contato para confirmar os dados antes de aprovar o pedido.</p>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="form-group">
     <div class="col-md-offset-4 col-md-8">
         {{ Former::actions()
         ->btn_submit('Cadastrar') }}
     </div>
 </div>
 </div>
 {{ Former::hidden('destination')->value(Input::get('destination', Request::getPathInfo())) }}
 {{ Former::hidden('modal')->value('register') }}
 {{Former::close()}}
 <div class="modal-footer">
     Já tem sua conta? <a href="#login" data-toggle="modal" data-dismiss="modal">Faça login</a>
 </div>
 </div>
 </div>
 </div>