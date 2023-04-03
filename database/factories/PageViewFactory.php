<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WdevRs\LaravelAnalytics\Models\PageView;

class PageViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageView::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => $this->faker->word,
            'path' => $this->faker->url
        ];
    }
}
