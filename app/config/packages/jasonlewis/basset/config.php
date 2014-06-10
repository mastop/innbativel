<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    */

    'collections' => [

      'frontend' => function($collection)
      {
        $collection->stylesheet('assets/themes/floripa/frontend/css/bootstrap.css')->apply('UriRewriteFilter')->andApply('CssMin');
        $collection->javascript('jquery');
        $collection->javascript('jquery-migrate');
        $collection->javascript('bootstrap-js');
        $collection->javascript('assets/themes/floripa/frontend/js/main.js');
      },

      'backend' => function($collection)
      {
        $collection->stylesheet('assets/themes/floripa/backend/css/plugins.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/js/plugins/select2/select2.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/js/plugins/redactor/redactor.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/js/plugins/file-upload/css/jquery.fileupload.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/css/font-awesome.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/css/icons.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/css/jquery.custom.css')->apply('UriRewriteFilter');
        $collection->stylesheet('assets/themes/floripa/backend/css/main.css')->apply('UriRewriteFilter');
        $collection->javascript('modernizr')->apply('JsMin');
        $collection->javascript('jquery')->apply('JsMin');
        $collection->javascript('jquery-migrate')->apply('JsMin');
        $collection->javascript('jquery-ui')->apply('JsMin');
        $collection->javascript('assets/vendor/jquery.ui/stable/ui/i18n/jquery.ui.datepicker-pt-BR.js')->apply('JsMin');
        $collection->javascript('jquery-cookie')->apply('JsMin');
        $collection->javascript('jquery-hashchange')->apply('JsMin');
        $collection->javascript('jquery-easytabs')->apply('JsMin');
        $collection->javascript('jquery-collapsible')->apply('JsMin');
        $collection->javascript('jquery-inputmask')->apply('JsMin');
        $collection->javascript('jquery-select2')->apply('JsMin');
        $collection->javascript('jquery-select2-ptbr')->apply('JsMin');
        $collection->javascript('jquery-redactor')->apply('JsMin');
        $collection->javascript('jquery-redactor-ptbr')->apply('JsMin');
        $collection->javascript('jquery-redactor-fontsize')->apply('JsMin');
        $collection->javascript('bootstrap-js')->apply('JsMin');
        $collection->javascript('underscore')->apply('JsMin');
        $collection->javascript('holder')->apply('JsMin');
        $collection->javascript('prettify-js')->apply('JsMin');
        $collection->javascript('main-js')->apply('JsMin');
      },

    ],

    /*
    |--------------------------------------------------------------------------
    | Production Environment
    |--------------------------------------------------------------------------
    |
    | Basset needs to know what your production environment is so that it can
    | respond with the correct assets. When in production Basset will attempt
    | to return any built collections. If a collection has not been built
    | Basset will dynamically route to each asset in the collection and apply
    | the filters.
    |
    | The last method can be very taxing so it's highly recommended that
    | collections are built when deploying to a production environment.
    |
    | You can supply an array of production environment names if you need to.
    |
    */

    'production' => ['production78iukjdsnf'],

    /*
    |--------------------------------------------------------------------------
    | Build Path
    |--------------------------------------------------------------------------
    |
    | When assets are built with Artisan they will be stored within a directory
    | relative to the public directory.
    |
    | If the directory does not exist Basset will attempt to create it.
    |
    */

    'build_path' => 'assets/cdn',

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Enable debugging to have potential errors or problems encountered
    | during operation logged to a rotating file setup.
    |
    */

    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    | Node Paths
    |--------------------------------------------------------------------------
    |
    | Many filters use Node to build assets. We recommend you install your
    | Node modules locally at the root of your application, however you can
    | specify additional paths to your modules.
    |
    */

    'node_paths' => [
        base_path().'/node_modules'
    ],

    /*
    |--------------------------------------------------------------------------
    | Gzip Built Collections
    |--------------------------------------------------------------------------
    |
    | To get the most speed and compression out of Basset you can enable Gzip
    | for every collection that is built via the command line. This is applied
    | to both collection builds and development builds.
    |
    | You can use the --gzip switch for on-the-fly Gzipping of collections.
    |
    */

    'gzip' => false,

    /*
    |--------------------------------------------------------------------------
    | Asset and Filter Aliases
    |--------------------------------------------------------------------------
    |
    | You can define aliases for commonly used assets or filters.
    | An example of an asset alias:
    |
    |   'layout' => 'stylesheets/layout/master.css'
    |
    | Filter aliases are slightly different. You can define a simple alias
    | similar to an asset alias.
    |
    |   'YuiCss' => 'Yui\CssCompressorFilter'
    |
    | However if you want to pass in options to an aliased filter then define
    | the alias as a nested array. The key should be the filter and the value
    | should be a callback closure where you can set parameters for a filters
    | constructor, etc.
    |
    |   'YuiCss' => ['Yui\CssCompressorFilter', function($filter)
    |   {
    |       $filter->setArguments('path/to/jar');
    |   }]
    |
    |
    */

    'aliases' => [

        'assets' => [

            'modernizr'                 => 'assets/vendor/modernizr/modernizr.min.js',
            'jquery'                    => 'assets/vendor/jquery/jquery.latest.min.js',
            'jquery-migrate'            => 'assets/vendor/jquery.migrate/jquery.migrate.min.js',
            'jquery-ui'                 => 'assets/vendor/jquery.ui/jquery.ui.stable.min.js',
            'jquery-cookie'         	=> 'assets/vendor/jquery.cookie/jquery.cookie.js',
            'jquery-hashchange'         => 'assets/vendor/jquery.hashchange/jquery.ba-hashchange.min.js',
            'jquery-easytabs'           => 'assets/vendor/jquery.easytabs/jquery.easytabs.min.js',
            'jquery-collapsible'        => 'assets/vendor/jquery.collapsible/jquery.collapsible.min.js',
            'jquery-inputmask'          => 'assets/vendor/jquery.inputmask/dist/jquery.inputmask.bundle.min.js',
            'jquery-datatables'         => 'assets/themes/floripa/backend/js/plugins/tables/jquery.dataTables.min.js',
            'jquery-select2'            => 'assets/themes/floripa/backend/js/plugins/select2/select2.js',
            'jquery-select2-ptbr'       => 'assets/themes/floripa/backend/js/plugins/select2/select2_locale_pt-BR.js',
            'jquery-redactor'           => 'assets/themes/floripa/backend/js/plugins/redactor/redactor.min.js',
            'jquery-redactor-ptbr'      => 'assets/themes/floripa/backend/js/plugins/redactor/lang/pt_br.js',
            'jquery-redactor-fontsize'  => 'assets/themes/floripa/backend/js/plugins/redactor/plugins/fontsize/fontsize.js',
            'bootstrap-js'              => 'assets/vendor/bootstrap/3/dist/js/bootstrap.min.js',
            'prettify-js'               => 'assets/vendor/prettify/prettify.js',
            'underscore'                => 'assets/vendor/underscore/underscore.min.js',
            'backbone'                  => 'assets/vendor/backbone/backbone.min.js',
            'holder'                    => 'assets/vendor/holder/holder.js',
            'main-js'                   => 'assets/themes/floripa/backend/js/main.js',

        ],

        'filters' => [

            /*
            |--------------------------------------------------------------------------
            | Less Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".less" extension and it will
            | attempt to find missing constructor arguments.
            |
            */

            'Less' => ['LessFilter', function($filter)
            {
              $filter->whenAssetIs('.*\.less')->findMissingConstructorArgs();
            }],

            /*
            |--------------------------------------------------------------------------
            | Sass Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".sass" or ".scss" extension and
            | it will attempt to find missing constructor arguments.
            |
            */

            'Sass' => ['Sass\ScssFilter', function($filter)
            {
              $filter->whenAssetIs('.*\.(sass|scss)')->findMissingConstructorArgs();
            }],

            /*
            |--------------------------------------------------------------------------
            | CoffeeScript Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".coffee" extension and it will
            | attempt to find missing constructor arguments.
            |
            */

            'CoffeeScript' => ['CoffeeScriptFilter', function($filter)
            {
              $filter->whenAssetIs('.*\.coffee')->findMissingConstructorArgs();
            }],

            /*
            |--------------------------------------------------------------------------
            | CssMin Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when within the production environment and when
            | the "CssMin" class exists.
            |
            */

            'CssMin' => ['CssMinFilter', function($filter)
            {
              $filter->whenAssetIsStylesheet()->whenProductionBuild()->whenClassExists('CssMin');
            }],

            /*
            |--------------------------------------------------------------------------
            | JsMin Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when within the production environment and when
            | the "JsMin" class exists.
            |
            */

            'JsMin' => ['JSMinFilter', function($filter)
            {
              $filter->whenAssetIsJavascript()->whenProductionBuild()->whenClassExists('JSMin');
            }],

            /*
            |--------------------------------------------------------------------------
            | UriRewrite Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter gets a default argument of the path to the public directory.
            |
            */

            'UriRewriteFilter' => ['UriRewriteFilter', function($filter)
            {
              $filter->setArguments(public_path())->whenAssetIsStylesheet();
            }],

        ]
    ]
];
