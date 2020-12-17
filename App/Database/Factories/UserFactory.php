<?php

namespace App\Database\Factories;

use Leaf\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
	// If this model property isn't defined, Leaf will
	// try to generate the model name from the factory name
	public $model = User::class;

	public function definition()
	{
		return [
			'username' => strtolower($this->faker->firstName),
			'name' => $this->faker->name,
			'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => \Leaf\Date::now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'remember_token' => Str::random(10),
		];
	}
}
