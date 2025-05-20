<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class studentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender=['male','female'];
        return [
            'name' => $this->faker->name,
            'matricule' => random_int(150178,2222310345456),
            'age' => random_int(18,80),
            'gender' => $gender[random_int(0,1)],
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'class' => $this->faker->sentence(3)
        ];
    }
}
