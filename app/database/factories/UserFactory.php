<?php

namespace App\Database\Factories;

use App\Models\User;

class UserFactory extends Factory
{
	// If this model property isn't defined, Leaf will
	// try to generate the model name from the factory name
	public $model = User::class;

	// You define your factory blueprint here
	// It should return an associative array
	public function definition(): array
	{
		return [
            'id' => $this->faker->unique()->numberBetween(0, 200),
			'username' => strtolower(implode("-", explode(" ", $this->faker->name))),
            'fullname' => $this->faker->name,
			'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => \Leaf\Date::now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			// $this->str is defined in the base factory
			'remember_token' => $this->str::random(10),
		];
	}
}
