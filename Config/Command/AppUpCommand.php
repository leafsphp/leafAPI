<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppUpCommand extends Command
{
    protected static $defaultName = "app:up";

    protected function configure()
    {
        $this
            ->setDescription("Remove app from maintainance mode")
            ->setHelp("Set app in normal mode");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = BaseCommand::rootpath(".env");
        $envContent = file_get_contents($env);
        $envContent = str_replace(
            'APP_DOWN=true',
            'APP_DOWN=false',
            $envContent
        );
        file_put_contents($env, $envContent);

        $index = BaseCommand::rootpath("index.php");
        $indexContent = file_get_contents($index);
        $indexContent = str_replace(
            '["mode" => "down"]',
            '',
            $indexContent
        );
        file_put_contents($index, $indexContent);

        $output->writeln("<comment>App is now out of down mode...</comment>");
    }
}
