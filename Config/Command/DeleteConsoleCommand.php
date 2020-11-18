<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class DeleteConsoleCommand extends Command
{

    protected static $defaultName = "d:command";

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Delete a console command")
            ->setHelp("Delete a console command")
            ->addArgument("file", InputArgument::REQUIRED, "The name of the console file");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($dirname, $filename, $className) = $this->dir_and_file($input);

        if (file_exists($dirname . $filename)) :
            unlink($dirname . $filename);
            $output->writeln("<comment>$filename deleted successfully</comment>");

            $leafFile = dirname(dirname(__DIR__)) . "/leaf";
            $leafFileContents = file_get_contents($leafFile);
            $leafFileContents = str_replace(
                "\$console->registerCustom(\App\Console\\$className::class);",
                "",
                $leafFileContents
            );
            \file_put_contents($leafFile, $leafFileContents);
            
            $output->writeln("<comment>$className command unregistered!</comment>");
        else :
            $output->writeln("<error>Command does not exist!</error>");
        endif;
    }

    public function dir_and_file($input): array
    {
        $commandsPath = dirname(dirname(__DIR__)) . commands_path();

        $path_to_seed = ($input->getArgument("file"));
        $path_info = pathinfo($path_to_seed);

        $dirname = $path_info["dirname"] == "." ? $commandsPath : $commandsPath . $path_info["dirname"];
        $filename = Str::studly($path_info['filename']);

        if (!strpos($filename, "Command")) {
            $filename .= "Command";
        }

        return [$dirname, "$filename.php", $filename];
    }
}
