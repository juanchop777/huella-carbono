<?php

namespace Modules\SICA\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SEQ\Entities\App;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()   
    {

        /* Registro o actualización de la nueva aplicación Sistema Integrado de Control Administrativo */
        App::updateOrCreate(['name' => 'SEQ'], [
            'url' => '/seq/index',
            'color' => '#1020b0ff',
            'icon' => 'fas fa-puzzle-piece',
            'description' => 'Sistema Integrado de Control Administrativo',
            'description_english' => 'Integrated Administrative Control Systeme'
        ]);

    }
}
