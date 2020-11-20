<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;
use Config\Command\BaseCommand;

class DeleteControllerCommand extends Command {

    protected static $defaultName = "d:controller";

    public function __construct() {
        parent::__construct();
    }

    protected function configure() {
        $this
            ->setDescription("Delete a controller")
            ->setHelp("Delete a controller")
            ->addArgument("controller", InputArgument::REQUIRED, "controller name");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        list($dirname, $filename) = BaseCommand::dir_and_file($input);

        if (!file_exists($dirname . '/' . $filename)) {
            return $output->writeln("<error>Controller does not exist!</error>");
        }

        unlink($dirname . '/' . $filename);

        return $output->writeln("<comment>$filename controller deleted successfully</comment>");
    }
}