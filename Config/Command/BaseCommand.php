<?php

namespace Config\Command;

use Illuminate\Support\Str;

class BaseCommand
{
    public static function dir_and_file($input): array
    {
        $controllerPath = static::controllers_path();
        $path_info = pathinfo($input->getArgument("controller"));

        $dirname = $path_info["dirname"] == "." ? $controllerPath : $controllerPath . $path_info["dirname"];
        $truename = $path_info['filename'];

        if (strpos(Str::plural($truename) . '.php', "Controller")) {
            $filename = Str::studly($truename) . '.php';
        } else {
            $filename = Str::plural($truename) . 'Controller.php';
        }

        return [$dirname, $filename];
    }

    public static function controllers_path($file = null)
    {
        return dirname(dirname(__DIR__)) . controllers_path($file);
    }

    public static function models_path($file = null)
    {
        return dirname(dirname(__DIR__)) . models_path($file);
    }

    public static function migrations_path($file = null)
    {
        return dirname(dirname(__DIR__)) . migrations_path($file);
    }

    public static function seeds_path($file = null)
    {
        return dirname(dirname(__DIR__)) . seeds_path($file);
    }

    public static function commands_path($file = null)
    {
        return dirname(dirname(__DIR__)) . commands_path($file);
    }

    public static function helpers_path($file = null)
    {
        return dirname(dirname(__DIR__)) . helpers_path($file);
    }
}
