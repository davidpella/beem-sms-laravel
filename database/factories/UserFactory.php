<?php

namespace DavidPella\BeemSms\Database\Factories;

use DavidPella\BeemSms\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
