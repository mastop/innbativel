<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(
	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/helpers',
	app_path().'/exceptions',
	app_path().'/database/seeds',
));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Required Files
|--------------------------------------------------------------------------
|
| Loads required files for workflow application.
|
*/

$required_paths = [
	app_path() . '/libraries',
	app_path() . '/errors',
	app_path() . '/routes',
	app_path() . '/filters',
	app_path() . '/macros',
	app_path() . '/creators',
	app_path() . '/composers',
	app_path() . '/shares',
	app_path() . '/events',
	app_path() . '/queues',
	app_path() . '/validators',
];

foreach ($required_paths as $required_path) {

	$required_files = File::files($required_path);

	foreach ($required_files as $required_file) {
		File::getRequire($required_file);
	}

}

// Macro para adicionar o campo de imagem com upload

HTML::macro('ImageUpload', function($name, $label, $multiple = false)
{
    $filefield = ($multiple) ? '<input id="'.$name.'_file" type="file" name="'.$name.'_file[]" class="fileupload" accept="image/*" multiple>' : '<input id="'.$name.'_file" type="file" name="'.$name.'_file" class="fileupload" accept="image/*">';
    $hiddenfield = ($multiple) ? '<input id="'.$name.'" type="hidden" name="'.$name.'[]" class="fileuploaded" value="">' : '<input id="'.$name.'" type="hidden" name="'.$name.'" class="fileuploaded" value="">';
    $text = ($multiple) ? 'Arraste as imagens até aqui' : 'Arraste a imagem até aqui';
    $multipleDiv = '<div class="clearfix"></div><div class="multifiles">
                         <div class="multifile">
                            '.Button::danger('<span class="icon icon-remove"> Remover</span>', ['class'=>'btn-mini']).'
                            '.$hiddenfield.'
                         </div>
                    </div>';
    return '<div class="control-group">
            <label for="'.$name.'_file" class="control-label">'.$label.'</label>
            <div class="controls">
                <div class="fade well dropzone span12">
                    <div class="dropinfo">
                        '.$text.'
                        <p>(ou clique)</p>
                    </div>
                    <div class="progress" style="display: none">
                        <div class="bar progress-bar-success"></div>
                    </div>
                    <div class="fileremove">
                        '.Button::danger('<span class="icon icon-remove"> Remover</span>', ['class'=>'btn-mini']).'
                    </div>
                </div>
                '.$filefield.$hiddenfield.'
                '.(($multiple) ? $multipleDiv : '').'
            </div>
        </div>';
});