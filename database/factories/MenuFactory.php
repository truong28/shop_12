<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name' => $name,
            'parent_id' => $this->faker->numberBetween(0,120),
            'description' => $this->faker->paragraph(),
            'content' =>  $this->faker->paragraph(),
            'slug' => Str::slug($name,'-'),
            'active' => $this->faker->boolean()
        ];
    }
}