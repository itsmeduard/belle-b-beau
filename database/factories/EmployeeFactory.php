<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstname,
            'middlename' => $this->faker->middleName,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->phone,
            'birthday' => $this->faker->birthday,

        ];
    }
}
