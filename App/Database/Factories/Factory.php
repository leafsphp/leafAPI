<?php

namespace App\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * Base Factory Class
 * -----------------
 * Provides methods to run factories. You don't need to edit this file
 */
abstract class Factory
{
    /**
     * Faker class instance
     */
    public $faker;
    
    /**
     * Generated factory data
     */
    protected $data;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = null;

    public function __construct()
    {
        $this->faker = Faker::create();;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //
    }

    /**
     * Create a number of records based on definition
     * 
     * @param int $number The number of records to create
     * 
     * @return array
     */
    public function create(int $number)
    {
        $data = [];

        for ($i=0; $i < $number; $i++) { 
            $data[] = $this->definition();
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Save created records in db
     * 
     * @param \App\Models\Model $model
     * 
     * @return true|Throwable
     */
    public function save($model = null, $useCreate = false)
    {
        $model = $model ?? $this->model ?? $this->getModelName();
        
        try {
            foreach ($this->data as $item) {
                if ($useCreate) {
                    $model::create($item);
                } else {
                    $model = new $model;
                    foreach ($item as $key => $value) {
                        $model->{$key} = $value;
                    }
                    $model->save();
                }
            }

            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Get the default model name
     */
    public function getModelName()
    {
        $class = get_class($this);
        $modelClass = "\App\Models" . Str::studly(str_replace(["App\Database\Factories", "Factory"], "", $class));
        
        if (!class_exists($modelClass)) {
            throw new \Exception("Couldn't retrieve model for " . get_class($this) . ". Add a \$model attribute to fix this.");
        }

        return $modelClass;
    }
}
