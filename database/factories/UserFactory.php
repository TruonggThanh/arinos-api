<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => rand(1,20),
            'visiting_card_id' => rand(1,20),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'sex' => rand(config('constants.sexMale'), config('constants.sexFemale')),
            'role_id' => rand(1,5),
            'phone' => $this->faker->phoneNumber,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'status' => rand(config('constants.isActive'), config('constants.isInactive')),
            'is_deleted' => rand(config('constants.isDefault'), config('constants.isDelete')),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
