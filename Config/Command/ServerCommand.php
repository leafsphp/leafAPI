<?php 

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ServerCommand extends Command
{
    protected static $defaultName = "serve";

    protected function configure()
    {
        $this
            ->setHelp("Start the leaf app server")
            ->setDescription("Run your Leaf app")
            ->addOption("port", "p", InputOption::VALUE_OPTIONAL, "Port to run Leaf app on", 5500)
            ->addArgument("path", InputArgument::OPTIONAL, "Path to your app (in case you changed it)");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption("port");
        $path = $input->getArgument("path");

        $output->writeln("<comment>Leaf development server started on <info>http://localhost:$port</info></comment>");
        $output->writeln("<info>Happy gardening!!</info>\n");
        $output->writeln(shell_exec("php -S localhost:$port $path"));
    }
}
