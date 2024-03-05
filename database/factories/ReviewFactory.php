<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "rate"=> $this->faker->numberBetween(0,5),
            "coment"=> $this->faker->text(200),
            "date"=> $this->faker->dateTime("now"),
            "id_customer"=> random_int(1,3),
            'id_book'=> random_int(1,10),

        ];
    }
}
