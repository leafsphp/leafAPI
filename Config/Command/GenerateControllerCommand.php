<?php

namespace Config\Command;

use InvalidArgumentException;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;
use Config\Command\BaseCommand;

class GenerateControllerCommand extends Command
{
    protected static $defaultName = 'g:controller';

    protected function configure()
    {
        $this
            ->setDescription("Create a new controller class")
            ->setHelp("Create a new controller class")
            ->addArgument("controller", InputArgument::REQUIRED, 'controller name')
            ->addOption("all", "a", InputOption::VALUE_NONE, 'Create a model and migration for controller')
            ->addOption("model", "m", InputOption::VALUE_NONE, 'Create a model for controller')
            ->addOption("resource", "r", InputOption::VALUE_NONE, 'Create a resource controller')
            ->addOption("web", "w", InputOption::VALUE_NONE, 'Create a web(ordinary) controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($dirname, $filename) = BaseCommand::dir_and_file($input);

        if (file_exists($dirname . '/' . $filename)) {
            return $output->writeln("<error>" . str_replace(".php", "", $filename) . " already exists</error>");
        }

        $file = $dirname . '/' . $filename;
        $controller = str_replace(".php", "", $filename);
        touch($file);

        if (!$input->getOption('web')) {
            if (!$input->getOption('resource')) {
                $fileContent = file_get_contents(__DIR__ . '/stubs/apiController.stub');
            } else {
                $fileContent = file_get_contents(__DIR__ . '/stubs/resourceController.stub');
                $fileContent = str_replace(["ModelName"], [Str::singular(Str::studly(str_replace("Controller", "", $controller)))], $fileContent);
            }
        } else {
            $fileContent = file_get_contents(__DIR__ . '/stubs/controller.stub');
        }

        if ($input->getOption('all')) {
            $process = new Process("php leaf g:model " . Str::studly(str_replace("Controller", "", $controller)) . " -m");
            $process->run();
            $output->writeln(Str::singular(Str::studly(str_replace("Controller", "", $controller))) . " model generated successfully with migration");
        } elseif ($input->getOption('model')) {
            $process = new Process("php leaf g:model " . Str::studly(str_replace("Controller", "", $controller)));
            $process->run();
            $output->writeln(Str::singular(Str::studly(str_replace("Controller", "", $controller))) . " model generated successfully");
        }

        $fileContent = str_replace(["ClassName"], [$controller], $fileContent);
        file_put_contents($file, $fileContent);

        return $output->writeln("<comment>$controller created successfully<comment>");
    }
}
