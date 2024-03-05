<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title_book"=> $this->faker->name,
            "original_price"=> random_int(1,1000),
            "price"=> random_int(1,1000),
            "book_image"=> $this->faker->imageUrl(),
            "description"=> $this->faker->text,
            "id_publisher"=> random_int(1,10),
            "quantity"=> random_int(1,1000),
            "id_author"=> random_int(1,10),
            "id_cate"=> random_int(1,10),
            "sold_quantity"=> random_int(1,10),
        ];
    }
}
