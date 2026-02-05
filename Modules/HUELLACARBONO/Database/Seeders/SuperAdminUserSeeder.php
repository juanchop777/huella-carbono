<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\SICA\Entities\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buscar o crear usuario
        $user = User::firstOrCreate(
            ['email' => 'catfished03@gmail.com'],
            [
                'nickname' => 'SuperAdmin HC',
                'password' => Hash::make('Jumo2302'),
                'email_verified_at' => now()
            ]
        );

        // Si el usuario ya existía, actualizar la contraseña
        if (!$user->wasRecentlyCreated) {
            $user->password = Hash::make('Jumo2302');
            $user->save();
            $this->command->info('Usuario existente - contraseña actualizada.');
        } else {
            $this->command->info('Nuevo usuario creado.');
        }

        // Asignar rol de SuperAdmin
        $role = Role::where('slug', 'huellacarbono.superadmin')->first();
        
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
            $this->command->info('✓ Rol SuperAdmin asignado exitosamente.');
        } else {
            $this->command->error('× El rol huellacarbono.superadmin no existe. Ejecuta RolesTableSeeder primero.');
        }

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('  CREDENCIALES DE SUPERADMIN');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('  Email:    catfished03@gmail.com');
        $this->command->info('  Password: Jumo2302');
        $this->command->info('  Rol:      SuperAdmin Huella de Carbono');
        $this->command->info('═══════════════════════════════════════');
    }
}





