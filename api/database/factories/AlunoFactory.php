<?php

namespace Database\Factories;

use App\Models\Filial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aluno>
 */
class AlunoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filial_id' => Filial::factory(),
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'objective' => $this->faker->randomElement(['Hipertrofia', 'Emagrecimento', 'Força', 'Resistência']),
            'experience_level' => $this->faker->randomElement(['Iniciante', 'Intermediário', 'Avançado']),
            'health_conditions' => 'Nenhuma',
            'height' => $this->faker->numberBetween(150, 200),
            'weight' => $this->faker->randomFloat(2, 50, 120),
        ];
    }
}
