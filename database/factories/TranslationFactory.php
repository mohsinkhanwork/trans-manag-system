<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locales = ['en', 'fr', 'es', 'de', 'it'];
        $tags = ['web', 'mobile', 'desktop', 'admin', 'public'];
        
        return [
            'key' => $this->faker->unique()->word,
            'value' => $this->faker->sentence,
            'locale' => $this->faker->randomElement($locales),
            'tags' => $this->faker->randomElements($tags, $this->faker->numberBetween(0, 3)),
        ];
    }
}
