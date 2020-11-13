<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;

class DatabaseSeedCommand extends Command {

    protected static $defaultName = "db:seed";

    public function __construct() {
        $this->seedPath = dirname(dirname(__DIR__)) . '/App/Database/Seeds/';
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
        $seeds = glob($this->seedPath . '*.php');
        
        foreach ($seeds as $seed) {
            $file = pathinfo($seed);
            $filename = $file['filename'];

            if ($filename !== ""):

                $className = Str::studly(str_replace(".php","",$filename));
                $this->seed($filename, $className);
                $output->writeln("> ".str_replace(".php","",$file['basename']) . ' seeded successfully');

            endif;
        }

        $output->writeln("Database seed complete");
    }

    protected function seed($filename, $className) {
        $class = "\App\Database\Seeds\\".$className;
        $seed = new $class;
        $seed->run();
    }
}