<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class DeleteFactoryCommand extends Command
{
    protected static $defaultName = "d:factory";

    protected function configure()
    {
        $this
            ->setDescription("Delete a model factory")
            ->setHelp("Delete a model factory")
            ->addArgument("factory", InputArgument::REQUIRED, "factory name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($dirname, $filename) = $this->dir_and_file($input);

        if (file_exists($dirname . $filename)) :
            unlink($dirname . $filename);
            $output->writeln("<comment>$filename deleted successfully</comment>");
        else :
            $output->writeln("<error>Factory does not exist!</error>");
        endif;
    }

    public function dir_and_file($input): array
    {
        $factoriesPath = BaseCommand::factories_path();

        $path_to_factory = Str::singular($input->getArgument("factory"));
        $path_info = pathinfo($path_to_factory);

        $dirname = $path_info["dirname"] == "." ? $factoriesPath : $factoriesPath . $path_info["dirname"];
        $filename = Str::studly($path_info['filename']);

        if (!strpos($filename, "Factory")) {
            $filename .= "Factory";
        }

        $filename .= ".php";

        return [$dirname, $filename];
    }
}
