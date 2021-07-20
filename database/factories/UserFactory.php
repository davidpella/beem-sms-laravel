<?php

namespace DavidPella\BeemSms\Database\Factories;

use DavidPella\BeemSms\Models\TestUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = TestUser::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
