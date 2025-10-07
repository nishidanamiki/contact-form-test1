<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('ja_JP'); //日本語ロケール

        $prefix = $faker->randomElement(['070', '080', '090']);
        $tel = $prefix . $faker->numerify('########');

            return [
                'category_id' => Category::query()->inRandomOrder()->value('id'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'gender' => $faker->numberBetween(1, 3),
                'email' => $faker->safeEmail,
                'tel' => $tel,
                'address' => $faker->address,
                'building' => $faker->optional()->secondaryAddress,
                'detail' => $faker->realText(20),
            ];
    }
}
