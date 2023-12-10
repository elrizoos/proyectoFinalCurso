<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Empleado::class;

    public function definition(): array
    {

        $faker = FakerFactory::create();


        $regexPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/';


        $randomValue = '';


        do {
            $randomValue = $faker->asciify('**********');
        } while (!preg_match($regexPattern, $randomValue));

        return [
            'nombre' => $this->faker->name,
            'apellidos' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numerify('########A'),
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'fechaNacimiento' => $this->faker->dateTime,
            'direccion' => $this->faker->address,
            'codigoClase' => '1',
            'foto' => $this->faker->imageUrl(640, 480, 'people'),
            'password' => $faker->regexify('/([A-Za-z0-9]+(_[A-Za-z0-9]+)+)/i'),
        ];
    }
}
