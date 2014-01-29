<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DevelCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'devel:reload';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Reload all caches, autoloads and assets.';

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
    $this->comment(' ');
    $this->comment('Calling -- queue:listen --');
    $this->call('queue:listen');

    $this->comment('-- Calling -> queue:work');
    $this->call('queue:work');

    $this->comment('-- Calling -> cache:clear --');
    $this->call('cache:clear');

    $this->comment('-- Calling -> clear-compiled --');
    $this->call('clear-compiled');

    $this->comment('-- Calling -> dump-autoload --');
    $this->call('dump-autoload');

    $this->comment('-- Calling -> optimize --development --');
    $this->call('optimize');

    $this->comment('-- Calling -> basset:build --development --');
    $this->call('basset:build');
    $this->comment('-- Calling -> basset:build --production --');
    $this->call('basset:build', array('--production' => 'production'));
  }

}
