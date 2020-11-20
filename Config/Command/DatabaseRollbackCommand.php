<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class DatabaseRollbackCommand extends Command
{
    protected static $defaultName = "db:rollback";

    protected function configure()
    {
        $this
            ->setDescription("Rollback all database migrations")
            ->setHelp("Rollback database migrations, add -f to rollback a specific file. Don't use -s and -f together\n")
            ->addOption('step', 's', InputOption::VALUE_OPTIONAL, 'The batch to rollback', 'all')
            ->addOption('file', 'f', InputOption::VALUE_OPTIONAL, 'Rollback a particular file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrations = glob(BaseCommand::migrations_path("*.php"));

        $step = $input->getOption('step');
        $fileToRollback = $input->getOption('file');

        if ($step !== 'all') {
            $migrations = array_slice($migrations, -abs($step), abs($step), true);
        }

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);

            if (!$fileToRollback) {
                $output->writeln($this->_down($file, $migration));
            }

            if ($fileToRollback && strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                return $output->writeln($this->_down($file, $migration));
            }
        }

        if ($fileToRollback && !in_array($fileToRollback, $migrations)) {
            return $output->writeln("<error>$fileToRollback not found!</error>");
        }

        $output->writeln("<info>Database rollback completed!</info>\n");
    }

    protected function _down($file, $migration)
    {
        require_once $migration;
        $className = 'App\Database\Migrations\\' . Str::studly(\substr($file['filename'], 17));

        $migrationName = str_replace([BaseCommand::migrations_path(), ".php"], "", $migration);

        $class = new $className;
        $class->down();

        return "> db rollback on <comment>$migrationName</comment>";
    }
}
