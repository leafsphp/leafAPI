<?php
namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    protected static $defaultName = "example";

    public function __construct(){
        parent::__construct();
    }


    protected function configure()
    {
        $this 
            ->setDescription("example command")
            ->setHelp("example's help");
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("example's output");
    }
}