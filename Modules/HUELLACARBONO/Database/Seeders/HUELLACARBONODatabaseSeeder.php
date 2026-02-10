<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HUELLACARBONODatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AppTableSeeder::class);
        $this->call(EmissionFactorsTableSeeder::class);
        $this->call(ProductiveUnitsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CreateSuperAdminSeeder::class);
        $this->call(CreateLeaderSeeder::class);
    }
}

