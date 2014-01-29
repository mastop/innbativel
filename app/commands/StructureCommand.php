<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class StructureCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'structure:organize';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Organize structure with permissions.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  protected function directories($path)
  {
		$fs = new Filesystem();
		$fr = new Finder();

		$fr->directories()
       ->in($path)
       ->exclude('storage');

		foreach ($fr as $fl) {
			$this->comment('-- permissions on '.$fl->getRelativePathname().' --');
			$fs->chmod($fl->getRealpath(), 0700, false);
		}
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
		$path = app_path();

		$this->comment('-- permissions on app --');
		$this->comment('-- ------------------ --');

		$this->directories($path);
  }

}
