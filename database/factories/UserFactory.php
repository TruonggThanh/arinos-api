<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'name' => $this->faker->name(),
            'name_romaji' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'sex' => rand(config('constants.sexMale'), config('constants.sexFemale')),
            'date_of_birth' => Carbon::now()->format('Y-m-d'),
            'phone' => $this->faker->phoneNumber,
            'role_id' => rand(1,5),
            'position' =>  Arr::random([config('constants.position1'), config('constants.position2'), config('constants.position3'), config('constants.position4'), config('constants.position5')]),
            'avatar' => $this->faker->name() . '.png',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'status' => rand(config('constants.isActive'), config('constants.isInactive')),
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
