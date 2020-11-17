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
    protected $migrationPath;

    public function __construct()
    {
        parent::__construct();
        $this->migrationPath = dirname(dirname(__DIR__)) . migrations_path();
    }

    protected function configure()
    {
        $this
            ->setDescription("Rollback all database migrations")
            ->setHelp("Rollback database migrations, add -f to rollback a specific file. Don't use -s and -f together\n")
            ->addOption('step', 's', InputOption::VALUE_OPTIONAL, 'The batch to rollback')
            ->addOption('file', 'f', InputOption::VALUE_OPTIONAL, 'Rollback a particular file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_rollback($input, $output);
    }

    protected function _rollback($input, $output)
    {
        $migrations = glob("$this->migrationPath*.php");

        $step = $input->getOption('step');
        $fileToRollback = $input->getOption('file');

        if (!$step && !$fileToRollback) {
            $output->writeln("<error>You need to specify a file or step to rollback</error>");
            exit();
        }

        if ($step && $step !== 'all') {
            $migrations = array_slice($migrations, -abs($step), abs($step), true);
        }

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);

            if ($fileToRollback) {
                if (strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                    $this->_down($file, $migration, $output);
                    exit();
                }
            } else {
                $this->_down($file, $migration, $output);
            }
        }

        if ($fileToRollback && !in_array($fileToRollback, $migrations)) {
            $output->writeln("<error>$fileToRollback not found!</error>");
            exit();
        }
    }

    protected function _down($file, $migration, $output)
    {
        require_once $migration;
        $className = 'App\Database\Migrations\\' . Str::studly(\substr($file['filename'], 17));

        $class = new $className;
        $class->down();

        $output->writeln("<info>db rollback on <comment>" . str_replace([dirname(dirname(__DIR__)) . migrations_path(), ".php"], "", $migration)) . "</comment></info>";
    }
}
