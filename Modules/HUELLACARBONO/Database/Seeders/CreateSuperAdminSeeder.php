<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\SICA\Entities\Role;
use Modules\SICA\Entities\Person;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Crear o buscar la persona
        $person = Person::firstOrCreate(
            ['document_number' => '1081152302'],
            [
                'first_name' => 'Juan Manuel',
                'first_last_name' => 'Mosquera',
                'second_last_name' => 'Vargas',
                'document_type' => 'CC',
                'misena_email' => 'catfished03@gmail.com',
            ]
        );

        if ($person->wasRecentlyCreated) {
            $this->command->info('✓ Persona creada: Juan Manuel Mosquera Vargas');
        } else {
            $this->command->info('✓ Persona encontrada: Juan Manuel Mosquera Vargas');
        }

        // 2. Crear o buscar el usuario
        $user = User::firstOrCreate(
            ['email' => 'catfished03@gmail.com'],
            [
                'nickname' => 'JuanMa',
                'person_id' => $person->id,
                'password' => Hash::make('Jumo2302'),
                'email_verified_at' => now()
            ]
        );

        // Si el usuario ya existía, actualizar la contraseña
        if (!$user->wasRecentlyCreated) {
            $user->password = Hash::make('Jumo2302');
            $user->save();
            $this->command->info('✓ Usuario existente - contraseña actualizada.');
        } else {
            $this->command->info('✓ Usuario creado: JuanMa');
        }

        // 3. Asignar rol de SuperAdmin
        $role = Role::where('slug', 'huellacarbono.superadmin')->first();
        
        if ($role) {
            // Usar syncWithoutDetaching para no eliminar otros roles
            $user->roles()->syncWithoutDetaching([$role->id]);
            $this->command->info('✓ Rol SuperAdmin asignado exitosamente.');
        } else {
            $this->command->error('× El rol huellacarbono.superadmin no existe.');
            return;
        }

        $this->command->info('');
        $this->command->info('╔═══════════════════════════════════════════════════════╗');
        $this->command->info('║           SUPERADMIN CREADO EXITOSAMENTE              ║');
        $this->command->info('╠═══════════════════════════════════════════════════════╣');
        $this->command->info('║  Usuario:  Juan Manuel Mosquera Vargas                ║');
        $this->command->info('║  Email:    catfished03@gmail.com                      ║');
        $this->command->info('║  Password: Jumo2302                                   ║');
        $this->command->info('║  Rol:      SuperAdmin Huella de Carbono               ║');
        $this->command->info('╠═══════════════════════════════════════════════════════╣');
        $this->command->info('║  Acceso:   /huellacarbono/superadmin/dashboard        ║');
        $this->command->info('╚═══════════════════════════════════════════════════════╝');
        $this->command->info('');
    }
}





