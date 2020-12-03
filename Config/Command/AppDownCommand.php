<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppDownCommand extends Command
{
    protected static $defaultName = "app:down";

    protected function configure()
    {
        $this
            ->setDescription("Place app in maintainance mode")
            ->setHelp("Set app in maintainance mode");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = BaseCommand::rootpath(".env");
        $envContent = file_get_contents($env);
        $envContent = str_replace(
            'APP_DOWN=false',
            'APP_DOWN=true',
            $envContent
        );
        file_put_contents($env, $envContent);

        $file = BaseCommand::rootpath("index.php");
        $fileContent = file_get_contents($file);
        $fileContent = str_replace(
            ['$app = new Leaf\App;', '$app = new Leaf\App();'],
            '$app = new Leaf\App(["mode" => "down"]);',
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $output->writeln("<comment>App now running in down mode...</comment>");
    }
}
