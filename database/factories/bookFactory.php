<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class bookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'CLE' => date("yy-mm-dd")."_".$this->faker->text(5),
            'category_id' => random_int(1,10),
            'auther_id' => random_int(1,10),
            'publisher_id' => random_int(1,10),
            'copies_number' => random_int(1,50),
            'status' => 'Y'
        ];
    }
}
