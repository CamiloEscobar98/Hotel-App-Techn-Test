<?php

namespace Database\Factories\Localization;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Localization\Country;
use App\Models\Localization\State;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$this->faker->unique()->country,
            'slug' => Str::random(4),
        ];
    }

    /**
     * Configure the factory.
     * 
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Country $country) {
            $randomStates = mt_rand(0, 8);
            State::factory()->count($randomStates)->create(['country_id' => $country->id]);
        });
    }
}
