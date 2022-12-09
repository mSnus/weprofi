<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Userinfo;

class UserinfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Userinfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'pricelist' => $this->faker->text,
            'rating' => $this->faker->numberBetween(-10000, 10000),
            'avatar' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
