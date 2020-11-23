<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class GenerateSeedCommand extends Command
{
	protected static $defaultName = 'g:seed';

	protected function configure()
	{
		$this 
			->setDescription("Create a new seed file")
			->setHelp("Create a new seed file")
			->addArgument('model', InputArgument::REQUIRED, "model name")
			->addArgument("name", InputArgument::OPTIONAL, "seed name")
			->addOption("factory", "f", InputOption::VALUE_NONE, "Create a factory for seeder");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$modelName = Str::studly(Str::singular($input->getArgument("model")));
		$seedName = $input->getArgument("name") ?? $modelName;
		$factory = $input->getOption("factory");
		$className = Str::studly(Str::plural($seedName));

		if (!strpos($seedName, "Seeder")) {
			$className .= "Seeder";
		}

		$file = BaseCommand::seeds_path("$className.php");

		if (file_exists($file)) {
			return $output->writeln("<error>$seedName already exists</error>");
		}

		touch($file);
		
		$fileContent = \file_get_contents(__DIR__ . '/stubs/seed.stub');

		if ($factory && !file_exists(BaseCommand::factories_path("{$modelName}Factory.php"))) {
			$fileContent = str_replace(
				[
					"// You can directly create db records",
					"
use App\Models\ModelName;",
					'

        // $entity = new ModelName();
        // $entity->field = \'value\';
        // $entity->save();

        // or

        // ModelName::create([
        //    "field" => "value"
        // ]);'
				],
				["(new ModelNameFactory)->create(5)->save();", "", ""],
				$fileContent
			);
		}

		$fileContent = str_replace(
			["ClassName", "ModelName", "entity"],
			[$className, $modelName, Str::lower($modelName)],
			$fileContent
		);
		
		file_put_contents($file, $fileContent);
		
		$output->writeln("<comment>$className generated successfully</comment>");

		if ($factory && !file_exists(BaseCommand::factories_path("{$modelName}Factory.php"))) {
			$output->writeln("<comment>" . shell_exec("php leaf g:factory $modelName") . "</comment>");
		}
	}
}
