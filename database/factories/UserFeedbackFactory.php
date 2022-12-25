<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Source;
use App\Models\Target;
use App\Models\UserFeedback;

class UserFeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserFeedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'source_id' => Source::factory(),
            'target_id' => Target::factory(),
            'content' => $this->faker->paragraphs(3, true),
            'value' => $this->faker->word,
        ];
    }
}
