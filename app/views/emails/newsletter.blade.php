@section('content')
<div class="widget">
    <div class="well widget row-fluid">
        {{ Former::horizontal_open() }}

        <textarea id="newsContent" rows="30" class="span-12" onclick="return this.select();">
            @include('emails.newsletter_html', array('data'=>$data))
        </textarea>
        {{ Former::button('Preview')->id('preview')->class('btn btn-large btn-block btn-success') }}


        {{ Former::close() }}
    </div>
</div>

<iframe id='newsFrame' class="span-12" style="width: 100%; height: 600px; display: none; border: 0;"></iframe>
<script type="text/javascript">
$('#preview').click(function(e){
    e.preventDefault();
    $('#newsFrame').show().contents().find('html').html($('#newsContent').val());
    $('html, body').animate({
        scrollTop: $("#newsFrame").offset().top
    }, 2000);
});
</script>
@stop