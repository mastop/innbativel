@section('javascript')
	<script src="{{ asset('assets/themes/floripa/frontend/js/oferta.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container offer-page">
        @if(Auth::check() && Auth::user()->is('administrador'))
        <a href="{{route('admin.offer.edit', $offer->id)}}" class="btn btn-success" style="float:right"><span class="glyphicon glyphicon-edit"></span> Editar esta Oferta</a>
        @endif
		<div class="row">
			<div class="col-8 col-sm-8 col-lg-8">
                <p class="destiny_title">{{$offer->destiny->name}}</p>
				<h1>{{$offer->title}}</h1>
				<h2>{{$offer->subtitle}}</h2>
				<div class="social-share">
					<div class="fb-like" data-href="{{$offer->url}}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
					
					<div class="fb-share-button" data-href="{{$offer->ufl}}" data-type="button_count"></div>

					<a target="_blank" href="http://twitter.com/home?status={{$offer->subtitle}} à partir de R${{intval($offer->price_with_discount)}}! -> {{$offer->url}}" title="Compartilhe no Twitter"><span class="entypo c-twitter"></span></a>
					
					<a href="#emailShare" title="Compartilhe por Email" data-toggle="modal"><div class="circle"><span class="entypo mail"></span></div></a>
				</div>

			</div>

			<div class="col-4 col-sm-4 col-lg-4">
				<div class="price-header">
					A partir de<br/>
					<span>R$ <strong>{{intval($offer->price_with_discount)}}</strong></span>
					<p>{{$offer->percent_off}}% OFF</p>
				</div>
			</div>
		</div>
		
		<div class="row buy-box-bottom">
			<form class="buy-form" id="buy-form" method="post" action="{{ route('comprar') }}">

				<div itemscope class="col-8 col-sm-8 col-lg-8 clearfix buy-box-top">
					
					<!-- <div class="offer-label"><span class="entypo clock"></span>Período Limitado</div> -->
					<div class="offer-label">{{$offer->genre->icon}}{{$offer->genre->title}}</div>
                    @if($offer->genre2_id > 0)
					<div class="offer-label">{{$offer->genre2->icon}}{{$offer->genre2->title}}</div>
                    @endif
					<div id="fotorama" class="fotorama" data-width="100%" data-ratio="600/250" data-nav="thumbs" data-thumbwidth="90" data-thumbheight="50" data-loop="true" data-autoplay="3000" data-transition="slide" data-arrows="true" data-click="false" data-swipe="true">
                        <a href="{{$offer->cover_img}}">
                            <figure>
                                <img src="{{$offer->cover_img}}">
                            </figure>
                        </a>
                        @foreach($offer->offer_image()->get() as $img)
                        <a href="{{$img->url}}">
                            <figure>
                                <img src="{{$img->url}}">
                            </figure>
                        </a>
                        @endforeach
					</div>
					
					<div class="offer-description">
                        <p>
                            {{$offer->format_features}}
						</p>
					</div>
					
					<ul class="buy-itens buy-options">
						<h3>Opções da oferta <span class="glyphicon glyphicon-chevron-down"></span></h3>
                        @foreach($offer->offer_option()->get() as $k => $option)
						<li>
							<label>
								<input type="checkbox" id="opt{{$k}}" name="opt" value="{{intval($option->price_with_discount)}}">
								<div>
									<small>{{$k + 1}} - {{$option->title}}</small>
									<span>{{$option->subtitle}}</span>
									<div>R$<strong>{{intval($option->price_with_discount)}}</strong></div>
								</div>
								<div class="percent-off"><span><strong>{{$option->percent_off}}</strong>OFF</span></div>
							</label>
						</li>
                        @endforeach
					</ul>

                    @if($offer->offer_additional->toArray())
                    <ul class="buy-itens buy-combo">
                        <h3>Inclua também <span class="glyphicon glyphicon-chevron-down"></span></h3>
                        @foreach($offer->offer_additional as $k => $additional)
                        <li>
                            <label>
                                <input type="checkbox" id="combo{{$k}}" name="add" value="{{intval($additional->price_with_discount)}}">
                                <figure><img src="{{$additional->offer->cover_img}}"></figure>
                                <div class="offer-combo">
                                    <a href="#combo{{$k}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">{{$additional->offer->title}} <span class="entypo chevron-right"></span>{{$additional->title}}</a>
                                    <p>{{$additional->subtitle}}</p>
                                    <div class="price">R$<strong>{{intval($additional->price_with_discount)}}</strong></div>
                                </div>
                                <div class="more-info"><a href="#combo{{$k}}-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
                                <div class="percent-off"><span><strong>{{$additional->percent_off}}</strong>OFF</span></div>
                            </label>
                            <div id="combo{{$k}}-info" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <img src="{{$additional->offer->cover_img}}">
                                            <h4 class="modal-title">{{$additional->offer->title}} <span class="entypo chevron-right"></span> {{$additional->title}} </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                {{$additional->offer->popup_features}}
                                            </p>
                                            <p>Escolha a quantidade na página de pagamento.</p>
                                            <div class="prices-info">
                                                <div class="prices clearfix">
                                                    <div class="price price-discount">Por R$<strong>{{intval($additional->price_with_discount)}}</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="entypo cross"></span>Não, obrigado</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="entypo check"></span>Sim, eu quero</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
				</div>
		
				<div class="col-4 col-sm-4 col-lg-4 buy-box-container">
					<div id="buy-box">
						<div id="total-price" class="hidden">Total R$ <strong></strong></div>
						<div id="buy-alert" class="hidden"><span class="entypo chevron-left"></span>Escolha suas opções</div>
						<div class="tooltip" data-tip="Escolha suas opções antes de comprar">
							<button id="buy-btn" class="btn disabled">Comprar</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
							<!-- <input id="buy-btn" class="btn disabled" type="submit" value="Comprar"> -->
						</div>
						<div class="offer-time">
							Oferta por tempo limitado!
							<div>
								<span class="entypo clock"></span>
								 <ul id="contador">
									<li>00h</li>
									<li>00m</li>
									<li>00s</li>
								</ul>
							</div>
						</div>
						<div class="offer-remain">{{$offer->sold}} cupons vendidos</div>
						<!-- <div class="offer-remain">Restam 12</div> -->
					</div>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-8 col-sm-8 col-lg-8">
				
				<h3>Comentários</h3>
				<div class="fb-comments" data-href="{{$offer->url}}" data-numposts="5" data-colorscheme="light"></div>

			</div>

			<a href="#contact" id="help" data-toggle="modal">
				<span>Tem alguma dúvida?</span>
				<span class="entypo chat"></span> <strong>Fale agora conosco</strong><br/>
				estamos aqui para ajudá-lo
			</a>

		</div>
	</div>

	<div id="regulation" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><span class="entypo text-doc"></span>Regulamento da Oferta</h3>
				</div>
				<div class="modal-body">
					{{$offer->rules}}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="entypo check"></span>Concordo</button>
					<!-- <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="entypo check"></span>Concordo</button> -->
				</div>
			</div>
		</div>
	</div>

	<div id="emailShare" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo mail"></span>Compartilhe com seus amigos</h4>
				</div>
				<form id="emailShareForm" class="form-horizontal" name="emailShareForm" method="post" action="send_form_emailShare.php">
					<div class="modal-body">
						<p>
							Preencha os campos abaixo para compartilhar esta oferta.
						</p>
						<div class="form-group">
							<label class="control-label col-md-4" for="senderName">Seu nome</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="senderName" name="senderName" placeholder="Seu nome"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="senderEmail">Seu email</label>
							<div class="col-md-6 input-group">
								<input type="email" class="form-control" id="senderEmail" name="senderEmail" placeholder="Seu email"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="receiverName">Nome d@ amig@</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="receiverName" name="receiverName" placeholder="Nome do(a) amigo(a)"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="receiverEmail">Email d@ amig@</label>
							<div class="col-md-6 input-group">
								<input type="email" class="form-control" id="receiverEmail" name="receiverEmail" placeholder="Email do(a) amigo(a)"/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Compartilhar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="emailShareResponse" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo check"></span>Oferta compartilhada</h4>
				</div>
				<div class="modal-body">
					<p>
						<strong>Obrigado por compartilhar!</strong>
					</p>
					<p>
						Agora seus amigos também poderão aproveitar esta oferta.
					</p>
				</div>
			</div>
		</div>
	</div>
@stop
