<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactModel>
 */
class ContactModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->unique()->text(10),
            'email' => $this->faker->unique()->safeEmail(),
            'message' =>$this->faker->unique()->text(100),
        ];
    }
}
