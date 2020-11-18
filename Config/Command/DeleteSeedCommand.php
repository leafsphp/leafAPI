<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class DeleteSeedCommand extends Command
{

    protected static $defaultName = "d:seed";

    public function __construct()
    {
        $this->seedsPath = dirname(dirname(__DIR__)) . seeds_path();
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Delete a model seeder")
            ->setHelp("Delete a model seeder")
            ->addArgument("seed", InputArgument::REQUIRED, "seeder name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($dirname, $filename) = $this->dir_and_file($input);

        if (file_exists($dirname . $filename)) :
            unlink($dirname . $filename);
            $output->writeln("<comment>$filename deleted successfully</comment>");
        else :
            $output->writeln("<error>Seeder does not exist!</error>");
        endif;
    }

    public function dir_and_file($input): array
    {
        $seedsPath = dirname(dirname(__DIR__)) . seeds_path();

        $path_to_seed = ($input->getArgument("seed"));
        $path_info = pathinfo($path_to_seed);

        $dirname = $path_info["dirname"] == "." ? $seedsPath : $seedsPath . $path_info["dirname"];
        $filename = Str::studly($path_info['filename']);

        if (!strpos($filename, "Seeder")) {
            $filename .= "Seeder";
        }

        $filename .= ".php";

        return [$dirname, $filename];
    }
}
