<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order_Detail>
 */
class Order_DetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_quantity' => random_int(1,10),
            'book_id' =>  random_int(1,10),
            'order_id' =>  random_int(1,10),
        ];
    }
}
