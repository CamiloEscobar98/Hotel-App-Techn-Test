<?php

namespace Database\Factories\Localization;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Localization\State;
use App\Models\Localization\City;

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$this->faker->unique()->word,
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
        return $this->afterCreating(function (State $state) {
            $randomCities = mt_rand(0, 15);
            City::factory()->count($randomCities)->create(['state_id' => $state->id]);
        });
    }
}
