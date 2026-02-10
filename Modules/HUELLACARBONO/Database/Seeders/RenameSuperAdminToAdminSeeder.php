<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\SICA\Entities\Role;
use Illuminate\Support\Facades\DB;

/**
 * One-time: migra usuarios de SuperAdmin a Admin y reasigna rol a catfished03@gmail.com
 * Reutiliza el rol huellacarbono.admin existente (actualiza nombre/descripción) y asigna a quienes tenían superadmin.
 */
class RenameSuperAdminToAdminSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('slug', 'huellacarbono.admin')->first();
        $superadminRole = Role::where('slug', 'huellacarbono.superadmin')->first();

        if (!$adminRole) {
            $this->command->warn('Rol huellacarbono.admin no encontrado. Ejecuta RolesTableSeeder primero.');
            return;
        }

        // 1. Actualizar nombre/descripción del rol Admin (por si era el antiguo de solo lectura)
        $adminRole->update([
            'name' => 'Admin Huella de Carbono',
            'description' => 'Administrador del módulo Huella de Carbono - Control total',
            'description_english' => 'Carbon Footprint Admin - Full control',
            'full_access' => 'Si',
        ]);
        $this->command->info('✓ Rol Admin actualizado (nombre y permisos).');

        // 2. Migrar usuarios que tenían SuperAdmin al rol Admin
        if ($superadminRole) {
            $userIds = DB::table('role_user')->where('role_id', $superadminRole->id)->pluck('user_id');
            foreach ($userIds as $userId) {
                $u = User::find($userId);
                if ($u) {
                    $u->roles()->detach($superadminRole->id);
                    $u->roles()->syncWithoutDetaching([$adminRole->id]);
                }
            }
            $this->command->info('✓ ' . $userIds->count() . ' usuario(s) migrado(s) de SuperAdmin a Admin.');
        }

        // 3. Asegurar que catfished03@gmail.com tenga el rol Admin
        $user = User::where('email', 'catfished03@gmail.com')->first();
        if ($user) {
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
            $this->command->info('✓ Rol Admin asignado a catfished03@gmail.com');
        } else {
            $this->command->warn('Usuario catfished03@gmail.com no encontrado.');
        }
    }
}
