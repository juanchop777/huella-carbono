<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Consultar la app HUELLACARBONO
        $app = App::where('name', 'HUELLACARBONO')->first();

        if (!$app) {
            $this->command->error('La aplicación HUELLACARBONO no existe. Ejecuta primero el AppTableSeeder.');
            return;
        }

        // Rol SuperAdmin
        $role_superadmin = Role::updateOrCreate(['slug' => 'huellacarbono.superadmin'], [
            'name' => 'SuperAdmin Huella de Carbono',
            'description' => 'SuperAdministrador del módulo Huella de Carbono - Control total',
            'description_english' => 'Carbon Footprint SuperAdmin - Full control',
            'full_access' => 'Si',
            'app_id' => $app->id
        ]);

        // Rol Admin
        $role_admin = Role::updateOrCreate(['slug' => 'huellacarbono.admin'], [
            'name' => 'Admin Huella de Carbono',
            'description' => 'Administrador del módulo Huella de Carbono - Visualización y reportes',
            'description_english' => 'Carbon Footprint Admin - View and reports',
            'full_access' => 'No',
            'app_id' => $app->id
        ]);

        // Rol Líder de Unidad Productiva
        $role_leader = Role::updateOrCreate(['slug' => 'huellacarbono.leader'], [
            'name' => 'Líder de Unidad Productiva',
            'description' => 'Líder encargado de registrar consumos diarios de su unidad',
            'description_english' => 'Productive Unit Leader - Daily consumption registration',
            'full_access' => 'No',
            'app_id' => $app->id
        ]);

        $this->command->info('Roles creados exitosamente.');
        $this->command->info('');
        $this->command->info('Para asignar roles a usuarios, ejecuta:');
        $this->command->info('php artisan tinker');
        $this->command->info('$user = User::where("email", "tu@email.com")->first();');
        $this->command->info('$role = Modules\SICA\Entities\Role::where("slug", "huellacarbono.superadmin")->first();');
        $this->command->info('$user->roles()->attach($role->id);');
    }
}

