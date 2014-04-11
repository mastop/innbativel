@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::legend('Dados da Oferta') }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
        {{ Former::text('subsubtitle', 'Subtítulo 2')->class('span12') }}
        {{ Former::text('saveme_title', 'Título SaveMe')->class('span12') }}
        {{ Former::select('destiny_id', 'Destino')->fromQuery(Destiny::all(), 'name')->class('span12  chosen-select') }}

        {{ Former::select('partner_id', 'Empresa Parceira')
        ->addOption(null)
        ->data_placeholder('Selecione uma Empresa Parceira')
        ->fromQuery(User::getAllByRole('parceiro'))
        ->class('span12 chosen-select') }}

        {{ Former::select('ngo_id', 'ONG para Doação')
        ->data_placeholder('Selecione uma ONG')
        ->fromQuery(Ngo::orderBy('name')->get(), 'name')
        ->class('span12 chosen-select')
        }}

        {{ Former::date('starts_on', 'Início da Oferta')->class('span12') }}
        {{ Former::date('ends_on', 'Fim da Oferta')->class('span12') }}


        {{ Former::textarea('features', 'Destaques')->rows(10)->columns(20)->class('span12') }}
        {{ Former::textarea('summary', 'Descrição Resumida')->rows(5)->columns(20)->class('span12') }}
        {{ Former::textarea('rules', 'Regras')->rows(10)->columns(20)->class('span12') }}


        {{ Former::multiselect('offers_includes', 'Inclusos')
        ->fromQuery(Included::orderBy('title')->get())
        ->data_placeholder('Selecione os Itens Inclusos')
        ->class('span12  chosen-select') }}

        {{ Former::select('tell_us_id', 'Depoimento de Cliente')
        ->addOption(null)
        ->fromQuery(TellUs::orderBy('destiny')->get())
        ->data_placeholder('Selecione um Depoimento')
        ->class('span12 chosen-select') }}


        {{ Former::stacked_radios('category_id', 'Categorias')->radios(Category::getAllArray()) }}

        {{ Former::checkbox('display_map', '')
        ->text('Exibir mapa na oferta')
        ->check() }}
        {{ Former::checkbox('is_available', '')
        ->text('Oferta será publicada')
        ->check() }}


        {{ Former::legend('Gêneros') }}

        {{ Former::select('genre_id', 'Gênero 1')
        ->addOption(null)
        ->data_placeholder('Selecione um Gênero')
        ->fromQuery(Genre::orderBy('title')->get())
        ->class('span12 chosen-select')
        }}

        {{ Former::select('genre2_id', 'Gênero 2')
        ->addOption(null)
        ->data_placeholder('Selecione um Gênero')
        ->fromQuery(Genre::orderBy('title')->get())
        ->class('span12 chosen-select')
        }}


        {{ Former::legend('Fotos') }}


        {{-- Macro ImageUpload() está definida em app/start/global.php --}}

        {{HTML::ImageUpload('cover_img', 'Principal')}}
        {{HTML::ImageUpload('offer_old_img', 'Pré-Reservas')}}
        {{HTML::ImageUpload('newsletter_img', 'Newsletter')}}
        {{HTML::ImageUpload('saveme_img', 'Saveme')}}
        {{HTML::ImageUpload('offers_images', 'Demais Imagens', true)}}


        {{ Former::legend('Opções de Venda') }}


        <br>
        <div id="files" class="files"></div>



        {{ Former::actions()
          ->primary_submit('Criar Oferta')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}


        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/load-image.min.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/canvas-to-blob.min.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-process.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-image.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/offer.create.js') }}"></script>
        <script>
            $(function () {
                var $progress = null;
                var $bar = null;
                var url = 'https://{{$s3bucket}}.s3.amazonaws.com/';
                var formWidth = $('div.dropzone').first().width();
                $('.fileupload').each(function(){
                    $(this).fileupload({
                        paramName: 'file',
                        url: url,
                        dropZone: $(this).parent().find('div.dropzone'),
                        dataType: 'xml',
                        imageMaxWidth: 800,
                        //disableImageResize: false,
                        imageMaxHeight: 600,
                        previewMaxWidth: formWidth,
                        previewMaxHeight: 150,
                        //previewMinWidth: 200,
                        //imageCrop: true,
                        previewCrop: true,
                        maxFileSize: 5000000,
                        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                        autoUpload: true,
                        done: function (e, data) {
                            $progress.removeClass('active').hide();
                            var file = data.files[0];
                            var fileName = '{{$uid}}_'+$(this).next().attr('id')+'_'+file.name;
                            var fileURL = url + 'temp/'+fileName;
                            //console.log(data.files);
                            if($(this).attr('multiple')){
                                var multifiles = $(this).parent().find('div.multifiles');
                                var multifile = multifiles.find('div.multifile').first();
                                var multiclone = multifile.clone().sortable({connectWith: ".multifiles"}).insertAfter(multifile);
                                if(file.preview){
                                    multiclone.css("background-image", "url("+file.preview.toDataURL("image/png")+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                                }else{
                                    multiclone.css("background-image", "url("+fileURL+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                                }
                                multiclone.find('input.fileuploaded').val(fileName);
                                multiclone.fadeIn();
                                $(this).parent().find('div.dropinfo').show();
                            }else{
                                if(file.preview){
                                    $(this).parent().find('div.dropzone').css("background-image", "url("+file.preview.toDataURL("image/png")+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                                }else{
                                    $(this).parent().find('div.dropzone').css("background-image", "url("+fileURL+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                                }
                                $(this).parent().find('input.fileuploaded').val(fileName);
                                $(this).parent().find('div.fileremove').show();
                            }
                            $bar.css('width', '0%');
                        },
                        send: function (e, data) {
                            $progress = $(this).parent().find('div.progress');
                            $(this).parent().find('div.dropinfo').hide();
                            $progress.addClass('active').show();
                        },
                        progressall: function (e, data) {
                            $bar = $progress.find('div.bar');
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $bar.css('width', progress + '%');
                        }
                    }).on('fileuploadadd', function (e, data) {
                        var filename = "temp/{{$uid}}_"+$(this).next().attr('id')+"_${filename}";
                        $(this).parent().find('div.dropzone').css("background-image", "none");
                        if(!(data.files[0].type.indexOf('image/') == 0)) {
                            alert('Formato de arquivo inválido! Envie apenas imagens.');
                            return false;
                        }
                        $(this).fileupload(
                            'option',
                            {
                                formData: {
                                    key: filename,
                                    acl: "public-read",
                                    AWSAccessKeyId: "{{ $s3access }}",
                                    policy: "{{ $policy }}",
                                    signature: "{{ $signature }}",
                                    'Content-type': data.files[0].type,
                                    'Cache-Control':'max-age=315360000',
                                    'Expires':'{{$expires}}',
                                    success_action_status:200
                                },
                                sequentialUploads: true
                            }
                        );
                    });
                });
            });
        </script>

    </div>

@stop
