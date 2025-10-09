<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Contact;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;
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
                'category_id' => Category::inRandomOrder()->value('id') ?? 1,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'gender' => $faker->numberBetween(1, 3),
                'email' => $faker->safeEmail(),
                'tel' => $tel,
                'address' => $faker->address(),
                'building' => $faker->optional()->secondaryAddress(),
                'detail' => $faker->randomElement([
                    '配送についてのお問い合わせ',
                    '商品の不具合についてのお問い合わせ',
                    'ショップへのお問い合わせ',
                    '商品の交換についてのお問い合わせ',
                    '返品についてのお問い合わせ',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
    }
}
