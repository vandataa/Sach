<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name,
            'date'=>$this->faker->date,
            'id_customer'=>$this->faker->numberBetween(1,3),
            'address'=>$this->faker->address,
            'email'=>$this->faker->email,
            'phone'=>$this->faker->phoneNumber,
            'total'=>$this->faker->numberBetween(1,100000),
            'ship'=>'10000',
            'note'=>$this->faker->numberBetween(1,10),
            'status'=> 'Giao hàng thành công',
            'code_bill'=>$this->faker->numberBetween(1,10),
            'payment'=>'Thanh toán VNPay',
        ];
    }
}
