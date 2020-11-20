<?php
namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseInstallCommand extends Command
{
    protected static $defaultName = 'db:install';

    protected function configure()
    {
        $this 
            ->setDescription("Create new database from .env variables")
            ->setHelp("Create new database from .env variables");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$host = getenv("DB_HOST");
		$user = getenv("DB_USERNAME");
		$password = getenv("DB_PASSWORD");
        $database = getenv("DB_DATABASE");
        
        if (\mysqli_query(
            \mysqli_connect($host, $user, $password, ""),
            "CREATE DATABASE `$database`"
        )) {
            return $output->writeln("<info>$database created successfully.</info>");
        }
        
        return $output->writeln("<error>$database could not be created.</error>");
    }
}
