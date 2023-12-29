<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\PublicationStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Article::TITLE => fake()->title(),
            Article::CONTENT => fake()->text(),
            Article::AUTHOR => User::factory(),
            Article::STATUS => PublicationStatus::factory(),
            Article::PUBLICATION_DATE => fake()->dateTime(),
        ];
    }
}
