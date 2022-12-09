<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Image;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'thumb' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'type' => $this->faker->numberBetween(-10000, 10000),
            'parent_id' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
