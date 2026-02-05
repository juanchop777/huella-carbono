<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\SICA\Entities\Role;
use Modules\SICA\Entities\Person;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;
use Illuminate\Support\Facades\Hash;

class CreateLeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'lider.huella@cefa.edu.co';
        $password = 'Lider2025';

        // 1. Crear o buscar la persona
        $person = Person::firstOrCreate(
            ['document_number' => '9876543210'],
            [
                'first_name' => 'Lider',
                'first_last_name' => 'Unidad',
                'second_last_name' => 'Productiva',
                'document_type' => 'CC',
                'misena_email' => $email,
            ]
        );

        // 2. Crear o buscar el usuario
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'nickname' => 'LiderHC',
                'person_id' => $person->id,
                'password' => Hash::make($password),
                'email_verified_at' => now()
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->password = Hash::make($password);
            $user->save();
        }

        // 3. Asignar rol Líder
        $role = Role::where('slug', 'huellacarbono.leader')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }

        // 4. Asignar a la primera unidad productiva activa (si existe)
        $unit = ProductiveUnit::where('is_active', true)->first();
        if ($unit) {
            $unit->leader_user_id = $user->id;
            $unit->save();
            $this->command->info('✓ Líder asignado a unidad: ' . $unit->name);
        }

        $this->command->info('');
        $this->command->info('╔═══════════════════════════════════════════════════════╗');
        $this->command->info('║              LÍDER CREADO EXITOSAMENTE               ║');
        $this->command->info('╠═══════════════════════════════════════════════════════╣');
        $this->command->info('║  Email:    ' . $email . '              ║');
        $this->command->info('║  Password: ' . $password . '                                  ║');
        $this->command->info('║  Rol:      Líder Huella de Carbono                    ║');
        $this->command->info('╚═══════════════════════════════════════════════════════╝');
        $this->command->info('');
    }
}
