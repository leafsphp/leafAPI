<?php

namespace Config\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class GenerateConsoleCommand extends Command
{
    protected static $defaultName = 'g:command';

    protected $commandsPath;

    public function __construct(){
        parent::__construct();
        $this->commandsPath = dirname(dirname(__DIR__)) . commands_path();
    }

    protected function configure()
    {
        $this 
            ->setDescription("Create a new console command")
            ->setHelp("Create a new leaf console command")
            ->addArgument("consoleCommand", InputArgument::REQUIRED, 'command name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($commandName, $className) = $this->mapNames($input->getArgument("consoleCommand"));

        $file = $this->commandsPath . $className . '.php';

        if (file_exists($file)) {
            $output->writeln("<error>$className already exists!</error>");
        } else {
            if (file_exists($this->commandsPath . ".init")) {
                unlink($this->commandsPath . ".init");
            }

            touch($file);

            $fileContent = \file_get_contents(__DIR__ . '/stubs/console.stub');
            $fileContent = str_replace(['ClassName', 'CommandName'], [$className, $commandName], $fileContent);
            \file_put_contents($file, $fileContent);

            $leafFile = dirname(dirname(__DIR__)) . "/leaf";
            $leafFileContents = file_get_contents($leafFile);
            $leafFileContents = str_replace(
                "\$console = new \Config\Console;",
                "\$console = new \Config\Console;

\$console->registerCustom(\App\Console\\$className::class);",
                $leafFileContents
            );
            \file_put_contents($leafFile, $leafFileContents);

            $output->writeln("<comment>$className generated successfully</comment>");
        }
    }

    protected function mapNames($command)
    {
        $className = $command;

        if (strpos($command, ":")) {
            $commandItems = explode(":", $command);
            $items = [];

            foreach ($commandItems as $item) {
                $items[] = Str::studly($item);
            }

            $className = implode("", $items);
        }

        if (!strpos($className, "Command")) {
            $className .= "Command";
        } else {
            $command = str_replace("Command", "", $command);
        }

        return [Str::lower($command), $className];
    }
}
