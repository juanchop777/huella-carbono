<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\SICA\Entities\Role;
use Modules\SICA\Entities\Person;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin.huella@cefa.edu.co';
        $password = 'Admin2025';

        // 1. Crear o buscar la persona
        $person = Person::firstOrCreate(
            ['document_number' => '1234567890'],
            [
                'first_name' => 'Admin',
                'first_last_name' => 'Huella',
                'second_last_name' => 'Carbono',
                'document_type' => 'CC',
                'misena_email' => $email,
            ]
        );

        // 2. Crear o buscar el usuario
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'nickname' => 'AdminHC',
                'person_id' => $person->id,
                'password' => Hash::make($password),
                'email_verified_at' => now()
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->password = Hash::make($password);
            $user->save();
        }

        // 3. Asignar rol Admin
        $role = Role::where('slug', 'huellacarbono.admin')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }

        $this->command->info('');
        $this->command->info('╔═══════════════════════════════════════════════════════╗');
        $this->command->info('║              ADMIN CREADO EXITOSAMENTE               ║');
        $this->command->info('╠═══════════════════════════════════════════════════════╣');
        $this->command->info('║  Email:    ' . $email . '              ║');
        $this->command->info('║  Password: ' . $password . '                                  ║');
        $this->command->info('║  Rol:      Admin Huella de Carbono                    ║');
        $this->command->info('╚═══════════════════════════════════════════════════════╝');
        $this->command->info('');
    }
}
