<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name,
            'date_of_birth' => $this->faker->date('2004-03-21'),
            'gender' => $this->faker->boolean(50),
            'place_of_permanent' => $this->faker->streetAddress() . ', ' . $this->faker->country() . ', ' . $this->faker->city() . ', ' . $this->faker->state(),
            'identification_number' => $this->faker->unique()->randomNumber(),
            'date_of_issue' => $this->faker->date(),
            'place_of_issue' => $this->faker->text(50),
            'phone_number' => $this->faker->unique()->tollFreePhoneNumber(),
            'email' => $this->faker->unique()->email(),
            'date_of_employment' => $this->faker->date(),
            'is_marital' => $this->faker->boolean(50),
            'is_working' => true,
            'academic_level' => $this->faker->text(50),
            'qualification' => $this->faker->text(50),
            'social_insurance_number' => $this->faker->unique()->randomNumber(),
        ];
    }
}
