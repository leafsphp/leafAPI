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
        if (!env("APP_DOWN")) {
            return $output->writeln("<comment>App isn't in down mode...</comment>");
        }

        $env = BaseCommand::rootpath(".env");
        $envContent = file_get_contents($env);
        $envContent = str_replace(
            'APP_DOWN=true',
            'APP_DOWN=false',
            $envContent
        );
        file_put_contents($env, $envContent);

        $file = BaseCommand::rootpath("index.php");
        $fileContent = file_get_contents($file);
        $fileContent = str_replace(
            '$app = new Leaf\App(["mode" => "down"]);',
            '$app = new Leaf\App;',
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $output->writeln("<comment>App is now out of down mode...</comment>");
    }
}
