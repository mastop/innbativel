<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class AdjustAssetsCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'adjust:assets';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Adjust resource assets to load in local development.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
  	parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
  	$filePrettity = app_path() .'/../vendor/laravel/framework/src/Illuminate/Exception/resources/pretty-template.php';
  	$cmdPrettity = 'sed -i "s/\/\/cdnjs.cloudflare.com\/ajax\/libs\/prettify\/r224\/prettify.js/\/assets\/vendor\/prettify\/prettify.js/g" ';

  	$processPrettity = new Process($cmdPrettity . $filePrettity);
  	$processPrettity->setTimeout(3600);
  	$processPrettity->run();

  	/* ------------------------------------------------------------------------------------------------------------------------------------------ */

  	$filejQuery = app_path() .'/../vendor/laravel/framework/src/Illuminate/Exception/resources/pretty-template.php';
  	$cmdjQuery = 'sed -i "s/\/\/cdnjs.cloudflare.com\/ajax\/libs\/jquery\/1.9.1\/jquery.min.js/\/assets\/vendor\/jquery\/jquery.latest.min.js/g" ';

  	$processjQuery = new Process($cmdjQuery . $filejQuery);
  	$processjQuery->setTimeout(3600);
  	$processjQuery->run();
  	// $this->comment( $processjQuery->getOutput() );
  	$this->comment('Assets Adjusted');
  }

}
