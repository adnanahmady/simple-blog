<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use App\Repositories\PublicationStatusRepository;
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
            Article::TITLE => fake()->text(maxNbChars: 20),
            Article::CONTENT => fake()->text(),
            Article::AUTHOR => User::factory(),
            Article::STATUS => (new PublicationStatusRepository())->draft(),
            Article::PUBLICATION_DATE => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            Article::STATUS => (new PublicationStatusRepository())->publish(),
            Article::PUBLICATION_DATE => fake()->dateTime(),
        ]);
    }
}
