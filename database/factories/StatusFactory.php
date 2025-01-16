<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    protected $model = \App\Models\Status::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Sesuaikan dengan field di tabel
        ];
    }
}
