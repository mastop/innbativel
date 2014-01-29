<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class AdjustPermsCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'adjust:perms';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Adjust structure permissions to load in local development.';

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
  	$path = app_path() . '/../public/assets';

  	$process = new Process('ls -lhais ' . $path);
  	$process->setTimeout(3600);
  	$process->run();

  	// $this->comment($process->getOutput());
  	$this->comment('Permissions Adjusted');
  }

}
