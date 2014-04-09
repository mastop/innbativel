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

        <div class="control-group">
            <label for="fileupload" class="control-label">Principal</label>
            <div class="controls">
                <div id="dropzone" class="fade well dropzone span12">
                    Arraste a imagem até aqui.
                    <p>(ou clique)</p>
                    <div class="progress">
                        <div class="bar progress-bar-success"></div>
                    </div>
                </div>
                <input id="fileupload" type="file" name="file" class="fileupload">
            </div>
        </div>


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
                var $progress = $('#progress').find('.bar');
                var url = 'https://{{$s3bucket}}.s3.amazonaws.com/';
                $('#fileupload').fileupload({
                    url: url,
                    dropZone: $('#dropzone'),
                    dataType: 'xml',
                    imageMaxWidth: 800,
                    imageMaxHeight: 800,
                    imageCrop: true,
                    maxFileSize: 5000000,
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                    done: function (e, data) {
                        $.each(data.files, function (index, file) {
                            console.log(file);
                            $('<p/>').text(file.name).html(file.preview).appendTo('#files');
                        });
                    },
                    success: function(e, data) {
                        console.log(data);
                        var url = $(data).find('Location').text()

                        //alert(url);
                    },
                    send: function (e, data) {
                        alert($(this).attr('id'));
                        var $progress = $(this).parent().find('div.progress');
                        var $bar = $progress.find('div.bar');
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $progress.css('width', progress + '%');
                    },
                    progressall: function (e, data) {
                        var $progress = $(this).parent().find('div.progress');
                        var $bar = $progress.find('div.bar');
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $progress.css('width', progress + '%');
                    }
                }).on('fileuploadadd', function (e, data) {
                    $('#fileupload').fileupload(
                        'option',
                        {
                            formData: {
                                key: "temp/{{$uid}}_${filename}",
                                acl: "public-read",
                                AWSAccessKeyId: "{{ $s3access }}",
                                policy: "{{ $policy }}",
                                signature: "{{ $signature }}",
                                'Content-type': data.files[0].type,
                                'Cache-Control':'max-age=315360000',
                                'Expires':'{{$expires}}'
                            },
                            sequentialUploads: true
                        }
                    );
                    return console.log(data.files[0]);

                    return false;
                    data.context = $('<div/>').appendTo('#files');
                    $.each(data.files, function (index, file) {
                        var node = $('<p/>')
                            .append($('<span/>').text(file.name));
                        if (!index) {
                            node
                                .append('<br>')
                                .append(uploadButton.clone(true).data(data));
                        }
                        node.appendTo(data.context);
                    });
                }).on('fileuploadprocessalways', function (e, data) {
                    return false;
                    return console.log(data);
                    var index = data.index,
                        file = data.files[index],
                        node = $(data.context.children()[index]);
                    if (file.preview) {
                        node
                            .prepend('<br>')
                            .prepend(file.preview);
                    }
                    if (file.error) {
                        node
                            .append('<br>')
                            .append($('<span class="text-danger"/>').text(file.error));
                    }
                    if (index + 1 === data.files.length) {
                        data.context.find('button')
                            .text('Upload')
                            .prop('disabled', !!data.files.error);
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    return false;
                    return console.log(data);
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }).on('fileuploaddone', function (e, data) {
                    return false;
                    return console.log(data);
                    $.each(data.result.files, function (index, file) {
                        if (file.url) {
                            var link = $('<a>')
                                .attr('target', '_blank')
                                .prop('href', file.url);
                            $(data.context.children()[index])
                                .wrap(link);
                        } else if (file.error) {
                            var error = $('<span class="text-danger"/>').text(file.error);
                            $(data.context.children()[index])
                                .append('<br>')
                                .append(error);
                        }
                    });
                }).on('fileuploadfail', function (e, data) {
                    return false;
                    return console.log(data);
                    $.each(data.files, function (index, file) {
                        var error = $('<span class="text-danger"/>').text('File upload failed.');
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    });
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        </script>

    </div>

@stop
