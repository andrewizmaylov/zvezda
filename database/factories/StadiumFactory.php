<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stadium>
 */
class StadiumFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name'        => 'Peace in Greece',
			'slug'        => 'peace_in_greece',
			'description' => $this->faker->paragraph,
			'details'     => [
				'specials' => [],
				'images'   => [],
			],
		];
	}
}
