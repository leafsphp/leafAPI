<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class GenerateFactoryCommand extends Command
{
    protected static $defaultName = 'g:factory';

    protected function configure()
    {
        $this 
            ->setDescription("Create a new model factory")
            ->setHelp("Create a new model factory")
            ->addArgument("factory", InputArgument::REQUIRED, "factory name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = Str::studly(Str::singular($input->getArgument("factory")));
        $modelName = $factory;
        
        if (!strpos($factory, "Factory")) {
            $factory .= "Factory";
        }

        $file = BaseCommand::factories_path("$factory.php");

        if (file_exists($file)) {
            return $output->writeln("<error>$factory already exists</error>");
        }

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . "/stubs/factory.stub");
        $fileContent = str_replace(
            ["ClassName", "ModelName"],
            [$factory, $modelName],
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $output->writeln("<comment>$factory generated successfully</comment>");
    }
}
