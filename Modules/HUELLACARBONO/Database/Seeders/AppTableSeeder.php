<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\App;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* Registro o actualización de la nueva aplicación Huella de Carbono */
       App::updateOrCreate(['name' => 'HUELLACARBONO'], [
        'url' => '/huellacarbono/index',
        'color' => '#2e7d32',
        'icon' => 'fas fa-leaf',
        'description' => 'Gestión de Huella de Carbono',
        'description_english' => 'Carbon Footprint Management'
    ]);


        // $this->call("OthersTableSeeder");
    }
}





