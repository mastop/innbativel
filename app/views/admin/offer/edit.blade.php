@section('content')

{{ Former::open_for_files()->populate($offer)->rules(Offer::$rules) }}
	<div class="row-fluid">
		<div class="span6">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Oferta</h6>
				</div>
			</div>
			<div class="well widget ">

				{{ Former::text('title', 'Título')->class('span12') }}
				{{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
				{{ Former::text('destiny', 'Destino')->class('span12') }}
				{{ Former::text('event', 'Evento')->class('span12') }}
				{{ Former::text('saveme_title', 'Título Saveme')->class('span12') }}
				{{ Former::select('partner_id', 'Parceiro')
				->addOption('-- selecione uma opção --', null)
				->fromQuery(DB::table('users')->get(['id', 'email']), 'email', 'id')
				->class('span12')
				}}
				{{ Former::select('genre_id', 'Gênero')
				->addOption('-- selecione uma opção --', null)
				->fromQuery(DB::table('genres')->get(['id', 'name']), 'name', 'id')
				->class('span12')
				}}
				{{ Former::select('ngo_id', 'ONG')
				->addOption('-- selecione uma opção --', null)
				->fromQuery(DB::table('ngos')->get(['id', 'name']), 'name', 'id')
				->class('span12')
				}}
				{{ Former::text('starts_on', 'Inicia em')->class('span12') }}
				{{ Former::text('ends_on', 'Termina em')->class('span12') }}
				{{ Former::text('description', 'descrição')->class('span12') }}
				{{ Former::text('general_rules', 'regras Gerais')->class('span12') }}
				{{ Former::text('video', 'Vídeo')->class('span12') }}
				{{ Former::text('display_order', 'Ordem de Exibição')->class('span12') }}
				{{ Former::text('pre_booking_order', 'pre_booking_order')->class('span12') }}
			</div>
		</div>
		<div class="span6">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Imagens</h6>
				</div>
			</div>
			<div class="well widget">
				<div class="clearfix">
					@if(isset($offer->cover_img) && !is_null($offer->cover_img) && !empty($offer->cover_img))
			        	@if(isset($offer->cover_img['preview']))
						<figure class="span4 form-file-thumb"><img src="{{ asset($offer->cover_img['preview']) }}"></figure>
						@endif
						<div class="span4">
							<a href="{{ route('admin.offer.clearfield', [$offer->id, 'cover_img']) }}" class="btn btn-danger tip" title="Alterar Imagem">
								<i class="icon-trash"></i>
							</a>
						</div>
					@else
						{{ Former::file('cover_img', 'Imagem de Capa')->accept('png', 'jpg', 'jpeg')->class('span12') }}
					@endif







					@if(isset($offer->offer_old_img) && !is_null($offer->offer_old_img) && !empty($offer->offer_old_img))
			        	@if(isset($offer->offer_old_img['preview']))
						<figure class="span4 form-file-thumb"><img src="{{ asset($offer->offer_old_img['preview']) }}"></figure>
						@endif
						<div class="span4">
							<a href="{{ route('admin.offer.clearfield', [$offer->id, 'offer_old_img']) }}" class="btn btn-danger tip" title="Alterar Imagem">
								<i class="icon-trash"></i>
							</a>
						</div>
					@else
						{{ Former::file('offer_old_img', 'Imagem Antiga ???')->accept('png', 'jpg', 'jpeg')->class('span12') }}
					@endif











					<?php /*
					@if(isset($offer->offer_old_img) && !is_null($offer->offer_old_img) && !empty($offer->offer_old_img))
						{{ Former::file('offer_old_img', 'Imagem da Pré Reservas')
							->accept('png', 'jpg', 'jpeg')
							->class('span12')
							->addGroupClass('span8')
						}}
						<div class="span4 form-file-thumb"><img src="{{ $offer->offer_old_img }}"></div>
					@else
						{{ Former::file('offer_old_img', 'Imagem da Pré Reservas')->accept('png', 'jpg', 'jpeg')->class('span12') }}
					@endif

					@if(isset($offer->newsletter_img) && !is_null($offer->newsletter_img) && !empty($offer->newsletter_img))
						{{ Former::file('newsletter_img', 'Newsletter')
							->accept('png', 'jpg', 'jpeg')
							->class('span12')
							->addGroupClass('span8')
						}}
						<div class="span4 form-file-thumb"><img src="{{ $offer->newsletter_img }}"></div>
					@else
						{{ Former::file('newsletter_img', 'Newsletter')->accept('png', 'jpg', 'jpeg')->class('span12') }}
					@endif

					@if(isset($offer->saveme_img) && !is_null($offer->saveme_img) && !empty($offer->saveme_img))
						{{ Former::file('saveme_img', 'Saveme')
							->accept('png', 'jpg', 'jpeg')
							->class('span12')
							->addGroupClass('span8')
						}}
						<div class="span4 form-file-thumb"><img src="{{ $offer->saveme_img }}"></div>
					@else
						{{ Former::file('saveme_img', 'Saveme')->accept('png', 'jpg', 'jpeg')->class('span12') }}
					@endif

					*/
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="well widget">
			{{ Former::actions()->primary_submit('Atualizar Oferta')->inverse_reset('Restaurar Valores') }}
		</div>
	</div>
{{ Former::close() }}

@stop
