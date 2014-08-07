@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'link' => 'required|url',
        	'img' => 'required',
        ]) }}

        {{ Former::populate($banner) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
        {{ Former::text('link', 'Link')->class('span12')->placeholder('HTTP://') }}
        {{HTML::ImageUpload('img', 'Imagem', false, false, '461x483')}}
        {{ Former::checkbox('is_active', '')
        ->text('Banner Ativo')}}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/load-image.min.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/canvas-to-blob.min.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-image.js') }}"></script>
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
                previewMaxWidth: formWidth,
                previewMaxHeight: 150,
                //previewMinWidth: 200,
                //imageCrop: true,
                previewCrop: false,
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
        // Caso imagens já estejam pré-selecionadas
        $('input.fileuploaded').each(function(){
            if($(this).val() != ''){
                // Single file
                var fileURL = ($(this).val().substring(0, 2) == '//') ? $(this).val() : url + 'temp/'+$(this).val();
                $(this).parent().find('div.dropzone').css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).parent().find('div.fileremove').show();
                $(this).parent().find('div.dropinfo').hide();
            }else if($(this).parent().data('img') != undefined){
                // Multi files
                var fileURL = ($(this).parent().data('img').substring(0, 2) == '//') ? $(this).parent().data('img') : url + 'temp/'+$(this).parent().data('img');
                $(this).parent().css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).val($(this).parent().data('img'));
                $(this).parent().fadeIn();
                $(this).parent().sortable({connectWith: ".multifiles"});
            }
        });
        $(document).bind('dragover', function (e)
        {
            var dropZone = $('.dropzone'),
                foundDropzone,
                timeout = window.dropZoneTimeout;
            if (!timeout)
            {
                dropZone.addClass('in');
            }
            else
            {
                clearTimeout(timeout);
            }
            var found = false,
                node = e.target;

            do{

                if ($(node).hasClass('dropzone'))
                {
                    found = true;
                    foundDropzone = $(node);
                    break;
                }

                node = node.parentNode;

            }while (node != null);

            dropZone.removeClass('in hover');

            if (found)
            {
                foundDropzone.addClass('hover');
            }

            window.dropZoneTimeout = setTimeout(function ()
            {
                window.dropZoneTimeout = null;
                dropZone.removeClass('in hover');
            }, 100);
        });
        $(document).bind('drop dragover', function (e) {
            e.preventDefault();
        });
        $('.dropzone').click(function(){
            $(this).parent().find('input[type=file]').click();
        });
        $('div.fileremove button').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            var parent = $(this).parent().parent().parent();
            // Remove o BG do Dropzone
            parent.find('div.dropzone').css("background-image", "none");
            // Exibe o Texto DropInfo
            parent.find('div.dropinfo').show();
            // Zera o valor do input Hidden
            parent.find('input.fileuploaded').val(null);
            // Se esconde
            $(this).parent().hide();
        });
        $( "div.multifiles" ).on( "click", "button", function() {
            $(this).parent().fadeOut('slow').remove();
        });
        $( "div.multifiles" ).sortable({
            placeholder: "dropPlaceHolder",
            connectWith: ".multifiles",
            revert: true
        });
        $( "div.multifiles, div.multifile, div.multifile button").disableSelection();
    });
</script>
@stop


