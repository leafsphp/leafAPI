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
            $this->seedsPath = dirname(dirname(__DIR__)) . seeds_path();
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
            $className = Str::studly(Str::singular($seedName));

            if (!strpos($seedName, "Seeder")) {
                $className .= "Seeder";
            }
            
            $filename = $className . ".php";
            $file = $this->seedsPath . $filename;

            if (!file_exists($file)):
                touch($file);

                $fileContent = \file_get_contents(__DIR__ . '/stubs/seed.stub');
                $fileContent = str_replace(["ClassName", "modelName"], [$className, $modelName], $fileContent);
                file_put_contents($file, $fileContent);

                $output->writeln("$filename generated successfully");
            else:
                $output->writeln("<error>$seedName already exists</error>");
            endif;
        }
    }