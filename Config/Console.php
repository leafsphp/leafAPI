<?php
namespace Config;

require __DIR__ . "/paths.php";

use Symfony\Component\Console\Application;

class Console {
	private $app;

	public function __construct()
	{
		$this->app = new Application("<comment>Leaf API <info>v2.0</info></comment>");

		// Random Commands
		$this->app->add(new \Config\Command\ServerCommand());
		$this->app->add(new \Config\Command\ConsoleCommand());

		// Generate Commands
		$this->app->add(new \Config\Command\GenerateMigrationCommand());
		$this->app->add(new \Config\Command\GenerateModelCommand());
		$this->app->add(new \Config\Command\GenerateHelperCommand());
		$this->app->add(new \Config\Command\GenerateControllerCommand());
		$this->app->add(new \Config\Command\GenerateSeedCommand());
		$this->app->add(new \Config\Command\GenerateConsoleCommand());
		$this->app->add(new \Config\Command\GenerateFactoryCommand());

		// Delete Commands
		$this->app->add(new \Config\Command\DeleteModelCommand());
		$this->app->add(new \Config\Command\DeleteSeedCommand());
		$this->app->add(new \Config\Command\DeleteFactoryCommand());
		$this->app->add(new \Config\Command\DeleteControllerCommand());
		$this->app->add(new \Config\Command\DeleteConsoleCommand());

		// Database Commands
		$this->app->add(new \Config\Command\DatabaseInstallCommand());
		$this->app->add(new \Config\Command\DatabaseMigrationCommand());
		$this->app->add(new \Config\Command\DatabaseRollbackCommand());
		$this->app->add(new \Config\Command\DatabaseSeedCommand());
	}

	/**
	 * Register a custom command
	 * 
	 * @param array|Symfony\Component\Console\Command\Command $command: Command to run
	 * 
	 * @return void
	 */
	public function registerCustom($command)
	{
		if (is_array($command)) {
			foreach ($command as $item) {
				$this->registerCustom($item);
			}
		} else {
			$this->app->add(new $command);
		}
	}

	/**
	 * Run the console app
	 */
	public function run()
	{
		$this->app->run();
	}
}