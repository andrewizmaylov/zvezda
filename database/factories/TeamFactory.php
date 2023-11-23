<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$name = $this->faker->word;
		$slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph,
            'logo' => $this->faker->url,
            'banner' => $this->faker->imageUrl,
        ];
    }

	/**
	 * @param  Carbon|null  $date
	 * @return self
	 */
	public function published(Carbon $date = null): self
	{
		return $this->state(
			fn($attributes) => ['published_at' => $date ?? now()],
		);
	}
}
