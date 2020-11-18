<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class GenerateHelperCommand extends Command
{
    protected static $defaultName = 'g:helper';

    public function __construct(){
        $this->helperPath = dirname(dirname(__DIR__)) . helpers_path();
        parent::__construct();
    }

    protected function configure()
    {
        $this 
            ->setDescription("Create a new helper class")
            ->setHelp("Create a new helper class")
            ->addArgument("helper", InputArgument::REQUIRED, 'helper name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($helper, $modelName) = $this->mapNames($input->getArgument("helper"));

        $file = $this->helperPath . $helper . '.php';

        if (file_exists($file)) {
            $output->writeln("<error>$helper already exists!</error>");
        } else {
            if (file_exists($this->helperPath . ".init")) {
                unlink($this->helperPath . ".init");
            }

            touch($file);

            $fileContent = \file_get_contents(__DIR__ . '/stubs/helper.stub');
            $fileContent = str_replace(['ClassName', 'ModelName'], [$helper, $modelName], $fileContent);
            \file_put_contents($file, $fileContent);

            $output->writeln("<comment>$helper generated successfully</comment>");
        }
    }

    protected function mapNames($helperName)
    {
        $modelName = $helperName;

        if (!strpos($helperName, "Helper")) {
            $helperName .= "Helper";
        } else {
            $modelName = str_replace("Helper", "", $modelName);
        }

        return [$helperName, Str::singular($modelName)];
    }
}
