<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;

class DatabaseSeedCommand extends Command {

    protected static $defaultName = "db:seed";

    public function __construct() {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Seed the database with records")
            ->setHelp("Seed the database with records");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists(BaseCommand::seeds_path("DatabaseSeeder.php"))) {
            return $output->writeln("<error>DatabaseSeeder not found! Refer to the docs.</error>");
        }

        $seeder = new \App\Database\Seeds\DatabaseSeeder;
        $seeds = glob(BaseCommand::seeds_path("*.php"));

        if (count($seeds) === 1) {
            return $output->writeln("<error>No seeds found! Create one with the g:seed command.</error>");
        }

        if (count($seeder->run()) === 0) {
            return $output->writeln("<error>No seeds registered. Add your seeds in DatabaseSeeder.php</error>");
        }

        foreach ($seeder->run() as $seed) {
            $seeder->call($seed);
            $output->writeln("> <comment>$seed</comment> seeded successfully");
        }

        $output->writeln("<info>Database seed complete</info>");
    }
}