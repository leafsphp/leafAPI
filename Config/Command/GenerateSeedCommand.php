<?php
    namespace Config\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Illuminate\Support\Str;
    
    class GenerateSeedCommand extends Command
    {
        protected static $defaultName = 'g:seed';

        public function __construct()
        {
            parent::__construct();
        }
    
        protected function configure()
        {
            $this 
                ->setDescription("Create a new seed file")
                ->setHelp("Create a new seed file")
                ->addArgument('model', InputArgument::REQUIRED, "model name")
                ->addArgument("name", InputArgument::OPTIONAL, "seed name");
        }
    
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $modelName = Str::studly(Str::singular($input->getArgument("model")));
            $seedName = $input->getArgument("name") ?? $modelName;
            $className = Str::studly(Str::plural($seedName));

            if (!strpos($seedName, "Seeder")) {
                $className .= "Seeder";
            }
            
            $filename = $className . ".php";
            $file = BaseCommand::seeds_path($filename);

            if (file_exists($file)) {
                return $output->writeln("<error>$seedName already exists</error>");
            }

            touch($file);

            $fileContent = \file_get_contents(__DIR__ . '/stubs/seed.stub');
            $fileContent = str_replace(
                ["ClassName", "ModelName", "entity"],
                [$className, $modelName, Str::lower($modelName)],
                $fileContent
            );
            file_put_contents($file, $fileContent);

            $output->writeln("<comment>$filename generated successfully</comment>");
        }
    }