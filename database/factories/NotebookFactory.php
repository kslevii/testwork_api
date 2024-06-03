<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notebook>
 */
class NotebookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'phone_number' => '89009998877',
            'email' => $this->faker->email,
            'company' => $this->faker->word,
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'src_image' => $this->faker->url,
        ];
    }
}
