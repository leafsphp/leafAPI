<?php
    namespace Config\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Illuminate\Support\Str;
    
    class GenerateMigrationCommand extends Command
    {
        // the name of the command (the part after "bin/console")
        protected static $defaultName = 'g:migration';

        public function __construct()
        {
            parent::__construct();
        }
    
        protected function configure()
        {
            $this 
                ->setDescription("Create a new migration file")
                ->setHelp("Create a new migration file")
                ->addArgument("migration", InputArgument::REQUIRED, "migration file name");
        }
    
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $userInput = strtolower(Str::snake(Str::plural($input->getArgument("migration"))));

            if (strpos($userInput, "create") === false) {
                $userInput = Str::snake("create_$userInput");
            }

            $actualFileName = Str::snake(date("Y_m_d_His") . "_$userInput.php");
            $file = BaseCommand::migrations_path($actualFileName);
            
            touch($file);
            
            $className = Str::studly($userInput);

            $fileContent = \file_get_contents(__DIR__ . '/stubs/migration.stub');
            $fileContent = str_replace(["ClassName", "tableName"], [$className, str_replace("create_", "", $userInput)], $fileContent);
            
            file_put_contents($file, $fileContent);

            $output->writeln("<info><comment>$actualFileName</comment> generated successfully</info>");
        }
    }