<div id="widget-facebook">
    <h4>INNBatível no Facebook</h4>
    <div class="fb-like-box" data-href="http://www.facebook.com/innbativel" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false" width="292"></div>

    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ Configuration::get("fb_app") }}',
                status     : true,
                xfbml      : true
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pt_BR/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

</div>