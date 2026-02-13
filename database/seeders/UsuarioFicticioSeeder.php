<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\EPS;
use Modules\SICA\Entities\PopulationGroup;
use Modules\SICA\Entities\PensionEntity;

class UsuarioFicticioSeeder extends Seeder
{
    /**
     * Crea una persona ficticia y un usuario sin ningún rol asignado.
     */
    public function run(): void
    {
        $eps = EPS::first() ?? EPS::create(['name' => 'EPS Por defecto']);
        $poblacion = PopulationGroup::first() ?? PopulationGroup::create(['name' => 'Otro', 'description' => 'Por defecto']);
        $pension = PensionEntity::first() ?? PensionEntity::create(['name' => 'Entidad por defecto', 'description' => 'Seeder']);

        $person = Person::firstOrCreate(
            ['document_number' => 9998887770],
            [
                'document_type' => 'Cédula de ciudadanía',
                'first_name' => 'USUARIO',
                'first_last_name' => 'FICTICIO',
                'second_last_name' => 'SIN ROL',
                'eps_id' => $eps->id,
                'population_group_id' => $poblacion->id,
                'pension_entity_id' => $pension->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'ficticio@ejemplo.com'],
            [
                'nickname' => 'ficticio',
                'person_id' => $person->id,
                'password' => Hash::make('password'),
            ]
        );

        // No se asigna ningún rol (roles()->attach() no se llama).
    }
}
