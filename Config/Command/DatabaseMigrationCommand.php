<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class DatabaseMigrationCommand extends Command
{
    protected static $defaultName = "db:migrate";

    public function __construct()
    {
        $this->migrationPath = dirname(dirname(__DIR__)) . migrations_path();
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Run the database migrations")
            ->setHelp("Run the migrations defined in the migrations directory\n")
            ->addOption('file', 'f', InputOption::VALUE_OPTIONAL, 'Rollback a particular file');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileToRollback = $input->getOption('file');
        $this->_runMigrations($output, $fileToRollback);
    }

    public function _runMigrations($output, $fileToRollback)
    {
        $migrations = glob($this->migrationPath . '*.php');

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $filename = $file['filename'];

            if ($filename !== "Schema") :
                $className = '\App\Database\Migrations\\' . Str::studly(\substr($filename, 17));

                if ($fileToRollback) {
                    if (strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                        $this->migrate($className, $filename);
                        $output->writeln('<info>db migration on <comment>' . str_replace(dirname(dirname(__DIR__)) . migrations_path(), "", $migration . "</comment></info>"));
                        exit();
                    }

                    continue;
                } else {
                    $this->migrate($className, $filename);
                }

                $output->writeln('<info>db migration on <comment>' . str_replace(dirname(dirname(__DIR__)) . migrations_path(), "", $migration . "</comment></info>"));
            endif;
        }
    }

    protected function migrate($className, $filename)
    {
        require_once migrations_path("$filename.php", false);

        $class = new $className;
        $class->up();
    }
}
