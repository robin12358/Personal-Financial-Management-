<?php

namespace Database\Factories;
use Carbon\Carbon;
use App\Models\Spend;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpendFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spend::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description'=> $this->faker->text(50),
            'amount'=>rand(200,5000),
            'sub_category'=> rand(1,19),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
        ];
    }
}
