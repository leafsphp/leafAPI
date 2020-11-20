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

        $migrations = glob(BaseCommand::migrations_path('*.php'));

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $filename = $file['filename'];

            if ($filename !== "Schema") :
                $className = '\App\Database\Migrations\\' . Str::studly(\substr($filename, 17));

                if ($fileToRollback) {
                    if (strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                        $this->migrate($className, $filename);
                        $output->writeln("<info>db migration on <comment>" . str_replace(BaseCommand::migrations_path(), "", $migration) . "</comment></info>");
                        exit();
                    }

                    continue;
                } else {
                    $this->migrate($className, $filename);
                }

                $output->writeln("> db migration on <comment>" . str_replace(BaseCommand::migrations_path(), "", $migration) . "</comment>");
            endif;
        }

        $output->writeln("<info>Database migration completed!</info>\n");
    }

    protected function migrate($className, $filename)
    {
        require_once migrations_path("$filename.php", false);

        $class = new $className;
        $class->up();
    }
}
