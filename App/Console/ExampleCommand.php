<?php
namespace App\Console;

class ExampleCommand extends Command
{
    public $name = "example";
    public $description = "example command's description";
    public $help = "example command's help";

    public function handle()
    {
        $this->comment("example's output");
    }
}
