<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * @var array $defaultAvatars
     */
    private array $defaultAvatars = [
        'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars.png',
        'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars-3.png',
        'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars-2.png'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'avatar' => $this->defaultAvatars[random_int(0, 2)],
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'phone_country_id' => 1,
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'is_admin' => false,
            'password' => '12345!Secret_', // password
            'country_id' => 1,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(static function (array $attributes): array {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
