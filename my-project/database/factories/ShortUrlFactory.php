<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'short_code' => Str::random(6),
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
