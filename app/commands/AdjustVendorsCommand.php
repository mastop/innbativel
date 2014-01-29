<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class AdjustVendorsCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'adjust:vendors';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Adjust vendors to app.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
  	parent::__construct();
  }

  private function verifyBaseModel()
  {
  	$file = app_path() .'/../vendor/toddish/verify/src/Toddish/Verify/Models/BaseModel.php';
  	$cmd = 'sed -i "s/\\Eloquent/\\BaseModel/g" ';

  	$process = new Process($cmd . $file);
  	$process->setTimeout(3600);
  	$process->run();

  	$this->comment('Vendor Verify BaseModel Adjusted');
  }

  private function verifyPermission()
  {
  	$file = app_path() .'/../vendor/toddish/verify/src/Toddish/Verify/Models/Permission.php';
  	$cmd = 'sed -i "s/->withTimestamps()//g" ';

  	$process = new Process($cmd . $file);
  	$process->setTimeout(3600);
  	$process->run();

  	$this->comment('Vendor Verify Permission Adjusted');
  }

  private function verifyRole()
  {
  	$file = app_path() .'/../vendor/toddish/verify/src/Toddish/Verify/Models/Role.php';
  	$cmd = 'sed -i "s/->withTimestamps()//g" ';

  	$process = new Process($cmd . $file);
  	$process->setTimeout(3600);
  	$process->run();

  	$this->comment('Vendor Verify Role Adjusted');
  }

  private function verifyUser()
  {
  	$file = app_path() .'/../vendor/toddish/verify/src/Toddish/Verify/Models/User.php';
  	$cmd = 'sed -i "s/->withTimestamps()//g" ';

  	$process = new Process($cmd . $file);
  	$process->setTimeout(3600);
  	$process->run();

  	$this->comment('Vendor Verify User Adjusted');
  }

  private function bootstrapperIcon()
  {
  	$file = app_path() .'/../vendor/patricktalmadge/bootstrapper/src/Bootstrapper/Icon.php';
  	$cmd = 'sed -i "s/glyphicon/icon/g" ';

  	$process = new Process($cmd . $file);
  	$process->setTimeout(3600);
  	$process->run();

  	$this->comment('Vendor Bootstrapper Icon Adjusted');
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
  	$this->bootstrapperIcon();
  	$this->verifyBaseModel();
  	// $this->verifyPermission();
  	// $this->verifyRole();
  	// $this->verifyUser();
  }

}
